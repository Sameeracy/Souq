<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles; 
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles; 
    // Products listed by this user (if they are a seller)
    public function products() {
        return $this->hasMany(Product::class, 'seller_id');
    }

    // Order items sold by this user (for the seller inbox)
    public function sellerOrderItems() {
        return $this->hasMany(OrderItem::class, 'seller_id');
    }

    // Orders placed by this user (as a buyer)
    public function orders() {
        return $this->hasMany(Order::class, 'user_id');
    }
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
}
