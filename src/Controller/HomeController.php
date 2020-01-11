<?php
namespace Code\Controller;

class HomeController
{
    public function index()
    {
        require TEMPLATES . 'index.phtml';
    }
}