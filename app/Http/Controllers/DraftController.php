<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\account_detail;
use Illuminate\Support\Facades\Http; 

class UserDetailController extends Controller
{

    public function checkAccount(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'customer_type' => 'required|in:Individual,Corporate',
            'account_number' => 'required_if:customer_type,Individual',
            'cid' => [
                function ($attribute, $value, $fail) use ($request) {
                    $customerType = $request->input('customer_type');
                    $accountNumber = $request->input('account_number');
    
                    if ($customerType === 'Individual') {
                        $accountDetail = account_detail::where('old_account', $accountNumber)->first();
    
                        if ($accountDetail && property_exists($accountDetail, 'cid') && empty($value)) {
                            $fail('The CID field is required.');
                        }
                    }
                },
            ],
            'phone_number' => [
                function ($attribute, $value, $fail) use ($request) {
                    $customerType = $request->input('customer_type');
                    $accountNumber = $request->input('account_number');
    
                    if ($customerType === 'Individual') {
                        $accountDetail = account_detail::where('old_account', $accountNumber)->first();
    
                        if ($accountDetail && property_exists($accountDetail, 'mobile') && empty($value)) {
                            $fail('The phone number field is required.');
                        }
                    }
                },
            ],
            'phone' => [
                function ($attribute, $value, $fail) use ($request) {
                    $customerType = $request->input('customer_type');
                    $accountNumber = $request->input('old_account_number');
    
                    if ($customerType === 'Corporate') {
                        $accountDetail = account_detail::where('old_account', $accountNumber)->first();
    
                        if ($accountDetail && property_exists($accountDetail, 'mobile') && empty($value)) {
                            $fail('The phone number field is required.');
                        }
                    }
                },
            ],
            'old_account_number' => 'required_if:customer_type,Corporate',
        ]);
    
        // Extract the form data
        $customerType = $validatedData['customer_type'];
        $accountNumber = $validatedData['account_number'];
        $cid = $validatedData['cid'] ?? null;
        $phoneNumber = $validatedData['phone_number'] ?? null;
        $phone = $validatedData['phone'] ?? null;
        $oldAccountNumber = $validatedData['old_account_number'] ?? null;
    
        // Check account existence and account type if customer type is individual
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
            // Check if CID and phone number are associated with the account number
            $accountDetail = account_detail::where('old_account', $accountNumber)->first();
            $associatedCID = $accountDetail->cid;
            $associatedPhone = $accountDetail->mobile;
    
            if (!$associatedCID || !$associatedPhone) {
                // If CID or phone number does not exist, return the data without matching
                return response()->json(['data' => $accountDetail], 200);
            }
    
            // Validate CID and phone number if they exist
            if ($associatedCID === $cid && $associatedPhone === $phoneNumber) {
                // Return the account detail data
                return response()->json(['data' => $accountDetail], 200);
            } elseif($associatedCID !== $cid) {
                return response()->json(['error' => 'CID does not match with the account',
                'error_field' => 'cid',
            ], 400);
            } elseif($associatedPhone !== $phoneNumber){
                return response()->json(['error' => 'Phone Number does not match with the account',
                'error_field' => 'phone_number',
            ], 400);
            } else {
                return response()->json(['error' => 'CID and Phone Number does not match with the account'], 400);
            }
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
    
            // Check if phone number is associated with the account number
            $associatedPhone = $accountDetail->mobile;
    
            if (!$associatedPhone) {
                return response()->json(['data' => $accountDetail], 200);
            }
    
            // Validate phone number if it exists
            if ($associatedPhone === $phone) {
                return response()->json(['data' => $accountDetail], 200);
            } else {
                return response()->json(['error' => 'Phone number does not match with the account',
                'error_field' => 'phoneErrorCor'
            ], 400);
            }
        }
    
        return response()->json(['error' => 'Invalid customer type'], 400);
    }
    
    
    public function checkAccountNumber($accountNumber)
    {
        $exists = account_detail::where('old_account', $accountNumber)->first();

        return response()->json(['exists' => $exists]);
    }

    public function checkAccountPhone($OldaccountNumber)
    {
        $exists = account_detail::where('old_account', $OldaccountNumber)->first();

        return response()->json(['exists' => $exists]);
    }

}



