<script>$(document).ready(function(){ 
	
    $("form").validator();
	
});
$.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});
	//$('.textarea').wysihtml5();

	//$('.datepicker').datepicker({format: 'yyyy-mm-dd'});
</script>
 <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon dripicons-cross"></i></button>
        <h4 class="modal-title"><?=$title;?></h4>
      </div>
      <div class="modal-body">
                    
        <?=$yield?>         

     
    </div>
  </div>

