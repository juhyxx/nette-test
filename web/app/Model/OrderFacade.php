<?php
namespace App\Model;

use Nette;
use GuzzleHttp\Client;

final class OrderFacade
{
	public function __construct(
		private Nette\Database\Explorer $database,
	) {
	}

	public function getOrders()
	{
		return $this->database->query("SELECT Order.id, Order.name, Order.price, Order.currency, Resolver.name as resolver, Order.created_at, Order.updated_at  FROM `Order`  INNER JOIN Resolver ON `Order`.id_resolver = Resolver.id;" );
	}

	public function getOrder($id)
	{
		return $this->database->query("SELECT Order.id, Order.name, Order.price, Order.currency, Resolver.name as resolver, Order.created_at, Order.updated_at  FROM `Order`  INNER JOIN Resolver ON `Order`.id_resolver = Resolver.id where Order.id='" . $id. "';" );
	}

	public function getCurrencyList()
	
	{
		$url = "https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt";
		$client = new \GuzzleHttp\Client();
		$response = $client->request('GET', $url);

		$response->getStatusCode();
		$body = $response->getBody();
		$arr = explode("\n", $body);
		array_shift($arr);//date out
		array_shift($arr);//header out
		array_pop($arr);//last row out

		$result = array();
		foreach ($arr as $value) {
			$rowItems = explode("|", $value);
			if (count($rowItems)> 0 && in_array($rowItems[3], ["EUR", "USD"])) {
				$result[$rowItems[3]] = floatval(str_replace( ",", ".", $rowItems[4]));
			}
		}
		$result["CZK"] = 1;
		return $result;
	}
}