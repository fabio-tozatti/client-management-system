<?php

class BaseController
{
    // Método para identificar as views
    protected function view($view, $data = [])
    {
        extract($data);
        require_once "views/{$view}.php";
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit();
    }
}
