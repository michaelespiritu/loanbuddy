<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'role',
    ];


    public function user() : BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function company() : BelongsTo 
    {
        return $this->belongsTo(Company::class);
    }
}
