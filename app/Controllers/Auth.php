<?php

namespace App\Controllers;

use App\Models\CalendarsModel;
use App\Models\UsersModel;

class Auth extends BaseController
{

    function __construct()
    {
        date_default_timezone_set('Europe/London');
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

                $usersModel->updateUser($user['uuid'], [
                    'last_login' => date('Y-m-d H:i:s')
                ]);

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
            $errors['.confPwdField'] = 'Passwords do not match.';
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
                'last_login' => date('Y-m-d H:i:s')
            ]);

            // insert a basic calendar for the user 
            $calendarsModal = model(CalendarsModel::class);
            $uuid4_calendar = generateUuid();
            $calendarsModal->insertCalendar([
                'uuid' => $uuid4_calendar,
                'user_uuid' => $uuid4,
                'name' => 'Work'
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

    public function resetPassword()
    {
        $this->view_data["title"] = 'Reset Password';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;

        return view('reset-password', $this->view_data);
    }

    public function sendPwdResetEmail()
    {
        helper('usefull');
        helper('auth');
        $usersModel = model(UsersModel::class);

        $email = $this->request->getPost('email');
        $errorFound = false;
        $errors = [];

        if (!isEmailValid($email)) { // Can be found in Helpers/auth_helper
            $errorFound = true;
            $errors['.emailField'] = 'Please enter a valid email.';
        }

        if ($errorFound) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok', 'errors' => $errors]);
        } else {
            $user = $usersModel->findUserByEmail($email);

            // No matching user found
            if (is_null($user)) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'ok']);
            } else {
                $resetPwToken = generateUuid(); // Can be found in Helpers/usefull_helper
                $expireDate = date('Y-m-d H:i:s', strtotime('+24 hours'));

                $resetPwToken = base64_encode($resetPwToken . '||' . $expireDate);

                $usersModel->updateUser($user['uuid'], [
                    'reset_pw_token' => $resetPwToken,
                    'token_expire' => date('Y-m-d H:i:s', strtotime('+24 hours'))
                ]);

                $hashlink = "<a href='" . base_url('/resetPw/token/' . $resetPwToken) . "'>reset password</a>";

                $emailService = \Config\Services::email();
                $emailService->setFrom('info@tlprojecttracker.co.uk', 'TPT');
                $emailService->setReplyTo('info@tlprojecttracker.co.uk', 'TPT');
                $emailService->setTo($user['email']);
                $emailService->setSubject('Password Reset');
                $emailService->setMessage("<p>Dear User</p>
                            <p>You are receiving this email because you have asked for your password to be reset.
                                We have given you a temporary link to allow you to reset your password.</p>
                            <p style='height: 30px; padding:3px; padding-bottom:20px;'>$hashlink</p>
                            <p>If you have not requested for your password to be reset then please contact us.</p>
                            <p>Regards</p>
                            <p>Translation Project Tracker (TPT)</p>");

                $result = $emailService->send();

                if ($result) {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['status' => 'ok']);
                } else {
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['status' => 'nok']);
                }
            }
        }
    }

    public function checkToken($token)
    {
        $this->view_data["title"] = 'Reset Password';

        $header = view('components/header', $this->view_data);
        $this->view_data['header'] = $header;

        $footer = view('components/footer', $this->view_data);
        $this->view_data['footer'] = $footer;


        $usersModel = model(UsersModel::class);
        $user = $usersModel->isTokenValid($token);

        $this->view_data['token'] = $token;

        if (is_array($user) && count($user) > 0) {
            return view('new-password', $this->view_data);
        } else {
            return view('invalid-token', $this->view_data);
        }
    }

    public function saveNewPassword()
    {
        helper('auth');
        $usersModel = model(UsersModel::class);

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        $passwordConf = $this->request->getPost('passwordConfirm');

        $errorFound = false;
        $errors = [];

        if (!isPasswordStrEnough($password)) { // Can be found in Helpers/auth_helper
            $errorFound = true;
            $errors['.pwdField'] = 'Password is not strong enough.';
        } else if ($password != $passwordConf) {
            $errorFound = true;
            $errors['.confPwdField'] = 'Passwords do not match.';
        }

        if ($errorFound) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['status' => 'nok', 'errors' => $errors]);
        } else {
            $user = $usersModel->isTokenValid($token);

            if (is_array($user) && count($user) > 0) {

                $usersModel->updateUser($user['uuid'], [
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'reset_pw_token' => null,
                ]);

                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'ok']);
            } else {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['status' => 'nok']);
            }
        }
    }
}
