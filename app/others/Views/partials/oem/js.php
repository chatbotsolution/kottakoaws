<script src="<?= base_url(); ?>/public/adminasset/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/bootstrap/js/bootstrap.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/ionicons/ionicons.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/perfect-scrollbar/p-scroll.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/js/eva-icons.min.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/rating/jquery.rating-stars.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/rating/jquery.barrating.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/js/custom.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/switcher/js/switcher.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/moment/moment.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/js/sticky.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/side-menu/sidemenu.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/sidebar/sidebar.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/sidebar/sidebar-custom.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/chart.js/Chart.bundle.min.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/raphael/raphael.min.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/js/apexcharts.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/js/index.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/js/jquery.vmap.sampledata.js"></script>
<script src="<?= base_url(); ?>/public/adminasset/plugins/horizontal-menu/horizontal-menu-2/horizontal-menu.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>/public/adminasset/other/js-profile.js">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
      $('#users-list').DataTable();
  } );
</script>
<script>

    function updtTime(){
        var logoutTime = 1;
        var urll = "<?= base_url(); ?>";

        $.ajax({
            url:"<?= base_url(); ?>/secure/updateTime",
            data:{logoutTime:logoutTime},
            type:'POST',
            success: function(data){
              setTimeout(function(){ updtTime();},5000);           
            }
        });
    }
</script>