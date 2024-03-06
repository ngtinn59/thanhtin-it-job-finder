<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Companysize;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanysizesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companysize = Companysize::all();
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $companysize
        ]);
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
    public function show(Companysize $companysize)
    {
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => [
                'name' => $companysize->name,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Companysize $companysize)
    {
        $data = $request->all();


        $companysize->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Companysize updated successfully',
            'data' => $companysize,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Companysize $companysize)
    {
        $companysize->delete();
    }
}
