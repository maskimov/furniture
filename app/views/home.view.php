<?php
    defined('ROOTPATH') OR exit('Access Denied!');
    /**
        * @var Controller\Managers $this
    */
?>

<?php $this->view('header', $data)?>

<div class="px-4 py-5 my-5 text-center">
    <i class="h1 mx-auto mb-4 bi bi-person-raised-hand"></i>
    <h1 class="display-5 fw-bold text-body-emphasis">Привіт, <?=$data['username']?></h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Тут ви зможете переглядати, ставити та виконувати Завдання, налаштовувати Профіль та багато чого іншого</p>
    </div>
  </div>

<?php $this->view('footer', $data)?>