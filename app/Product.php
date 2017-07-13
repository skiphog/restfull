<?php

namespace App;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Product
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $quantity
 * @property string $status
 * @property string $image
 * @property int $seller_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @property-read \App\Seller $seller
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @mixin \Eloquent
 */
class Product extends Model
{
    use SoftDeletes;

    const AVAILABLE_PRODUCT = 'available';

    const UNAVAILABLE_PRODUCT = 'unavailable';

    public $transformer = ProductTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id'
    ];

    protected $hidden = ['pivot'];

    public function isAvailable()
    {
        return $this->status === Product::AVAILABLE_PRODUCT;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
