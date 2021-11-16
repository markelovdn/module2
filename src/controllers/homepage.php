<?php

use src\Connection;
use src\QueryBuilder;

$config = include '../config/db.php';
$qb = new QueryBuilder(Connection::make($config['database']));

$getall = $qb->getAll('post');
$getOne = $qb->getOne('post', 3);
$qb->create('post', [
    'title' => 'New title value'
]);
$qb->update('post', [
    'title' => 'new update title'
], 2);
$qb->delete('post', 15);

echo "<pre>";

var_dump($getall);
var_dump($getOne);
