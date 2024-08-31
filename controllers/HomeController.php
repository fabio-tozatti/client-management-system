<?php

class HomeController extends BaseController
{
    public function __construct() {
        loadConfig(); 
    }
    public function index()
    {
        $this->view('index');
    }
}
