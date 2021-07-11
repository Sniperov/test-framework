<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AdminModel;

class LoginController extends Controller {
    
    public function index()
    {
        return $this->view('login.index');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['username']) || $_POST['username'] === '') {
                return $this->view('login.index', ['error' => 'Username cannot be empty']);
            }
            if (!isset($_POST['password']) || $_POST['password'] === '') {
                return $this->view('login.index', ['error' => 'Password cannot be empty']);
            }
            $adminModel = new AdminModel();
            $admin = $adminModel->firstWhere('username', $_POST['username']);

            if(password_verify($_POST['password'], $admin['password'])){
                session_start();
                session_regenerate_id();
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $_POST['username'];

                header("location: /admin");
            }
            else {
                return $this->view('login.index', ['error' => 'Password or Username is not correct']);
            }
        }
    }
}