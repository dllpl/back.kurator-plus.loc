<?php

namespace App\Models\Core;

use App\Models\AuthUserModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;

class User extends AuthUserModel implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'phone',
        'avatar',
        'password',
    ];

    protected $attributeSignificances = [
        'name'       => 0,
        'surname'    => 0,
        'patronymic' => 0,
        'email'      => 0,
        'phone'      => 0,
        'inn'        => 0,
        'birth_date' => 0,
        'gender'     => 0,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'email_verified_at',
    ];

//    protected $casts = [
//        'superuser' => 'boolean',
//    ];

    public function relatedOrganizations(): HasMany
    {
        return $this->hasMany(RelatedOrganization::class);
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class)->orderBy('provider_id');
    }

    public function hasVerifiedEmail()
    {
        return $this->email_verified_at !== null or $this->email === null;
    }
}
