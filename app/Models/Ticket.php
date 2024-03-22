<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'paid' => 'boolean',
    ];

    protected $fillable = [
        'reference', 'paid', 'voucher', 'user_id', 'shift'
    ];
}
