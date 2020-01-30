<?php 
namespace Code\Controller;

use Code\Session\Session;
use Code\Session\Flash;
use Code\View;

class CartController
{
    public function index()
    {
        $cart = Session::get('cart');

        return View::render('cart', compact('cart'));
    }

    public function add()
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('Método não suportado!');
        }

        $item = $_POST['product'];

        if(!Session::has('cart')) {

            $itens = [$item];

        } else {

            $itens = Session::get('cart');
            
            $findItem = array_column($itens, 'id'); 
                
            if(array_search($item['id'], $findItem) !== FALSE) {
                
                $itens = array_map(function($line) use($item){
                                
                    if($line['id'] == $item['id']) {
                        $line['qtd'] += $item['qtd'];
                    }
                
                    return $line;

                }, $itens);
            } else {
                array_push($itens, $item);
            }
        }

        Session::add('cart', $itens);

        Flash::add('success', 'Produto adicionado com sucesso!');
        
        return header('Location: ' . HOME . '/cart');
    }

    public function cancel()
    {
        if(!Session::has('cart')) return header('Location: ' . HOME);
        
        Session::remove('cart');
        return header('Location: ' . HOME);
    }

    public function remove($item)
    {
        if(!Session::has('cart')) return header('Location: ' . HOME);
        
        $cart = Session::get('cart');
        $cart = array_filter($cart, function($line) use($item){
            return $line['id'] != $item;
        });

        $cart = count($cart) ? $cart : null;

        Session::add('cart', $cart);

        return header('Location: ' . HOME . '/cart');
    }
}