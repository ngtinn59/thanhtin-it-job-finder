<?php

namespace App\Http\Controllers\Api\Job;

use App\Mail\ApplicationApproved;
use App\Mail\ApplicationRejected;
use App\Models\Job;
use App\Models\job_user;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tải sẵn thông tin công ty và người ứng tuyển
        $jobs = Job::with('company', 'applicants')->get();

        return response()->json([
            'jobs' => $jobs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(job_user $job_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(job_user $job_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, job_user $job_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(job_user $job_user)
    {
        //
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

    public function getStatistics()
    {
        $user = Auth::guard('sanctum')->user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Load các mối quan hệ của jobs bao gồm jobType
        $user->load(['jobs.jobType', 'jobs.city', 'jobs' => function ($query) {
            $query->withPivot('status');
        }]);

        // Tính số lượng công việc đã ứng tuyển
        $appliedJobCount = $user->jobs->count();


        $jobTypeStatistics = $user->jobs->groupBy(function ($job) {
            $jobType = $job->jobType()->first(); // Lấy đối tượng jobType thay vì collection
            return optional($jobType)->name ?? 'Unknown';
        })->map(function ($jobs) {
            return $jobs->count();
        })->toArray();



        // Tính số lượng công việc đã ứng tuyển theo thành phố
        // Tính số lượng công việc đã ứng tuyển theo thành phố
        $cityStatistics = $user->jobs->groupBy(function ($job) {
            $city = $job->city()->first(); // Lấy đối tượng city thay vì collection
            return optional($city)->name ?? 'Unknown';
        })->map(function ($jobs) {
            return $jobs->count();
        })->toArray();


        // Tạo đối tượng thống kê
        $statistics = [
            'appliedJobCount' => $appliedJobCount,
            'jobTypeStatistics' => $jobTypeStatistics,
            'cityStatistics' => $cityStatistics,
        ];

        return response()->json($statistics, 200);
    }

}
