<div class="main-sidemenu">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div class="">
                <img alt="user-img" class="avatar avatar-xl brround" src="<?= base_url(); ?>/public/adminasset/img/faces/<?= $_SESSION["logged_img"]; ?>"><span class="avatar-status profile-status bg-green"></span>
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
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Fastag</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/addfastag">Add / Upload Fastag</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/managefasttag">Manage Fastag</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/classofbarcode">Class Of Barcode</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Product</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/addProduct">Add Product</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageProduct">Manage Product</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Sales Manager</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/addsalesmanager">Add Sales Manager</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/managesalesmanager">Manage Sales Manager</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Team Lead</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/approveteamlead">Approve Team Lead</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageteamlead">Manage Team Lead</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Sales Agent</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/approvesalesagent">Approve Sales Agent</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/managesalesagent">Manage Sales Agent</a></li>
            </ul>
        </li>


        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">OEM</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/addoem">Add OEM</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageoem">Manage OEM</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/approveoem">Approve OEM</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/approveoem">OEM Fastag Request</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Official Users</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/addofficialuser">Add User</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageofficialuser">Manage User</a></li>
            </ul>
        </li>
    </ul>
</div>