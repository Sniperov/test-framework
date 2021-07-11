<?php

namespace App\Core;

use App\Core\View;

class Controller {
    public function view($template, $data = null)
    {
        $view = new View($template);
        $view->assign('data', $data);
    }
}