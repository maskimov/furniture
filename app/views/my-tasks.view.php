<?php
    defined('ROOTPATH') OR exit('Access Denied!');
    /**
        * @var Controller\Managers $this
    */
?>

<?php $this->view('header', $data)?>

<div class="container px-4 py-5" id="hanging-icons">
    <h2 class="pb-2 border-bottom">Мої завдання</h2>
    <?php if (!empty($data['errors'])):?>
          <div class="alert alert-danger text-center"><?=implode("<br>", $data['errors'])?></div>
    <?php endif; ?>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
        <?php 
        if ($data['tasks']):
        foreach ($data['tasks'] as $task) :?>
            <form class="col d-flex align-items-start" method="post" enctype="multipart/form-data">
                <div class="icon-square text-body-emphasis d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <i class="h1 mb-4 bi bi-list-task"></i>
                </div>
                <div>
                    <h3 class="fs-2 text-body-emphasis"><b>Завдання <?=$task->id?></b></h3>
                    <p><?=$task->description?></p>
                    <?php if ($data["department"] == 'design'):?>
                        <form class="d-flex flex-column position-relative" method="post" enctype="multipart/form-data">
                            <img style="width: 300px" src="<?=get_image($task->amount)?>" class="flex-grow-2">
                            <?php if (!$task->approved):?>
                                <div class="d-flex">
                                    <input type="hidden" name="product_name" value="<?=$task->product_id?>">
                                    <input class="form-control" type="file" name="photo">
                                    <button class="btn btn-secondary" name="submit" value="photo" >Завантажити</button>
                                </div>
                            <?php endif;?>
                        </form>
                    <?php endif;?>
                    
                    <h5>Продукт: <b><?=$task->product_id?></b></h5>
                    <?php if ($data["department"] == 'industrial'):?>
                        <h6>Кількість: <?=$task->amount?></h6>
                    <?php endif;?>
                    <h6>Створено: <?=$task->created?></h6>
                    <input type="hidden" name="id" value="<?=$task->id?>">
                    <input type="hidden" name="product_id" value="<?=$task->product_id?>">
                    <button class="mb-5 btn <?php echo $task->approved ? "btn-secondary" : "btn-primary"?>" <?php if ($task->performed || $task->approved) echo "disabled"?> name="submit" value="perform">
                        <?php echo $task->performed ? $task->approved ? "Завдання виконано" : "Завдання чекає на підтвердження" : "Виконати завдання" ?>
                    </button>
                </div>
            </form>
        <?php endforeach; endif;?>
    </div>
</div>

<?php $this->view('footer', $data)?>