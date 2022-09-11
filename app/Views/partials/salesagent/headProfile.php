<a class="profile-user d-flex" href="#"><img alt="" src="<?= base_url(); ?>/public/adminasset/img/salesagent/profileimage/<?= $_SESSION["logged_img"]; ?>"></a>
<div class="dropdown-menu">
    <div class="main-header-profile bg-primary p-3">
        <div class="d-flex wd-100p">
            <div class="main-img-user"><img alt="" src="<?= base_url(); ?>/public/adminasset/img/salesagent/profileimage/<?= $_SESSION["logged_img"]; ?>" class=""></div>
            <div class="ml-3 my-auto">
                <h6><?= $_SESSION['usrName']; ?></h6>
                <?php
                if($_SESSION['usrLastLogin'] != ""){ ?>
                    <span>Last Login <?= date('d-m-Y',strtotime($_SESSION['usrLastLogin'])); ?> at <?= date('h:i:s',strtotime($_SESSION['usrLastLogin'])); ?></span>
            <?php    }
                ?>
                
            </div>
        </div>
    </div>
    <a class="dropdown-item" href="<?= base_url(); ?>/salesagent/profile"><i class="fa fa-user-circle" aria-hidden="true"></i>Profile</a>
   <!-- <a class="dropdown-item" href="<?= base_url(); ?>/salesagent/editprofile"><i class="fa fa-cogs" aria-hidden="true"></i> Edit Profile</a> -->
    <a class="dropdown-item" href="<?= base_url(); ?>/salesagent/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out</a>
</div>