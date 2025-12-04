<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'location',
        'latitude',
        'longitude',
        'two_factor_code',
        'two_factor_expires_at',
        'two_factor_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function ontvangers()
    {
        return self::where('role', 'ontvanger')->get();
    }

    public function generateTwoFactorCode()
    {
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();

        // Send the code via email to Mailtrap
        Mail::to($this->email)->send(new \App\Mail\TwoFactorCode($this->two_factor_code));

        return $this->two_factor_code;
    }

    public function verifyTwoFactorCode($code)
    {
        if ((string)$this->two_factor_code === (string)$code && $this->two_factor_expires_at > now()) {
            $this->resetTwoFactorCode();
            return true;
        }

        return false;
    }

    public function resetTwoFactorCode()
    {
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function hasValidTwoFactorCode()
    {
        return $this->two_factor_code && $this->two_factor_expires_at > now();
    }
}
