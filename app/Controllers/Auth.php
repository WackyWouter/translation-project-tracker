<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{

    function __construct()
    {
    }

    public function index()
    {
        $this->view_data["title"] = 'Login';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('login', $this->view_data);
    }

    public function login()
    {
        $usersModel = model(UsersModel::class);
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $errorFound = false;
        $errors = [];

        // Check that username is not empty
        if (strlen(trim($username)) == 0) {
            $errorFound = true;
            $errors['.usernameField'] = 'Username can not be empty.';
        }

        // Check that password is not empty
        if (strlen(trim($password)) == 0) {
            $errorFound = true;
            $errors['.pwdField'] = 'Password can not be empty.';
        }

        if ($errorFound) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok', 'errors' => $errors]);
        } else {
            // Does the username match one in our system and do the passwords match
            $user = $usersModel->findUser($username);

            if (is_null($user)) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'nok', 'errors' => ['.pwdField' => 'Your login credentials don\'t match an account in our system.', '.usernameField' => '']]);
            } else if (!password_verify($password, $user['password'])) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'nok', 'errors' => ['.pwdField' => 'Your login credentials don\'t match an account in our system.', '.usernameField' => '']]);
            } else {

                // create session
                $session = session();
                $session->set([
                    'loggedIn' => true,
                    'username' => $user['username'],
                    'id' => $user['uuid']
                ]);

                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'ok']);
            }
        }
    }

    public function register()
    {
        $this->view_data["title"] = 'Register';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('register', $this->view_data);
    }

    public function createNewUser()
    {
        helper('usefull');
        helper('auth');
        $usersModel = model(UsersModel::class);

        $uuid4 = generateUuid(); // Can be found in Helpers/usefull_helper
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $passwordConf = $this->request->getPost('passwordConfirm');

        $errorFound = false;
        $errors = [];

        // Check if username is unique and valid format
        if (!$usersModel->isUsernameUnique($username)) {
            $errorFound = true;
            $errors['.usernameField'] = 'This username is already in use.';
        } else if (!preg_match('/^[a-zA-Z0-9]{5,}$/', $username)) { // for english chars + numbers only
            // valid username, alphanumeric & longer than or equals 5 chars
            $errorFound = true;
            $errors['.usernameField'] = 'Please enter a valid username.';
        }

        // Check if email is unique and valid format
        if (!$usersModel->isEmailUnique($email)) {
            $errorFound = true;
            $errors['.emailField'] = 'This email is already in use.';
        } else if (!isEmailValid($email)) { // Can be found in Helpers/auth_helper
            $errorFound = true;
            $errors['.emailField'] = 'Please enter a valid email.';
        }

        if (!isPasswordStrEnough($password)) { // Can be found in Helpers/auth_helper
            $errorFound = true;
            $errors['.pwdField'] = 'Password is not strong enough.';
        } else if ($password != $passwordConf) {
            $errorFound = true;
            $errors['.pwdField'] = 'Passwords do not match.';
        }

        if ($errorFound) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok', 'errors' => $errors]);
        } else {
            $usersModel->insertUser([
                'uuid' => $uuid4,
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);

            // create session
            $session = session();
            $session->set([
                'loggedIn' => true,
                'username' => $username,
                'id' => $uuid4
            ]);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'ok']);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        // Redirect to the login page:
        return redirect('loginPage');
    }
}
