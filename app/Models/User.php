<?php

namespace App\Models;

use App\Traits\ReloadlySystem;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OTIFSolutions\ACLMenu\Traits\ACLUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, ACLUserTrait, Notifiable, HasApiTokens;
    use ReloadlySystem;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'stripe_response' => 'array',
    ];

    public static function admin(){
        return User::first();
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoice');
    }

    public function stripe_payment_methods(){
        return $this->hasMany('App\Models\StripePaymentMethod');
    }

    public function default_stripe_payment_method(){
        return $this->belongsTo('App\Models\StripePaymentMethod','stripe_payment_method_id','id');
    }

    public function account_transactions(){
        return $this->hasMany('App\Models\AccountTransaction')->orderBy('id');
    }

    public function getBalanceValueAttribute(){
        return $this->account_transactions()->orderBy('id','DESC')->first()['ending_balance'];
    }

    public function topups(){
        return $this->hasMany('App\Models\Topup');
    }

    public function files(){
        return $this->hasMany('App\Models\File');
    }

    public function operators(){
        return $this->belongsToMany(Operator::class,'reseller_rates','user_id','operator_id')->withPivot(['international_discount', 'local_discount']);
    }
    public function api_operators(){
        return $this->belongsToMany(Operator::class,'reseller_rates','user_id','operator_id')->as('rates')->withPivot(['international_discount', 'local_discount']);
    }

    public function gift_cards(){
        return $this->belongsToMany(GiftCardProduct::class,'reseller_gift_card_rates','user_id','gift_card_product_id')->withPivot(['discount']);
    }

    public function ips(){
        return $this->hasMany(IpAddress::class,'user_id');
    }

}
