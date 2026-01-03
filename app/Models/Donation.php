<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'amount',
        'message',
        'user_id',
    ];

    public function updates()
    {
        return $this->hasMany(DonationUpdate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
