<?php
    defined('ROOTPATH') OR exit('Access Denied!');
    /**
        * @var Controller\Managers $this
    */
?>

<?php $this->view('header', $data)?>

<div class="container">
    <h1>Працівники</h1>
    <p class="lead">Тут ви можете переглянути, редагувати та створювати Працівників Фабрики</p>
    
    <?php if (!empty($data['errors'])):?>
          <div class="alert alert-danger text-center"><?=implode("<br>", $data['errors'])?></div>
    <?php endif; ?>
    
    <?php if($data['department'] == 'industrial'): ?>
    <h2 class="mt-4">Відділ виробництва</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Фото</th>
                <th>Ім'я працівника</th>
                <th>Електронна пошта</th>
                <th>Номер телефону</th>
                <th>Створено</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $workers = $data['workers'];
            if ($workers):
                foreach ($workers as $worker): ?>
                <tr>
                    <form class="form-floating" onsubmit="return confirm('Ви впевнені що хочете продовжити?');" method="post">
                        <input type="hidden" name="id" value="<?=$worker->id?>">
                        <td><img src="<?=get_image($worker->image)?>" style="width: 70px" class="form-control"></td>
                        <td><p class="form-control"><?=$worker->username?></p></td>
                        <td><input class="form-control" type="text" name="email" value="<?=$worker->email?>"></td>
                        <td><input class="form-control" type="text" name="phone" value="<?=$worker->phone?>"></td>
                        <td><p class="form-control"><?=$worker->created?></p></td>
                        <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="edit">Змінити</button></td>
                    </form>
                </tr>
            <?php endforeach; endif;?>
            <tr>
                <form class="form-floating" method="post">
                    <td></td>
                    <input class="form-control" type="hidden" name="department" value="industrial">
                    <td><input class="form-control" type="text" name="username" placeholder="Ім'я працівника"></td>
                    <td><input class="form-control" type="text" name="email" placeholder="Електронна пошта"></td>
                    <td><input class="form-control" type="text" name="phone" placeholder="Номер телефону"></td>
                    <td></td>
                    <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="create">Створити</button></td>
                </form>
            </tr>
        </tbody>        
    </table>
    <?php endif;?>

    <?php if($data['department'] == 'design'): ?>
    <h2 class="mt-4">Відділ дизайну</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Фото</th>
                <th>Ім'я працівника</th>
                <th>Електронна пошта</th>
                <th>Номер телефону</th>
                <th>Створено</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $workers = $data['workers'];
            if ($workers):
                foreach ($workers as $worker): ?>
                <tr>
                    <form class="form-floating" onsubmit="return confirm('Ви впевнені що хочете продовжити?');" method="post">
                        <input type="hidden" name="id" value="<?=$worker->id?>">
                        <td><img src="<?=get_image($worker->image)?>" style="width: 70px" class="form-control"></td>
                        <td><p class="form-control"><?=$worker->username?></p></td>
                        <td><input class="form-control" type="text" name="email" value="<?=$worker->email?>"></td>
                        <td><input class="form-control" type="text" name="phone" value="<?=$worker->phone?>"></td>
                        <td><p class="form-control"><?=$worker->created?></p></td>
                        <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="edit">Змінити</button></td>
                    </form>
                </tr>
            <?php endforeach; endif;?>
            <tr>
                <form class="form-floating" method="post">
                    <td></td>
                    <input class="form-control" type="hidden" name="department" value="design">
                    <td><input class="form-control" type="text" name="username" placeholder="Ім'я працівника"></td>
                    <td><input class="form-control" type="text" name="email" placeholder="Електронна пошта"></td>
                    <td><input class="form-control" type="text" name="phone" placeholder="Номер телефону"></td>
                    <td></td>
                    <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="create">Створити</button></td>
                </form>
            </tr>
        </tbody>        
    </table>
    <?php endif;?>

    <?php if($data['department'] == 'sales'): ?>
    <h2 class="mt-4">Відділ продаж</h2>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>Фото</th>
                <th>Ім'я працівника</th>
                <th>Електронна пошта</th>
                <th>Номер телефону</th>
                <th>Створено</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $workers = $data['workers'];
            if ($workers):
                foreach ($workers as $worker): ?>
                <tr>
                    <form class="form-floating" onsubmit="return confirm('Ви впевнені що хочете продовжити?');" method="post">
                        <input type="hidden" name="id" value="<?=$worker->id?>">
                        <td><img src="<?=get_image($worker->image)?>" style="width: 70px" class="form-control"></td>
                        <td><p class="form-control"><?=$worker->username?></p></td>
                        <td><input class="form-control" type="text" name="email" value="<?=$worker->email?>"></td>
                        <td><input class="form-control" type="text" name="phone" value="<?=$worker->phone?>"></td>
                        <td><p class="form-control"><?=$worker->created?></p></td>
                        <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="edit">Змінити</button></td>
                    </form>
                </tr>
            <?php endforeach; endif;?>
            <tr>
                <form class="form-floating" method="post">
                    <td></td>
                    <input class="form-control" type="hidden" name="department" value="sales">
                    <td><input class="form-control" type="text" name="username" placeholder="Ім'я працівника"></td>
                    <td><input class="form-control" type="text" name="email" placeholder="Електронна пошта"></td>
                    <td><input class="form-control" type="text" name="phone" placeholder="Номер телефону"></td>
                    <td></td>
                    <td><button class="btn btn-secondary rounded-pill px-3" name="submit" value="create">Створити</button></td>
                </form>
            </tr>
        </tbody>        
    </table>
    <?php endif;?>
</div>

<?php $this->view('footer', $data)?>