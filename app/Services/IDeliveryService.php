<?
namespace App\Services;

interface IDeliveryService
{
    public function send(array $data);

    public function checkOrder(string $ttn);
}