<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Deal;
use App\Models\Stage;
use App\Models\ZohoToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
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

        $account = Account::find($request->account);
        if ($account === null) {

            $response = [
                'success' => false,
                'message' => 'Not found',
                'fails' => 'account: '.$request->account,
            ];

            return response($response, 422);

        }

        $zohoAccountId = $account->zoho_account_id;
        $zohoAccountName = $account->name;

        $access_token = Redis::get('access_token');

        $headers = [
            'Authorization' => 'Zoho-oauthtoken '.$access_token,
            'Content-Type' => 'application/json',
        ];

        $arr = [
            "data" => [
                [
                    "Deal_Name" => $request->name, 
                    "Stage" => $stage_name,
                    "Pipeline" => 'Pipeline',
                    "Account_Name" => [
                        "name" => $zohoAccountName,
                        "id" => $zohoAccountId,
                    ]
                ]
            ]
        ];
        
        $zohoDeal = Http::withHeaders($headers)->post('https://www.zohoapis.eu/crm/v4/Deals', $arr);
        
        if ($zohoDeal->status() === 201) {
            
            $result = $zohoDeal->object()->data[0];
            $zohoDealId = $result->details->id;
    
            $dataDeal['name'] = $request->name;
            $dataDeal['stage_id'] = $stage_id;
            $dataDeal['account_id'] = $request->account;
            $dataDeal['zoho_deal_id'] = $zohoDealId;

            $deal = Deal::create($dataDeal);
    
            $response = [
                "success" => true,
                "deal_id" => $deal->id,
                "message" => "New deal successfully added"
            ];
    
            return response($response, 200);

        } else {

            $response = [
                'success' => false,
                'message' => 'Zoho error',
                'fails' => json_encode($zohoDeal->body()),
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
