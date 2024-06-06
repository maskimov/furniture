<?php
    defined('ROOTPATH') OR exit('Access Denied!');
    /**
        * @var Controller\Managers $this
    */
?>

<?php $this->view('header', $data)?>

<div class="container px-4 py-5" id="hanging-icons">
    <h2 class="pb-2 border-bottom">Усі завдання</h2>
    <?php if (!empty($data['errors'])):?>
          <div class="alert alert-danger text-center"><?=implode("<br>", $data['errors'])?></div>
    <?php endif; ?>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
        <?php 
        if ($data['tasks']):
        foreach ($data['tasks'] as $task) :?>
            <form class="col d-flex align-items-start" method="post">
                <div class="icon-square text-body-emphasis d-inline-flex align-items-center justify-content-center fs-4 flex-shrink-0 me-3">
                    <i class="h1 mb-4 bi bi-list-task"></i>
                </div>
                <div>
                    <h3 class="fs-2 text-body-emphasis"><b>Завдання <?=$task->id?></b></h3>
                    <p><?=$task->description?></p>
                    <?php if ($data["department"] == 'design'):?>
                        <img class="mb-2" src="<?php echo get_image($task->amount)?>" height="100">
                    <?php endif;?>
                    <h5>Продукт: <b><?=$task->product_id?></b></h5>
                    <h6>Виконавець: <?=$task->performer_id?></h6>
                    <?php if ($data["department"] == 'industrial'):?>
                        <h6>Кількість: <?=$task->amount?></h6>
                    <?php endif;?>
                    <h6>Створено: <?=$task->created?></h6>
                    <input type="hidden" name="id" value="<?=$task->id?>">
                    <input type="hidden" name="product_id" value="<?=$task->product_id?>">
                    <button class="mb-5 btn <?php echo $task->approved ? "btn-secondary" : "btn-primary"?>" <?php if (!$task->performed || $task->approved) echo "disabled"?> name="submit" value="approve">
                        <?php echo $task->performed ? $task->approved ? "Завдання виконано" : "Підтвердити виконання" : "Завдання ще не виконане" ?>
                    </button>
                </div>
            </form>
        <?php endforeach; endif;?>
    </div>
</div>
<div class="px-4 py-5 mx-auto" style="width: 30%">
    <h2 class="pb-2 border-bottom">Створити завдання</h2>
    <?php if (!empty($data['errors_create'])):?>
          <div class="alert alert-danger text-center"><?=implode("<br>", $data['errors_create'])?></div>
    <?php endif; ?>
    <form class="container mx-auto" method="post">
        <div class="d-flex justify-content-between mb-1">
            <label class="w-50 h5 me-2">Продукт:</label>
            <select class="w-50 form-control" name="product">
                <?php if ($data["products"]):
                    foreach ($data["products"] as $product): ?>
                    
                    <option value="<?=$product->id?>">
                        <?=$product->id. " - " .$product->name?>
                    </option>

                <?php endforeach; endif;?>
            </select>
        </div>

        <div class="d-flex justify-content-between mb-1">
            <label class="w-50 h5 me-2">Виконавець:</label>
            <select class="w-50 form-control" name="performer" value="">
                <?php if ($data["workers"]):
                    foreach ($data["workers"] as $worker): ?>
                    
                    <option value="<?=$worker->id?>">
                        <?=$worker->id. " - " .$worker->username?>
                    </option>

                <?php endforeach; endif;?>
            </select>
        </div>

        <?php if ($data["department"] == 'industrial'):?>
            <div class="d-flex justify-content-between mb-1">
                <label class="w-50 h5 me-2">Кількість:</label>
                <input class="w-50 form-control" type="number" name="amount"><br>
            </div>
        <?php endif;?>

        <div class="d-flex justify-content-between mb-1">
            <label class="w-50 h5 me-2">Опис:</label>
            <textarea class="w-50 form-control" rows="3" name="description"></textarea><br>
        </div>
        <button class="btn btn-primary" name="submit" value="create">Створити</button>
    </form>
</div>

<?php $this->view('footer', $data)?>