<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    function __construct()
    {
        $this->view_data["title"] = 'Dashboard';
        $this->view_data["username"] = session()->get('username');
    }

    public function index()
    {
        $this->view_data['activeNav'] = 'dashboard';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('dashboard', $this->view_data);
    }

    public function allProjects()
    {
        $this->view_data['activeNav'] = 'all projects';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('all-projects', $this->view_data);
    }
}
