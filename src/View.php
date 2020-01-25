<?php 
namespace Code;

class View
{
    public static function render($view, $params)
    {
        extract($params);

        require TEMPLATES . $view . '.phtml';
    }
}