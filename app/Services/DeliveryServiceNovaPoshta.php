<?
namespace App\Services;

use App\Services\IDeliveryService;

class DeliveryServiceNovaPoshta implements IDeliveryService
{
    private $sender_address = 'sender_address_nova_poshta';

    public function send(array $data)
    {
        $data['sender_address'] = $this->sender_address;
        //тут мы отправляем на новую почту через их апи и возращаем ТТН
        return (string) mt_rand(10000, 99999);
    }

    public function checkOrder(string $ttn)
    {
        // проверяем валидность ТТН
        return true; // if ttn is valid
    }
}