<?php

namespace App\Http\Controllers\Api\Companies;

use App\Models\aboutme;
use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Models\Jobtype;
use Illuminate\Http\Request;
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
        $company= $user->companies->id;

        $data = [
            'users_id' => $user->id,
            'company_id' => $company,
            'jobtype_id' => $request->jobtype_id,
            'title' => $request->title,
            'salary' => $request->salary,
            'status' => $request->status,
            'featured' => $request->featured,
            'description' => $request->description,
            'skill_experience' => $request->skill_experience,
            'benefits' => $request->benefits,
            'address' => $request->address,
            'last_date' => $request->last_date,
        ];


        $validator = Validator::make($data, [
            'users_id' => 'required',
            'company_id' => 'required',
            'jobtype_id' => 'required',
            'title' => 'required',
            'salary' => 'required',
            'status' => 'required',
            'featured' => 'required',
            'description' =>'required',
            'last_date' => 'required',
            'address' => 'required',
            'skill_experience' => 'required',
            'benefits' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $job = Job::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $job
        ]);
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
        $data = $request->all();

        $job =$job->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Job updated successfully',
            'data' => $job,
        ]);
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


}
