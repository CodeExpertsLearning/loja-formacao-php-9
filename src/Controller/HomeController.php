<?php
namespace Code\Controller;

use Code\Database\{Query, Connection};

class HomeController
{
    public function index()
    {
        $query = new Query(Connection::getInstance());
    
        // foreach($query->findAll() as $product) {
        //     print $product->name . '<br>';
        // }

        require TEMPLATES . 'index.phtml';
    }
}