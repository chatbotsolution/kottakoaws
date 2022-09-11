<div class="main-sidemenu">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div class="">
                <img alt="user-img" class="avatar avatar-xl brround" src="<?= base_url(); ?>/public/adminasset/img/salesmanager/profileimage/<?= $_SESSION["logged_img"]; ?>"><span class="avatar-status profile-status bg-green"></span>
            </div>
            <div class="user-info">
                <h4 class="font-weight-semibold mt-3 mb-0"><?= $_SESSION['usrName']; ?></h4>
            </div>
        </div>
    </div>
    <ul class="side-menu">
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesmanager/dashboard">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Dashboard</span>
            </a>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Fastag </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/fastaginventory">Fastag Inventory</a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Team Lead </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/addteamlead">Add Team Lead</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/manageteamlead">Manage Team Lead</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Sales Agent </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/managesalesagent">View Field Sales Executive</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/approvesalesagent">Approve Field Sales Executive</a></li>
            </ul>
        </li>

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> OEM </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/requestoem">Request OEM</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/viewrequestedoem">Manage OEM</a></li>
            </ul>
        </li>
      
      	<li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Report </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/newcustomerreport"> New Customer Report </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/salesmanager/existingcustomerreport"> Existing Customer Report </a></li>
            </ul>
        </li>
      
      	<li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesmanager/tagrequest">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label">Sales Agent Tag Request</span>
            </a>
        </li>
      
    </ul>
</div>