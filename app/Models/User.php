<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject,MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
           'username',
            'email',
            'password',
            'hdpwd',
            'firstname',
            'lastname',
            'fullname',
            'phone',
            'date_of_birth',
            'gender',
            'family_members',
            'address_line_1',
            'address_line_2',
            'city',
            'house_number',
            'thana',
            'district',
            'state',
            'country',
            'zipcode',
            'profilepic',
            'role',
            'device',
            'browse',
            'ipaddress',
            'active_code',
            'isonline',
            'llhid',
            'number_of_locations',
            'item_qnty',
            'total_sum',
            'sc_emsg',
            'sc_ebtnclr',
            'sc_enote',
            'unsc_emsg',
            'customer_id',
            'subscription_id',
            'plan_id',
            'amount',
            'subscription_status',
            'current_period_start',
            'current_period_end',
            'start_date',
            'card_number',
            'card_exp_month',
            'exp_year',
            'name_on_card',
            'reg_step_1',
            'reg_step_2',
            'reg_step_3',
            'reg_step_4', 
            'isprofilecomplete', 
            'status',
            'isdeleted',
            'isapproved',
            'isactivationcomplete',
            'logins',
            'created_by',
            'updated_by',
            'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
