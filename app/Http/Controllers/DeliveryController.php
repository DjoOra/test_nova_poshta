<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\DeliveryServiceNovaPoshta;

class DeliveryController extends Controller
{
    public function sendParcelData(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string|size:13',
            'email' => 'required|email',
            'delivery_address' => 'required|string|max:255',
            'width' => 'required|int',
            'height' => 'required|int',
            'length' => 'required|int',
            'weight' => 'required|int',
        ]);

        $data = $request->only(['customer_name', 'phone_number', 'email' , 'delivery_address', 'width', 'height', 'length', 'weight', 'delivery_service']);
        // если выбрана новая почта, то создаем обьект класса DeliveryServiceNovaPoshta
        if($request->delivery_service === 'nova_poshta') $deliveryServic = new DeliveryServiceNovaPoshta();
        // если надо добавить курьерскую службу, то создаем новый клас например DeliveryServiceYkrPoshta который реализует интерфейс IDeliveryService
        //и реализуем логику отправки данных о посылке на укр почту в методе send.
        $data['ttn'] = $deliveryServic->send($data);// вызываем метод send который возращает ТТН.
        // тут соxраняем данные в БД
        Order::create($data);
        return redirect('/');
    }

    /*Если у клиента есть проблема с доставкой заказов. Клиент отправляет данные, но поддержка курьерской службы говорит,
         что не получает данные от текущего сервиса.*/

    // Допусти клиен может.проверить валидность заказа
    public function checkOrder($id)
    {
        Order::checkOrder($id);
    }
    // и по своему усмотрению, либо отменить заказ
    public function deleteOrder($id)
    {

    }
    // либо пересоздать
    public function recreateOrder($id)
    {

    }

    // Если много курьерских служб, вместо if надо создать отдельный метод, который по полю $request->delivery_service будет возращать обьект необходимого класса.
}
