<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barrower extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
    ];
}
