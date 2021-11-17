<?php
require_once '../vendor/autoload.php';

if($_SERVER['REQUEST_URI']=='/') {
    require '../src/controllers/homepage.php';
}

// Create new Plates instance
$templates = new League\Plates\Engine('../src/views');

// Render a template
echo $templates->render('about', ['title' => 'Jonathan']);

exit;