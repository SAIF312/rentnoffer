<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait, Billable;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [];

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

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function favourites()
    {
        return $this->belongsToMany(Product::class, 'favourites', 'user_id', 'product_id');
    }

    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id');
    }

    public function addressess()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }
    public function primary_address()
    {
        return $this->hasOne(Address::class, 'user_id', 'id')->where('is_primary', 1);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id', 'id');
    }
    public function cards()
    {
        return $this->hasMany(PaymentMethod::class, 'user_id');
    }
    public function payments()
    {
        return $this->belongsTo(Payment::class,'customer','stripe_id');
    }
    // public function messages()
    // {
    //     return $this->hasMany(PaymentMethod::class, 'user_id');
    // }
}
