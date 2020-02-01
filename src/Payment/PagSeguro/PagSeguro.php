<?php 
namespace Code\Payment\PagSeguro;

use PHPSC\PagSeguro\Credentials;
use PHPSC\PagSeguro\Environments\Production;
use PHPSC\PagSeguro\Environments\Sandbox;

use PHPSC\PagSeguro\Customer\Customer;
use PHPSC\PagSeguro\Items\Item;
use PHPSC\PagSeguro\Requests\Checkout\CheckoutService;

class PagSeguro
{
    private $credentials;
    private $enviroment = 'sandbox';
    private $items = [];

    public function __construct()
    {
        $env = $this->enviroment == 'sandbox' ? 
                                     new Sandbox():
                                     new Production();

        $this->credentials = new Credentials(
            PAGSEGURO_EMAIL,
            PAGSEGURO_TOKEN,
            $env
        );
    }

    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }

    public function checkout()
    {
        $service = new CheckoutService($this->credentials);
    
        $checkout = $service->createCheckoutBuilder();

        foreach($this->items as $item) {
            $checkout->addItem(new Item($item['id'], $item['name'], $item['price'], $item['qtd']));     
        }
            
        $response = $service->checkout($checkout->getCheckout());

        return $response->getRedirectionUrl();
    }
}