<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\RecruitmentsResource;
use App\Http\Resources\RecruitmentsResourceCollection;
use App\Models\recruitments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecruitmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recruitments = recruitments::all();
        return (new RecruitmentsResourceCollection($recruitments))->response();
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
    public function show(recruitments $recruitments)
    {
        return (new RecruitmentsResource($recruitments))->response();

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, recruitments $recruitments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(recruitments $recruitments)
    {
        //
    }
}
