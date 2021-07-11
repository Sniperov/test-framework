<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TaskModel;

class HomeController extends Controller{

    public function index()
    {
        session_start();
        $page = (isset($_GET['page']) && $_GET['page'] !== '') ? $_GET['page'] : 1;
        $sortBy = (isset($_GET['sortBy']) && $_GET['sortBy'] !== '') ? $_GET['sortBy'] : 'id';
        $sorting = (isset($_GET['sorting']) && $_GET['sorting'] !== '') ? $_GET['sorting'] : 'ASC';

        $task = new TaskModel();
        $data = $task->getWithPagination(3, $page, $sortBy, $sorting);
        return $this->view('tasks.index', $data);
    }
}