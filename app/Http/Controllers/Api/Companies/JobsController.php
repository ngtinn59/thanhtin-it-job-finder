<?php

namespace App\Http\Controllers\Api\Companies;

use App\Mail\JobApplied;
use App\Models\aboutme;
use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Models\Jobtype;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::with('jobtype', 'skill', 'Company')->paginate(5);


        $jobsData = $jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->title,
                'company' => $job->company ? $job->company->name : null,
                'salary' => $job->salary,
                'job_type' => $job->jobtype ? $job->jobtype->pluck('name')->toArray() : null,
                'skills' => $job->skill->pluck('name')->toArray(),
                'address' => $job->address,
                'last_date' => $job->last_date,
                'created_at' => $job->created_at->diffForHumans()
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $jobsData,
            'links' => [
                'first' => $jobs->url(1),
                'last' => $jobs->url($jobs->lastPage()),
                'prev' => $jobs->previousPageUrl(),
                'next' => $jobs->nextPageUrl(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $company = $user->companies->first(); // Assuming you want the first company of the user.

        $validator = Validator::make($request->all(), [
            'jobtype_id' => 'required',
            'city_id' => 'required',
            'title' => 'required',
            'salary' => 'required|numeric',
            'status' => 'required|integer',
            'featured' => 'required|integer',
            'description' =>'required|string',
            'last_date' => 'required|date',
            'address' => 'required|string',
            'skill_experience' => 'required|string',
            'benefits' => 'required|string',
            'job_skills' => 'required|array',  // Validate that job_skills is an array.
            'job_skills.*.name' => 'required|string' // Validate that each skill has a name.
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $validatedData = $validator->validated();

        // Add users_id and company_id to the validated data array.
        $validatedData['users_id'] = $user->id;
        $validatedData['company_id'] = $company ? $company->id : null;

        // You may want to handle the case when a company is not found.
        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'No company found for the user.',
            ], 404);
        }

        // Extract job skills data from the request and remove it from the validated data
        $jobSkillsData = $validatedData['job_skills'];
        unset($validatedData['job_skills']);

        try {
            // Start a transaction
            \DB::beginTransaction();

            // Create the job
            $job = Job::create($validatedData);

            // Attach the job skills to the job
            foreach ($jobSkillsData as $skillData) {
                $job->jobSkills()->create($skillData);
            }

            // Commit the transaction
            \DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => "Job and job skills created successfully.",
                "data" => [
                    'job' => $job,
                    'job_skills' => $job->jobSkills
                ]
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollBack();

            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Job creation failed.',
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        // Lấy các công việc đề xuất
        $jobRecommendation = $this->jobRecommend($job);

        // Tạo một mảng dữ liệu chứa thông tin về công việc và đề xuất công việc
        $responseData = [
            'job' => $job,
            'job_recommendation' => $jobRecommendation
        ];

        // Trả về dữ liệu dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $responseData
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        try {
            // Start a transaction
            \DB::beginTransaction();

            // Update the job with the request data
            $job->update([
                'jobtype_id' => $request->input('jobtype_id'),
                'city_id' => $request->input('city_id'),
                'title' => $request->input('title'),
                'salary' => $request->input('salary'),
                'status' => $request->input('status'),
                'featured' => $request->input('featured'),
                'description' => $request->input('description'),
                'last_date' => $request->input('last_date'),
                'address' => $request->input('address'),
                'skill_experience' => $request->input('skill_experience'),
                'benefits' => $request->input('benefits'),
            ]);

            // If 'job_skills' are provided in the request, update job skills accordingly
// If 'job_skills' are provided in the request, update job skills accordingly
            if ($request->has('job_skills')) {
                $jobSkillsData = $request->input('job_skills');
                $existingSkills = $job->jobSkills()->pluck('name')->toArray();

                // Delete job skills that are not in the updated list
                foreach ($existingSkills as $existingSkill) {
                    if (!in_array($existingSkill, array_column($jobSkillsData, 'name'))) {
                        $job->jobSkills()->where('name', $existingSkill)->delete();
                    }
                }

                // Attach the updated job skills to the job
                foreach ($jobSkillsData as $skillData) {
                    $job->jobSkills()->updateOrCreate(['name' => $skillData['name']], $skillData);
                }
            }

            // Commit the transaction
            \DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => "Job and job skills updated successfully.",
                "data" => [
                    'job' => $job,
                    'job_skills' => $job->jobSkills
                ]
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollBack();

            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Job update failed.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return response()->json([
            'success' => true,
            'message' => 'Job deleted successfully',
        ]);
    }

    public function jobRecommend(Job $job)
    {
        $currentJobSkills = $job->skill->pluck('name')->toArray();

        // Lấy tất cả các công việc khác từ cơ sở dữ liệu
        $otherJobs = Job::with('skill')->where('id', '!=', $job->id)->get();

        // Lọc các công việc khác để chỉ chọn những công việc có ít nhất một kỹ năng giống với công việc hiện tại
        $recommendedJobs = $otherJobs->filter(function ($otherJob) use ($currentJobSkills) {
            // Lấy kỹ năng của công việc khác

            $otherJobSkills = $otherJob->skill->pluck('name')->toArray();

            // Kiểm tra xem công việc khác có chứa ít nhất một kỹ năng của công việc hiện tại không
            $hasSkill = count(array_intersect($currentJobSkills, $otherJobSkills)) > 0;
            return $hasSkill;
        });

        return $recommendedJobs;
    }

    public function apply(Request $request, $id)
    {
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['message' => 'Công việc không tồn tại.'], 404);
        }

        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($job->users()->where('users.id', $user->id)->exists()) {
            return response()->json(['message' => 'Bạn đã ứng tuyển công việc này rồi.'], 409);
        }

        // Process the CV file
        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $cvFileName = time() . '_' . $cv->getClientOriginalName();
            $cv->storeAs('cv', $cvFileName); // Store the CV file in storage/cv directory
        } else {
            $cvFileName = null;
        }

        // Gửi email thông báo về việc ứng tuyển công việc
        Mail::to($user->email)->send(new JobApplied($job, $user, $cvFileName));

        $job->users()->attach($user->id, ['status' => 'pending', 'cv' => $cvFileName]);

        return response()->json(['message' => 'Ứng tuyển công việc thành công.'], 200);
    }
    public function destroyApplication($id) {
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['message' => 'Công việc không tồn tại.'], 404);
        }

        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $job->users()->detach($user->id);

        return response()->json(['message' => 'Xóa ứng tuyển của công việc.'], 200);
    }

    public function applicant()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $appliedJobs = $user->jobs()->withPivot('status')->get();
        return response()->json($appliedJobs, 200);
    }


    public function processApplication(Request $request, $jobId, $userId)
    {
        $job = Job::find($jobId);
        if (!$job) {
            return response()->json(['message' => 'Công việc không tồn tại.'], 404);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại.'], 404);
        }

        $status = $request->input('status');
        if (!in_array($status, ['approved', 'rejected'])) {
            return response()->json(['message' => 'Trạng thái không hợp lệ.'], 400);
        }

        // Update the status of the application
        $job->users()->updateExistingPivot($user->id, ['status' => $status]);

        // Send notification email to the applicant
        if ($status === 'approved') {
            Mail::to($user->email)->send(new ApplicationApproved($job, $user));
        } elseif ($status === 'rejected') {
            Mail::to($user->email)->send(new ApplicationRejected($job, $user));
        }

        return response()->json(['message' => 'Xử lí đơn ứng tuyển thành công.'], 200);
    }

    public function viewAppliedJobs()
    {

        $user = Auth::id();
        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại.'], 404);
        }

        $appliedJobs = Job::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user);
        })->with('company')->get();

        // You can customize the response format as needed
        return response()->json(['user' => $user, 'applied_jobs' => $appliedJobs], 200);
    }

}
