<?php

use App\Core\Application;

$filename = $_GET['file'] ?? '';

if ($filename):

  
  $file = fopen(Application::$app::$UPLOAD_FOLDER . $_GET['file'], 'r');
  
  $rows = [];
  if ($file !== FALSE) 
  {
    $header = fgetcsv($file);
    
    while (($data = fgetcsv($file)) !== FALSE) 
    {
      if (count($data) > 4) 
      {
        $data[3] = $data[3] . $data[4];
        $data = array_slice($data, 0, 4); // Reduce array back to 4 elements
      }
      
      $data[3] = str_replace(['$', ','], '', $data[3]);
      
      $data[3] = (float)$data[3];
      
      array_push($rows, $data);
    }
    
    fclose($file);
  }
  ?>

<?php if (empty($rows)): ?>
<h1 class="text-2xl font-bold">Can't open the file</h1>
<?php else: ?>
<div class="grid grid-cols-4 px-2">
  <p class="border py-4 font-bold text-center"><?= $header[0] ?></p>
  <p class="border py-4 font-bold text-center"><?= $header[1] ?></p>
  <p class="border py-4 font-bold text-center"><?= $header[2] ?></p>
  <p class="border py-4 font-bold text-center"><?= $header[3] ?></p>
</div>
<?php 
  $income = 0;
  $expense = 0;
  foreach ($rows as $row):
    $isRed = $row[3] <= 0;
    $income += $isRed ? 0 : $row[3];
    $expense += $isRed ? $row[3] : 0;
    ?>
<div class="grid grid-cols-4 px-2">
  <p class="border py-4 text-center"><?= $row[0] ?></p>
  <p class="border py-4 text-center"><?= $row[1] ?></p>
  <p class="border py-4 text-center"><?= $row[2] ?></p>
  <p class="<?= $isRed ? 'text-red-500' : 'text-green-500' ?> border py-4 text-center">$ <?= strval($row[3]) ?></p>
</div>
<?php endforeach ?>
<div class="grid grid-cols-4 px-2">
  <p class="border py-4 text-center col-start-3 font-bold">Total Income:</p>
  <p class="border py-4 text-center col-start-4">$ <?= $income ?></p>
</div>
<div class="grid grid-cols-4 px-2">
  <p class="border py-4 text-center col-start-3 font-bold">Total Expense:</p>
  <p class="border py-4 text-center col-start-4">$ <?= $expense ?></p>
</div>
<div class="grid grid-cols-4 px-2">
  <p class="border py-4 text-center col-start-3 font-bold">Net Total:</p>
  <p class="border py-4 text-center col-start-4">$ <?= $income + $expense ?></p>
</div>
<?php endif ?>
<?php else: ?>
<h1 class="text-2xl font-bold">Must provide filename to open it</h1>
<?php endif ?>