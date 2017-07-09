<?php

namespace App;

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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereVerified($value)
 * @mixin \Eloquent
 */
class Seller extends User
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
