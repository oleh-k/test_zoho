<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\ZohoToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
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

        

        $zohoToken = ZohoToken::all();
        $access_token = $zohoToken[0]->access_token;

        $headers = [
            'Authorization' => 'Zoho-oauthtoken '.$access_token,
            'Content-Type' => 'application/json',
        ];

        $arr = [
            "data" => [
                [
                    "Account_Name" => $request->name, 
                    "Website" => $request->website,
                    "Phone" => $request->phone
                ]
            ]
        ];
        
        $zohoAccount = Http::withHeaders($headers)->post('https://www.zohoapis.eu/crm/v4/Accounts', $arr);
        
        if ($zohoAccount->status() === 201) {
            
            $result = $zohoAccount->object()->data[0];
            $zohoAccountId = $result->details->id;
    
            $dataAccount['name'] = $request->name;
            $dataAccount['website'] = $request->website;
            $dataAccount['phone'] = $request->phone;
            $dataAccount['zoho_account_id'] = $zohoAccountId;
            $account = Account::create($dataAccount);
    
            $response = [
                "success" => true,
                "zohoAccountId" => $zohoAccountId,
                "account_id" => $account->id,
                "message" => "New account successfully registered"
            ];

            return response($response, 200);
        } else {

            $response = [
                'success' => false,
                'message' => 'Zoho error',
                'fails' => json_encode($zohoAccount->body()),
            ];

            return response($response, 422);
        }

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
