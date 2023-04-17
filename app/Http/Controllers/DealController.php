<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationRule = [
            "name" => ["required", "min:3", "max:255", ],
            "stage" => ["required"],
        ];

        $validationData = Validator::make($request->all(), $validationRule);

        if ($validationData->fails()) {

            $response = [
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validationData->errors()
            ];

            return response($response, 422);

        }

        $stage_name = $request->stage;

        $stage = Stage::where('name', $stage_name)->first();
        if ($stage === null) {
            $stage = Stage::create(['name' => $stage_name]);
            $stage_id = $stage->id;
        } else {
            $stage_id = $stage->id;
        }

        $dataDeal['name'] = $request->name;
        $dataDeal['stage_id'] = $stage_id;

        $deal = Deal::create($dataDeal);

        $response = [
            "success" => true,
            "deal_id" => $deal->id,
            "message" => "New deal successfully registered"
        ];

        return response($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
