<?php
    defined('ROOTPATH') OR exit('Access Denied!');
    /**
        * @var Controller\Managers $this
    */
?>

<?php $this->view('header', $data)?>

<div class="container">
    <h1>Меблі</h1>
    <p class="lead">Тут ви можете переглянути, редагувати та створювати Меблі Фабрики</p>
    
    <?php if (!empty($data['errors'])):?>
          <div class="alert alert-danger text-center"><?=implode("<br>", $data['errors'])?></div>
    <?php endif; ?>
    
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Фото</th>
                <th>Назва</th>
                <th>Опис</th>
                <th>Ціна</th>
                <th>На складі</th>
                <th>Створено</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $products = $data['products'];
            if ($products):
                foreach ($products as $product): ?>
                <tr>
                    <form class="form-floating" onsubmit="return confirm('Ви впевнені що хочете продовжити?');" method="post">
                        <input type="hidden" name="id" value="<?=$product->id?>">
                        <td><img src="<?=get_image($product->image)?>" style="width: 70px" class="form-control"></td>
                        <td><p class="form-control"><?=$product->name?></p></td>
                        <?php if ($data['department'] == 'design'):?>
                            <td><textarea class="form-control" type="text" name="description"><?=$product->description?></textarea></td>
                            <td><input class="form-control" type="text" name="price" value="<?=$product->price?>"></td>
                        <?php else:?>
                            <td><p class="form-control"><?=$product->description?></p></td>
                            <td><p class="form-control"><?=$product->price?></p></td>
                        <?php endif;?>
                        
                        <td><p class="form-control"><?=$product->stock?></p></td>
                        <td><p class="form-control"><?=$product->created?></p></td>
                        <?php if ($data['department'] == 'design'):?>
                            <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="edit">Змінити</button></td>
                        <?php else:?>
                            <td></td>
                        <?php endif;?>
                    </form>
                </tr>
            <?php endforeach; endif;?>
            <?php if ($data['department'] == 'design'):?>
                <tr>
                    <form class="form-floating" method="post">
                        <td></td>
                        <td><input class="form-control" type="text" name="name" placeholder="Назва продукту"></td>
                        <td><textarea class="form-control" type="text" name="description" placeholder="Опис продукту"></textarea></td>
                        <td><input class="form-control" type="text" name="price" placeholder="Ціна"></td>
                        <td></td>
                        <td></td>
                        <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="create">Створити</button></td>
                    </form>
                </tr>
            <?php endif;?>
        </tbody>        
    </table>
</div>

<?php $this->view('footer', $data)?>