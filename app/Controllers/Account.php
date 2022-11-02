<?php

namespace App\Controllers;

class Account extends BaseController
{

    function __construct()
    {
        $this->view_data["title"] = 'Account';
        $this->view_data["username"] = session()->get('username');
    }

    public function index()
    {
        $this->view_data['activeNav'] = 'profile';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('account', $this->view_data);
    }
}
