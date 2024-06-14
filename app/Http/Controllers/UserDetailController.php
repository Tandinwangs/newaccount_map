<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\account_detail;
use Illuminate\Support\Facades\Http; 

class UserDetailController extends Controller
{

    public function checkAccount(Request $request)
    {

        $validatedData = $request->validate([
            'customer_type' => 'required|in:Individual,Corporate',
            'account_number' => 'required_if:customer_type,Individual',
            'old_account_number' => 'required_if:customer_type,Corporate',
        ]);
    
        // Extract the form data
        $customerType = $validatedData['customer_type'];
        $accountNumber = $validatedData['account_number'];
        $oldAccountNumber = $validatedData['old_account_number'] ?? null;

        if ($customerType === 'Individual') {
            $account = account_detail::where('old_account', $accountNumber)->first();

            if (!$account) {
                return response()->json(['error' => 'Account number does not exist',
                'error_field' => 'oldaccountError',
            ], 404);
            }
        
            if ($account->customer_type !== 'Individual') {
                return response()->json(['error' => 'Account type does not match',
                'error_field' => 'oldaccountError',            
            ], 400);
            }

            $accountDetail = account_detail::where('old_account', $accountNumber)->first();
            return response()->json(['data' => $accountDetail], 200);
    
        } elseif ($customerType === 'Corporate') {
            $accountDetail = account_detail::where('old_account', $oldAccountNumber)->first();
            if (!$accountDetail) {
                return response()->json(['error' => 'Account number does not exist',
                'error_field' => 'oldaccountErrorCor'
            ], 404);
            }
            if ($accountDetail->customer_type !== 'Corporate') {
                return response()->json(['error' => 'Account type does not match',
                'error_field' => 'oldaccountErrorCor'
            ], 400);
            }
            return response()->json(['data' => $accountDetail], 200);
        }
    
        return response()->json(['error' => 'Invalid customer type'], 400);
    }
    
    
    public function checkAccountNumber($accountNumber)
    {
        $exists = account_detail::where('old_account', $accountNumber)->first();

        return response()->json(['exists' => $exists]);
    }


}



