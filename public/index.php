<?php

require('../vendor/autoload.php');
require("../vendor/larapack/dd/src/helper.php");

use App\Core\Router;
 
$router = new Router();
$router->resolve();