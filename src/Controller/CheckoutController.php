<?php 
namespace Code\Controller;

use Code\Payment\PagSeguro\PagSeguro;
use Code\Session\Session;

class CheckoutController
{

    public function proccess()
    {
        $items = Session::get('cart');

        $pagseguro = new PagSeguro();
        $pagseguro = $pagseguro->setItems($items)
                               ->checkout();

        Session::remove('cart');

        return header('Location: ' . $pagseguro);
    }
}