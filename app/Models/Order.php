<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'payment_status',
        'quantity',
        'delivery_status',
        'delivery_location',
        'paid_at'
    ];

    protected $guarded = [
        'created_at',
        'updated_at'
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
