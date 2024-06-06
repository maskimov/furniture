<?php
    defined('ROOTPATH') OR exit('Access Denied!');
    /**
        * @var Controller\Managers $this
    */
?>

<?php $this->view('header', $data)?>

<link href="<?=ROOT?>/assets/css/sidebars.css" rel="stylesheet">

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

<div class="container d-flex">
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <span class="fs-4">Налаштування</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
              <a href="<?=ROOT?>/settings/profile" class="nav-link active" aria-current="page">
              <i class="h5 me-2 bi bi-person-fill"></i>
              Профіль
              </a>
          </li>
          <li>
              <a href="<?=ROOT?>/settings/security" class="nav-link link-body-emphasis">
              <i class="h5 me-2 bi bi-person-fill"></i>
              Безпека
              </a>
          </li>
        </ul>
    </div>
    
    <div class="d-flex justify-content-evenly align-items-center w-100 p-3"> 
        <form class="d-flex flex-column flex-grow-1 ms-5 me-5" onsubmit="return confirm('Ви впевнені що хочете продовжити?');" method="post">
            <div class="d-flex mb-3">
                <h6 style="width: 50%">Ім'я користувача:</h6>
                <p class="form-control"><?=$data['username']?></p>
            </div>
            <div class="d-flex mb-3">
                <h6 style="width: 50%">Привілегія:</h6>
                <p class="form-control"><?=$data['privilege']?></p>
            </div>

            <div class="d-flex mb-3">
                <h6 style="width: 50%">Елекронна пошта:</h6>
                <input class="form-control" type="text" name="email" value="<?=$data['email']?>">
            </div>

            <div class="d-flex mb-3">
                <h6 style="width: 50%">Номер телефону:</h6>
                <input class="form-control" type="text" name="phone" value="<?=$data['phone']?>">
            </div>

            <button class="btn btn-secondary rounded-pill px-3 align-self-start w-25 mb-3" name="submit" value="edit">Змінити</button>
            <?php if (!empty($data['errors'])):?>
              <div class="alert alert-danger text-center"><?=implode("<br>", $data['errors'])?></div>
            <?php endif; ?>
        </form>
        
        <form class="d-flex flex-column position-relative" method="post" enctype="multipart/form-data">
          <img src="<?=get_image(user('image'))?>" class="flex-grow-2">
          <div class="d-flex">
            <input class="form-control" type="file" name="photo">
            <button class="btn btn-secondary" name="submit" value="photo">Оновити</button>
          </div>
        </form>
    </div>

</div>

<?php $this->view('footer', $data)?>