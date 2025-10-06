<?php

// app/Models/Customer.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Customer.php
class Customer extends Model
{
    protected $fillable = ['note','title','comment','customer_name'];
    protected $casts = ['note' => 'integer'];
}
