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
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/dashboard">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Dashboard</span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/ncpitag">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> NPCI Tag Status Check </span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/tagactivation">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> TAG Activation </span>
            </a>
        </li>

        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/fastaginventory">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Fastag Inventory </span>
            </a>
        </li>
    </ul>
</div>