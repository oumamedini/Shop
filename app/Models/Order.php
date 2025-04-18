<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'is_delivered',   
        'client_name',     
        'client_address',  
        'client_phone',
        'tracking_number',
        'shipping_method',
        'payment_status',
        'payment_method'    
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'is_delivered' => 'boolean',
        'payment_status' => 'string'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
