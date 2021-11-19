<?php $this->layout('templates/layout', ['title' => 'User Profile']) ?>

<?= flash()->display();?>
<h1>About</h1>
<p>About <?=$this->e($title)?></p>
