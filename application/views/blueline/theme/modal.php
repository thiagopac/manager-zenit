<script type="text/javascript" src="<?=base_url()?>assets/blueline/js/ajax.js"></script>
<script>$(document).ready(function(){ 
/* Form Validator */
    $.fn.validator.Constructor.INPUT_SELECTOR = ':input:not([type="hidden"], [type="submit"], [type="reset"], button, .flatpickr-input)';
    var activeform = $("form").validator();
/* Load 2.5.0 Form styling */
    fancyforms();
/* Reload flatpickr plugin for modal and pass through the current validation form opject */
    flatdatepicker(activeform, langshort);
/* Button loaded on click */
    buttonLoader();
/* Custom Upload Button */
    uploaderButtons(".modal");
/* Checkbox Plugin - Labelauty */
   $(".modal .checkbox").labelauty(); 
/* Item-Selector */
   itemSelector();
/* Color Selector */
   colorSelector();
/* Row delete fucntion */
   deleteRow();
/* Custom Input Mask */
   customInputMask();
});
$.ajaxSetup ({
    cache: false
});
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



