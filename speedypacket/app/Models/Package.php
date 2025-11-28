<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_name',
        'recipient_email',
        'recipient_phone',
        'recipient_address',
        'description',
        'weight',
        'status',
        'tracking_number',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function koerier()
    {
        return $this->belongsTo(User::class, 'koerier_id');
    }
}
