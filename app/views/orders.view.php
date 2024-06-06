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
                <th>Ім'я замовника</th>
                <th>Пошта замовника</th>
                <th>Продукт</th>
                <th>Кількість</th>
                <th>Створено</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $orders = $data['orders'];
            if ($orders):
                foreach ($orders as $order): ?>
                <tr>
                    <td><p class="form-control"><?=$order->customer_name?></p></td>
                    <td><p class="form-control"><?=$order->customer_email?></p></td>
                    <td><p class="form-control"><?=$order->product_id?></p></td>
                    <td><p class="form-control"><?=$order->count?></p></td>
                    <td><p class="form-control"><?=$order->created?></p></td>
                </tr>
            <?php endforeach; endif;?>
            <?php if ($data['department'] == 'sales'):?>
                <tr>
                    <form class="form-floating" method="post">
                        <td><input class="form-control" type="text" name="customer_name" placeholder="Ім'я замовника"></td>
                        <td><input class="form-control" type="text" name="customer_email" placeholder="Пошта замовника"></input></td>
                        <td>
                            <select class="form-control" name="product_id">
                                <?php if ($data["products"]):
                                    foreach ($data["products"] as $product): ?>
                                    
                                    <option value="<?=$product->id?>">
                                        <?=$product->id. " - " .$product->name?>
                                    </option>
                                    
                                    <?php endforeach; endif;?>
                                </select>
                            </td>
                        <td><input class="form-control" type="text" name="count" placeholder="Кількість"></td>
                        <td></td>
                        <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="create">Створити</button></td>
                    </form>
                </tr>
            <?php endif;?>
        </tbody>        
    </table>
</div>

<?php $this->view('footer', $data)?>