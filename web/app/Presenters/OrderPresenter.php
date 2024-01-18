<?php
namespace App\Presenters;
use App\Model\OrderFacade;
use Nette;
use Nette\Application\UI\Form;

final class OrderPresenter extends Nette\Application\UI\Presenter
{

	public function __construct(

		private OrderFacade $facade,
	) {
	}

	protected function beforeRender() {
		$this->template->addFilter('currency', function ($value, $targetCurrency, $sourceCurrency) {
			$currencies = $this->facade->getCurrencyList();
			if ($sourceCurrency != "CZK" ) {
				$value = $value * $currencies[$sourceCurrency];
			}
			$value = $value / $currencies[$targetCurrency];
			return   $targetCurrency . " ". round($value, 2);
		});
	}

	public function renderShow(int $orderId): void
	{
		
		$this->template->orders = $this->facade->getOrder($orderId);
	}
}