<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\OrderFacade;

use Nette;


final class HomePresenter extends Nette\Application\UI\Presenter
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
			
			#return  $sourceCurrency . "->" . $targetCurrency . ": ". round($value, 2);
			return   $targetCurrency . " ". round($value, 2);
		});
	}

	public function renderDefault(): void
	{
		$this->template->orders = $this->facade->getOrders();
		$this->template->currency = $this->facade->getCurrencyList();
	}
	
}
