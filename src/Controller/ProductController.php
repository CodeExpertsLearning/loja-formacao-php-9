<?php
namespace Code\Controller;

use Code\Model\Product;
use Code\View;

class ProductController
{
    public function show($slug)
    {
        $product = new Product();
        $product = $product->where(['slug' => $slug]);

        return View::render('single', compact('product'));
    }
}