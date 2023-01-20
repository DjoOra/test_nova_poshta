<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\DeliveryServiceNovaPoshta;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'ttn',
        'customer_name',
        'phone_number',
        'email',
        'delivery_address',
        'width',
        'height',
        'length',
        'weight',
        'delivery_service'
    ];

    public static function checkOrder($id)
    {
        $order = Order::find($id);
        if($order->delivery_service === 'nova_poshta') $deliveryServic = new DeliveryServiceNovaPoshta();

        return $deliveryServic->checkOrder($order->ttn);

    }
}
