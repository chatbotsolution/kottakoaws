<style type="text/css">



.modal-content {
 
          /*width: 960px !important;*/

          position: relative;
          height:70% !important;
          overflow: scroll;
          padding: 10px;
 
        }
 
  
 
.modal-header {
 
    
    padding:16px 16px;
 
    
 
 }
 @media (min-width: 576px){
.modal-dialog {
    max-width: 90%!important;
    height:120% !important;
    margin: 1.75rem auto;
}
}

.form1{
	margin-top: 10%;
	margin-left: 30%
}
img{
	padding-top: 10px;
}
</style>
<script type="text/javascript">function openCity(cityName,idd,idd1) {
  var i;
  var x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  document.getElementById(cityName).style.display = "block";  

  var element = document.getElementById(idd);
  var element1 = document.getElementById(idd1);
  if(idd =="ab"){
    element1.classList.remove('actv');
    element.classList.add('actv');
  }else{
    element1.classList.remove('actv');
    element.classList.add('actv');
  }
                
}
$(document).ready(function(){
  $('#btn_upload').click(function(){

    var fd = new FormData();
    var files = $('#file')[0].files[0];
    fd.append('file',files);

    // AJAX request
    $.ajax({
      url: 'ajaxfile.php',
      type: 'post',
      data: fd,
      contentType: false,
      processData: false,
      success: function(response){
        if(response != 0){
          // Show image preview
          $('#preview').append("<img src='"+response+"' width='100' height='100' style='display: inline-block;'>");
        }else{
          alert('file not uploaded');
        }
      }
    });
  });
});

</script>