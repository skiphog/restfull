<?php

namespace App;

use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Transaction
 *
 * @property int $id
 * @property int $quantity
 * @property int $buyer_id
 * @property int $product_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Buyer $buyer
 * @property-read \App\Product $product
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use SoftDeletes;

    public $transformer = TransactionTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
