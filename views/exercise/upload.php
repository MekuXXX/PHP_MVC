<h1 class="text-2xl font-bold mb-6">Upload File</h1>
<?php
use App\Core\Form\FORM_TYPE;
  $form = new \App\Core\Form\Form($model);
  $form->begin(method:"post", with_file: true);
?>

<?php $form->field('file', FORM_TYPE::FILE) ?>
<?php $form->button() ?>
<?php $form->end() ?>