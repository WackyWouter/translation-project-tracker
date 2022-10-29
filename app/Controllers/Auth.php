<?php

namespace App\Controllers;

use App\Models\UsersModal;

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

    public function createNewUser()
    {

        $usersModel = model(UsersModal::class);

        $uuid4 = $this->generateUuid();
        var_dump($uuid4);

        $usersModel->insertUser([
            'uuid' => $uuid4,
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        // create session
        session_start();
        session_regenerate_id();
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['name'] = $this->request->getPost('username');
        // $_SESSION['id'] = $uuid4;

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['status' => 'ok']);
    }

    private function generateUuid()
    {
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        return $uuid;
    }
}
