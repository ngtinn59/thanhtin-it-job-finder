<?php

namespace App\Http\Controllers\Api\Job;

use App\Mail\ApplicationApproved;
use App\Mail\ApplicationRejected;
use App\Models\Job;
use App\Models\job_user;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function viewApplicants($jobId)
    {
        $job = Job::find($jobId);
        if (!$job) {
            return response()->json(['message' => 'Công việc không tồn tại.'], 404);
        }

        $applicants = $job->users()->withPivot('status')->get();

        // You can customize the response format as needed
        return response()->json(['job' => $job, 'applicants' => $applicants], 200);
    }

}
