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
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> TAG Activation </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/salesagent/newtagactivation"> New Customer </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/salesagent/tagactivationexisting"> Existing Customer </a></li>
            </ul>
        </li>
      
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Report </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/salesagent/newcustomerreport"> New Customer </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/salesagent/existingcustomerreport"> Existing Customer </a></li>
            </ul>
        </li>

       <!-- <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/pendingtagActivation">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Activate Pending Fastag </span>
            </a>
        </li> -->
      	
      	<li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/wallet">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Wallet </span>
            </a>
        </li>
      
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/fastaginventory">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Fastag Inventory </span>
            </a>
        </li>
      
      	<li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/requestfastag">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Request Fastag </span>
            </a>
        </li>
      <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/requestpermission">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Request Permission </span>
            </a>
        </li>
      
       <?php
           if($_SESSION['salesagentId'] == 1 || $_SESSION['salesagentId'] == 180 || $_SESSION['salesagentId'] == 194 || $_SESSION['salesagentId'] == 5 || $_SESSION['salesagentId'] == 98 || $_SESSION['salesagentId'] == 270){
       ?>
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/salesagent/customeronboarding">
                <i class="material-icons">dashboard</i>
                <span class="side-menu__label"> Onboard Customer </span>
            </a>
        </li>
       <?php      
           }
       ?>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">dashboard</i>
                <span class="side-menu__label"> ICICI BANK </span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/salesagent/requestid"> Request ID </a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/salesagent/iciciwallet"> Wallet </a></li>
            </ul>
        </li>
    </ul>
</div>