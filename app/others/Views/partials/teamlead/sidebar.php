<div class="main-sidemenu">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div class="">
                <img alt="user-img" class="avatar avatar-xl brround" src="<?= base_url(); ?>/public/adminasset/img/teamlead/profileimage/<?= $_SESSION["logged_img"]; ?>"><span class="avatar-status profile-status bg-green"></span>
            </div>
            <div class="user-info">
                <h4 class="font-weight-semibold mt-3 mb-0"><?= $_SESSION['usrName']; ?></h4>
            </div>
        </div>
    </div>
    <ul class="side-menu">
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/teamlead/dashboard">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Dashboard</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Sales Agent </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/teamlead/addsalesagent"> Add Sales Agent </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/teamlead/managesalesagent"> Manage Sales Agent </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/teamlead/fastaginventory"> Fastag Inventory </a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Customer </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/teamlead/managecustomer"> Manage Customer </a></li>
            </ul>
        </li>
    </ul>
</div>