<h1 class="text-2xl font-bold mb-6">Login</h1>
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