<?php
namespace Code\Controller;

use Code\View;
use Code\Model\Product;

class HomeController
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index()
    {
        $products = $this->product->findAll();

        return View::render('index', compact('products'));
    }
}