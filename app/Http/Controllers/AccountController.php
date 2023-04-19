<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all();

        $response = [
            'success' => true,
            'message' => 'OK',
            'data' => $accounts
        ];
        
        return response($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validationRule = [
            "name" => ["required", "min:3", "max:255", ],
            "website" => ["required", "regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i"],
            "phone" => ["required", "regex:/^[\+]{0,1}380([0-9]{9})$/"],
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

        $account = Account::create($request->all());

        $response = [
            "success" => true,
            "account_id" => $account->id,
            "message" => "New account successfully registered"
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
