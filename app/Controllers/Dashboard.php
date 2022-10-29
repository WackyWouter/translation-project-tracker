<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    function __construct()
    {
        $this->view_data["title"] = 'Dashboard';
    }

    public function index()
    {
        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('dashboard', $this->view_data);
    }
}
