<?php

namespace App\Controllers;

use App\Models\UsersModel;

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

        $usersModel = model(UsersModel::class);
        $user = $usersModel->getUserById(session()->get('id'));
        $this->view_data['email'] = $user['email'];

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        $footerBar = view('components/footer-bar', $this->view_data);
        $this->view_data['footerBar'] = $footerBar;

        return view('account', $this->view_data);
    }

    public function edit()
    {
        $this->view_data['activeNav'] = 'profile';

        $usersModel = model(UsersModel::class);
        $user = $usersModel->getUserById(session()->get('id'));
        $this->view_data['email'] = $user['email'];

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        $footerBar = view('components/footer-bar', $this->view_data);
        $this->view_data['footerBar'] = $footerBar;

        return view('edit-account', $this->view_data);
    }

    public function save()
    {
        helper('auth');
        $usersModel = model(UsersModel::class);

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');

        $errorFound = false;
        $errors = [];

        // Check if username is unique and valid format
        if (!$usersModel->isUsernameUnique($username, session()->get('id'))) {
            $errorFound = true;
            $errors['.usernameField'] = 'This username is already in use.';
        } else if (!preg_match('/^[a-zA-Z0-9]{5,}$/', $username)) { // for english chars + numbers only
            // valid username, alphanumeric & longer than or equals 5 chars
            $errorFound = true;
            $errors['.usernameField'] = 'Please enter a valid username.';
        }

        // Check if email is unique and valid format
        if (!$usersModel->isEmailUnique($email, session()->get('id'))) {
            $errorFound = true;
            $errors['.emailField'] = 'This email is already in use.';
        } else if (!isEmailValid($email)) {
            $errorFound = true;
            $errors['.emailField'] = 'Please enter a valid email.';
        }

        if ($errorFound) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok', 'errors' => $errors]);
        } else {
            $session = session();

            $usersModel->updateUser($session->get('id'), [
                'username' => $username,
                'email' => $email,
            ]);

            // regen session
            $session->regenerate(true);
            $session->set([
                'loggedIn' => true,
                'username' => $username,
                'id' => $session->get('id')
            ]);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'ok']);
        }
    }

    public function changePassword()
    {
        $this->view_data['activeNav'] = 'profile';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $navbar = view('components/navbar', $this->view_data);
        $this->view_data['navbar'] = $navbar;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        $footerBar = view('components/footer-bar', $this->view_data);
        $this->view_data['footerBar'] = $footerBar;

        return view('edit-password', $this->view_data);
    }

    public function savePassword()
    {
        helper('auth');
        $usersModel = model(UsersModel::class);
        $uuid = session()->get('id');
        $user = $usersModel->getUserById($uuid);

        $password = $this->request->getPost('password');
        $confPassword = $this->request->getPost('confPassword');
        $oldPassword = $this->request->getPost('oldPassword');


        $errorFound = false;
        $errors = [];

        if (!isPasswordStrEnough($password)) { // Can be found in Helpers/auth_helper
            $errorFound = true;
            $errors['.passwordField'] = 'Password is not strong enough.';
        } else if ($password != $confPassword) {
            $errorFound = true;
            $errors['.confPasswordField'] = 'Passwords do not match.';
        }

        if (!password_verify($oldPassword, $user['password'])) {
            $errorFound = true;
            $errors['.oldPasswordField'] = 'Old password is incorrect.';
        }

        if ($errorFound) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok', 'errors' => $errors]);
        } else {

            $usersModel->updateUser($uuid, [
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'ok']);
        }
    }
}
