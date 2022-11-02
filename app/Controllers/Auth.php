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

        $usersModel = model(UsersModel::class);

        $uuid4 = $this->generateUuid();
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
        } else if (!$this->isEmailValid($email)) {
            $errorFound = true;
            $errors['.emailField'] = 'Please enter a valid email.';
        }

        if (!$this->isPasswordStrEnough($password)) {
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

    private function generateUuid()
    {
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex(random_bytes(16)), 4));
        return $uuid;
    }

    private function isEmailValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        //Get host name from email and check if it is valid
        $email_host = array_slice(explode("@", $email), -1)[0];

        // Check if valid IP (v4 or v6). If it is we can't do a DNS lookup
        if (!filter_var($email_host, FILTER_VALIDATE_IP, [
            'flags' => FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE,
        ])) {
            //Add a dot to the end of the host name to make a fully qualified domain name
            // and get last array element because an escaped @ is allowed in the local part (RFC 5322)
            // Then convert to ascii (http://us.php.net/manual/en/function.idn-to-ascii.php)
            $email_host = idn_to_ascii($email_host . '.');

            //Check for MX pointers in DNS (if there are no MX pointers the domain cannot receive emails)
            if (!checkdnsrr($email_host, "MX")) {
                return false;
            }
        }

        return true;
    }

    public function isPasswordStrEnough($pwd)
    {

        if (strlen($pwd) < 8 || !preg_match("#[0-9]+#", $pwd) || !preg_match("#[a-zA-Z]+#", $pwd)) {
            return false;
        }

        return true;
    }
}
