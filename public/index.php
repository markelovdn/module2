<?php
require_once '../vendor/autoload.php';

if($_SERVER['REQUEST_URI']=='/') {
    require '../src/controllers/homepage.php';
}

exit;