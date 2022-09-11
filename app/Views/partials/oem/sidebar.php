<div class="main-sidemenu">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div class="">
                <img alt="user-img" class="avatar avatar-xl brround" src="<?= base_url(); ?>/public/adminasset/img/salesagent/profileimage/<?= $_SESSION["logged_img"]; ?>"><span class="avatar-status profile-status bg-green"></span>
            </div>
            <div class="user-info">
                <h4 class="font-weight-semibold mt-3 mb-0"><?= $_SESSION['usrName']; ?></h4>
            </div>
        </div>
    </div>
    <ul class="side-menu">
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/oem/dashboard">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Dashboard</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/oem/ncpitag">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> NPCI Tag Status Check </span>
            </a>
        </li>
      
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> TAG Activation </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/oem/newtagactivation"> New Customer </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/oem/tagactivationexisting"> Existing Customer </a></li>
            </ul>
        </li>
      
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Report </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/oem/newcustomerreport"> New Customer </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/oem/existingcustomerreport"> Existing Customer </a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/oem/fastaginventory">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Fastag Inventory </span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/oem/requestfastag">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Request Fastag </span>
            </a>
        </li>
      
      
      <!-- add vehicle no. update menu in sidebar -->
      	<li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Vehicle No. Update </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/oem/vehiclenoupdate"> Send Request </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/oem/vehiclenoupdatedata"> View Request </a></li>
            </ul>
        </li>
    </ul>
</div>