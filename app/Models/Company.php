<?php

namespace App\Models;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory, HasUlids;
    

    protected $fillable = [
        'name',
        'company_logo',
        'owner_id',
    ];


    public function owner() : BelongsTo 
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function employees() : HasMany 
    {
        return $this->hasMany(Employee::class);
    }
}
