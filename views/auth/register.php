<h1 class="text-2xl font-bold mb-6">Register</h1>
<?php

use App\Core\Form\FORM_TYPE;

  $form = new \App\Core\Form\Form($model);
  $form->begin(method:"post");
?>

<div class="flex gap-4">
    <?php $form->field('first_name') ?>
    <?php $form->field('last_name') ?>
</div>

<?php $form->field('email', FORM_TYPE::EMAIL) ?>
<?php $form->field('password', FORM_TYPE::PASSWORD)->setPassword() ?>
<?php $form->field('repeat_password', FORM_TYPE::PASSWORD)->setPassword() ?>
<?php $form->button() ?>
<?php $form->end() ?>
<!-- <form action="/register" class="space-y-4" method="post">
  <div>
    <label>Firstname: </label>
    <input type="text" name="first_name">
  </div>

  <div>
    <label>Lastname: </label>
    <input type="text" name="last_name">
  </div>

  <div>
    <label>Email: </label>
    <input type="email" name="email">
  </div>

  <div>
    <label>Password: </label>
    <input type="password" name="password">
  </div>
  

  <div>
    <label>Repeat password: </label>
    <input type="password" name="repeat_password">
  </div>

  <div>
    <button type="submit" class="bg-blue-600 p-2 rounded-lg text-white hover:bg-blue-600/75 transition">Submit</button>
  </div>

</form> -->