<?php

namespace App;

/**
 * App\Buyer
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Buyer whereVerified($value)
 * @mixin \Eloquent
 */
class Buyer extends User
{
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
