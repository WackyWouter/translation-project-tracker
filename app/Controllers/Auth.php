<?php

namespace App\Controllers;

class Auth extends BaseController
{

    function __construct()
    {
        $this->view_data["title"] = 'Login';
    }

    public function index()
    {
        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('login', $this->view_data);
    }

    public function register()
    {
        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('register', $this->view_data);
    }
}
