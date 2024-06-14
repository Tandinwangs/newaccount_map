<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_code',
        'cust_no',
        'new_account',
        'old_account',
        'customer_name1',
        'cid',
        'mobile',
        'customer_type',
        'account_class',
        'account_type'
    ];
}
