<!-- <form>
      <input type="button" class="btn btn-danger btn-sm fw-bold" value="Download Database">
</form>  style="width:100%;"-->
  <?php
    if($_SESSION["logged_intype"] == 0){
  ?>
      <a href="<?= base_url(); ?>/secure/downloaddatabase">
          <button class="btn btn-info btn-sm">
               Download Database
           </button>
      </a>
  <?php
    }
  ?>






