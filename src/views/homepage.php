<?php $this->layout('templates/layout', ['title' => 'User Profile']) ?>

<h1>User Profile</h1>

<?php foreach ($post as $title):?>
<?= $title['title'].'<br>' ?>
<?endforeach;?>

