<?php

namespace App\Models;

use App\Core\Model;

class AdminModel extends Model{

    public $table_name = 'admins';

    public $fields = ['id','username','password'];
}