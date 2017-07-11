<?php

namespace App;

use App\Scopes\SellerScope;

/**
 * App\Seller
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property string $verified
 * @property string|null $verification_token
 * @property string $admin
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @mixin \Eloquent
 */
class Seller extends User
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SellerScope());
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
