<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TaskModel;

class TaskController extends Controller {
    public function add()
    {
        session_start();
        return $this->view('tasks.add');
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['username'] == '' || $_POST['email'] == '' || $_POST['text'] == '') {
                return $this->view('tasks.add', ['error' => 'Fill in all the fields']);
            }
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'text' => $_POST['text'],
                'status' => 0,
            ];
            $taskModel = new TaskModel();
            $taskModel->create($data);
            header('location: /?add=true');
        }
    }

    public function edit($id)
    {
        session_start();
        if (is_numeric($id) && $_SESSION['loggedin'] == true) {
            $taskModel = new TaskModel();
            $task = $taskModel->firstById($id);
            return $this->view('tasks.edit', $task);
        }
        return $this->view('404');
    }

    public function update($id)
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['loggedin'] == true) {
            if ($_POST['username'] == '' || $_POST['email'] == '' || $_POST['text'] == '') {
                return $this->view('tasks.add', ['error' => 'Fill in all the fields']);
            }
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'text' => $_POST['text'],
                'status' => $_POST['status'] == null ? 0 : 1,
            ];
            $taskModel = new TaskModel();
            $taskModel->update($id, $data);
            return header('location: /?edit=true');
        }
        return header('location: /');
    }

    public function changeStatus($id)
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['loggedin'] == true) {
            $taskModel = new TaskModel();
            $taskModel->updateColumn($id, 'status', $_POST['status']);

            return true;
        }
    }
}