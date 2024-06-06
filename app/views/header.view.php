<?php
    defined('ROOTPATH') OR exit('Access Denied!');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$data['page']?> · <?=APP_NAME?></title>
    <link href="<?=ROOT?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=ROOT?>/assets/css/headers.css" rel="stylesheet">
    <link href="<?=ROOT?>/assets/css/bootstrap-icons.css" rel="stylesheet">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }

      .bd-mode-toggle {
        z-index: 1500;
      }

      .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
      }
    </style>
</head>
<body>
    <header class="p-3 mb-3 border-bottom">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="<?=ROOT?>/home" class="me-2 mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <i class="h1 mb-4 bi bi-hammer"></i>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="<?=ROOT?>/home" class="nav-link px-2 link-secondary">Головна</a></li>
                    <?php if ($data['isAdmin']): ?>
                        <li><a href="<?=ROOT?>/managers" class="nav-link px-2 link-body-emphasis">Менеджери</a></li>
                        <li><a href="<?=ROOT?>/products/" class="nav-link px-2 link-body-emphasis">Меблі</a></li>
                        <li><a href="<?=ROOT?>/orders/" class="nav-link px-2 link-body-emphasis">Замовлення</a></li>
                    <?php endif; ?>
                    <?php if ($data['isAdmin'] == false && $data['department'] != 'sales'): ?>
                        <li><a href="<?=ROOT?>/tasks/" class="nav-link px-2 link-body-emphasis">Завдання</a></li>
                    <?php endif; ?>
                    <?php if ($data['isManager'] && $data['department'] != 'sales'): ?>
                        <li><a href="<?=ROOT?>/workers/" class="nav-link px-2 link-body-emphasis">Працівники</a></li>
                    <?php endif; ?>
                    <?php if ($data['isManager']): ?>
                        <li><a href="<?=ROOT?>/products/" class="nav-link px-2 link-body-emphasis">Меблі</a></li>
                    <?php endif; ?>
                    <?php if ($data['isManager'] && $data['department'] == 'sales'): ?>
                        <li><a href="<?=ROOT?>/orders/" class="nav-link px-2 link-body-emphasis">Замовлення</a></li>
                    <?php endif; ?>
                </ul>

                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?=get_image(user('image'))?>" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="<?=ROOT?>/settings">Налаштування</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?=ROOT?>/logout">Вийти</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>