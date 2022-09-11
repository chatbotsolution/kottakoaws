<div class="main-sidemenu">
    <div class="app-sidebar__user clearfix">
        <div class="dropdown user-pro-body">
            <div class="">
                <img alt="user-img" class="avatar avatar-xl brround" src="<?= base_url(); ?>/public/adminasset/img/users/profileimage/<?= $_SESSION["logged_img"]; ?>"><span class="avatar-status profile-status bg-green"></span>
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
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_fastag"] == 0) ){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Fastag</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
              <?php
                 if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_edit"] == 0) ){
              ?>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/addfastag">Add / Upload Fastag</a></li>
              <?php
                 }
              ?>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/managefasttag">Manage Fastag</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/classofbarcode">Class Of Vehicle</a></li>              
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/returntag">Rollback Fastag</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/regstrdnumfstg">Registered Number Fastag Request</a></li>
            </ul>
        </li>
      
      <?php
           
         }
      ?>   
      
      
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_product"] == 0) ){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Product</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
              <?php
                 if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_edit"] == 0) ){
              ?>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/addProduct">Add Product</a></li>
              <?php
                 }
              ?>                
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageProduct">Manage Product</a></li>
            </ul>
        </li>
      
      <?php
           
         }
      ?>
      
      
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_users"] == 0) ){
      ?>
      
         <li class="slide">
              <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                  <span class="side-menu__label">Sales Manager</span><i class="angle fe fe-chevron-down"></i></a>
              <ul class="slide-menu">
                <?php
                   if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_edit"] == 0) ){
                ?>
                  <li><a class="slide-item" href="<?= base_url(); ?>/secure/addsalesmanager">Add Sales Manager</a></li>
                <?php
                   }
                ?>                  
                  <li><a class="slide-item" href="<?= base_url(); ?>/secure/managesalesmanager">Manage Sales Manager</a></li>
              </ul>
          </li>

          <li class="slide">
              <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                  <span class="side-menu__label">Team Lead</span><i class="angle fe fe-chevron-down"></i></a>
              <ul class="slide-menu">
                  <li><a class="slide-item" href="<?= base_url(); ?>/secure/approveteamlead"> Approve Team Lead </a></li>
                  <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageteamlead"> Manage Team Lead </a></li>
              </ul>
          </li>

          <li class="slide">
              <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                  <span class="side-menu__label">Sales Agent</span><i class="angle fe fe-chevron-down"></i></a>
              <ul class="slide-menu">
                  <li><a class="slide-item" href="<?= base_url(); ?>/secure/approvesalesagent">Approve Field Sales Executive</a></li>
                  <li><a class="slide-item" href="<?= base_url(); ?>/secure/managesalesagent">Manage Field Sales Executive</a></li>
                  <!-- <li><a class="slide-item" href="<?= base_url(); ?>/secure/managewallet"> Manage Wallet</a></li> -->
              </ul>
          </li>
      
      <?php
           
         }
      ?>
      
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_wallet"] == 0) ){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Manage Wallet</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/managewallet">Wallet Request</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageallwallet">Wallet Transaction</a></li>
            </ul>
        </li>
      
      <?php
           
         }
      ?>

        

        
      
      	
      
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_users"] == 0) ){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">OEM</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
              <?php
               if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_edit"] == 0) ){
              ?>
              <li><a class="slide-item" href="<?= base_url(); ?>/secure/addoem">Add OEM</a></li>
              <?php
               }
              ?>                
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageoem">Manage OEM</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/approveoem">Approve OEM</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/oemstockrequest">OEM Fastag Request</a></li>
              <li><a class="slide-item" href="<?= base_url(); ?>/secure/manufacturer">Manage Manufacturer</a></li>
            </ul>
        </li>
      
      <?php
           
         }
      ?>
      
      
      <?php
         if($_SESSION["logged_intype"] == 0){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Official Users</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/addofficialuser">Add User</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/manageofficialuser">Manage User</a></li>
            </ul>
        </li>
      
      	<li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Data Dashboard</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/newuserdata">New User</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/existinguserdata">Existing User</a></li>
            </ul>
        </li>
      
      <?php
           
         }
      ?> 
      
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_pin"] == 0) ){
      ?>
      
         <li class="slide">
              <a class="side-menu__item" href="<?= base_url(); ?>/secure/managepincode">
                <i class="material-icons">scatter_plot</i>
                  <span class="side-menu__label">Manage PIN Code</span>
              </a>
          </li>
      
      <?php
           
         }
      ?>
      
      
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_banner"] == 0) ){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Banner</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/fsebanner">FSE</a></li>
            </ul>
        </li>
      
      <?php
           
         }
      ?>
      
      <?php
         if($_SESSION["logged_intype"] == 0){
      ?>
        <!--<li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">OTP List</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/otplist/fse">FSE</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/otplist/salesmanager">Sales Manager</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/otplist/teamlead">Team Lead</a></li>
            </ul>
        </li>-->
      
      <?php
           
         }
      ?>


        
	  <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_vehclupdtrqst"] == 0) ){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/vehclupdtreqst">
              <i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Vehicle Update Request</span>
            </a>
        </li>
      
      <?php
           
         }
      ?>
      
      
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_permissionletter"] == 0) ){
      ?>
      
        <li class="slide">
            <a class="side-menu__item" href="<?= base_url(); ?>/secure/permissionletterrequest">
              <i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Permission Letter Request</span>
            </a>
        </li>
      
      <?php
           
         }
      ?>
      
      
      <?php
         if($_SESSION["logged_intype"] == 0 || ($_SESSION["logged_intype"] == 8 && $_SESSION["module_report"] == 0) ){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Report</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/newcustomer">New Customer</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/existingcustomer">Existing Customer</a></li>
            </ul>
        </li>
      
      <?php
           
         }
      ?>
      
      <?php
         if($_SESSION["logged_intype"] == 0){
      ?>
      
         <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">ICICI BANK</span><i class="angle fe fe-chevron-down"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/requestid">Requested Id</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/iciciwallet">Wallet</a></li>
            </ul>
        </li>
      
      <?php
           
         }
      ?>
      
      <?php
         if($_SESSION["logged_intype"] == 0){
      ?>
    
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#"><i class="material-icons">scatter_plot</i>
                <span class="side-menu__label">Sales Territory</span><i class="angle fe fe-chevron-down"></i>
            </a>
            <ul class="slide-menu">
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/salesterritory">Add Sales Territory</a></li>
                <li><a class="slide-item" href="<?= base_url(); ?>/secure/managesalesterritory">Manage Sales Territory</a></li>
            </ul>
        </li>
         <?php
           
         }
      ?>
      
    </ul>
</div>










