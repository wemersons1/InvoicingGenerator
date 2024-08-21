<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoicing extends Model
{
    use HasFactory;
    protected $table = 'invoices';

    protected $hidden = [
        'id',
        'contract_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'entrada' => 'boolean'
    ];
}
