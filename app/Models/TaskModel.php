<?php

namespace App\Models;

use App\Core\Model;

class TaskModel extends Model{

    public $table_name = 'tasks';

    public $fields = ['username', 'email', 'text', 'status'];
}