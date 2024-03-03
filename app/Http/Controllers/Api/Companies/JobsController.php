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
        $jobs = Job::with('jobtype','skill')->get();

        $jobsData = $jobs->map(function ($job) {
            return [
                'title' => $job->title,
                'salary' => $job->salary,
                'job_type' => $job->jobtype ? $job->jobtype->pluck('name')->toArray() : null,
                'skills' => $job->skill->pluck('name')->toArray(),
                'last_date' => $job->last_date,
                'created_at' => $job->created_at->diffForHumans()
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $jobsData
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        //
    }
}
