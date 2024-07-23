<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'barrower_id',
        'loan_amount',
        'interest',
        'duration',
        'frequency_of_payment',
        'start_of_payment_date',
        'penalty',
        'status'
    ];

    public function barrower(): BelongsTo
    {
        return $this->belongsTo(Barrower::class);
    }

}
