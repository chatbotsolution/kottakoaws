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
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/dashboard">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Dashboard</span>
            </a>
        </li>
        <li class="side-item side-item-category">Fast Tag</li>
        
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/addfastag">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Add / Upload FastTag</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/managefasttag">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Manage FastTag</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/dashboard">
                <i class="material-icons">touch_app</i>
                <span class="side-menu__label">Allot FastTag</span>
            </a>
        </li>

        <li class="side-item side-item-category">Sales Manager</li>
        
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/addsalesmanager">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Add Sales Manager</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/managesalesmanager">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Manage Sales Manager</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/dashboard">
                <i class="material-icons">touch_app</i>
                <span class="side-menu__label">Allot FastTag</span>
            </a>
        </li>

        <li class="side-item side-item-category">Team Lead</li>
        
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/addsalesmanager">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Approve Team Lead</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/dashboard">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Manage Team Lead</span>
            </a>
        </li>


        <li class="side-item side-item-category">Sales Agent</li>
        
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/addsalesmanager">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Approve Sales Agent</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/managesalesmanager">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Manage Sales Agent</span>
            </a>
        </li>


        <li class="side-item side-item-category">OEM</li>
        
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/addoem">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Add OEM</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/manageoem">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Manage OEM</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/dashboard">
                <i class="material-icons">touch_app</i>
                <span class="side-menu__label">OEM Request</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/dashboard">
                <i class="material-icons">touch_app</i>
                <span class="side-menu__label">OEM Fast Tag Request</span>
            </a>
        </li>
    </ul>
</div>