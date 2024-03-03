<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Certificate;
use App\Models\Location;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $location = Location::all();
        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $location
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user()->id;
        $data = [
            'users_id' =>$user,
            'name' => $request->input('name'),
        ];


        $validator = Validator::make($data, [
            'users_id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $data = $validator->validated();
        $location = Location::create($data);

        return response()->json([
            'success'   => true,
            'message'   => "success",
            "data" => $location
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //
    }
}
