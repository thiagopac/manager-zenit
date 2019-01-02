
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/blueline/css/plugins/formbuilder.css" />
  <style>
  * {
    box-sizing: border-box;
  }

  .fb-main {
    min-height: 600px;
  }

  input[type=text] {

    margin-bottom: 3px;
  }

  select {
    margin-bottom: 5px;

  }

  </style>
<div class="col-sm-12  col-md-12 main">  
  <div lass="row">

<?php 
if (isset($quotation)) {
    $qFormId = '/' . $quotation->id;
} else {
    $qFormId = '';
}
$form_action = base_url() . 'quotations/build' . $qFormId;
$attributes = ['class' => '', 'id' => 'saveform'];
echo form_open($form_action, $attributes);
?>

  <div class="box-shadow">
  <div class="table-head"><?=$this->lang->line('application_create_quotation');?><span class="pull-right">
    <span class="label label-warning changes"><?=$this->lang->line('application_unsaved');?></span>
  <input type="submit" class="btn btn-primary save button-loader" value="<?=$this->lang->line('application_save');?>" disabled="disabled"/></span></div>
  <div class="table-div">
      <br><div class="form-group">
      <label><?=$this->lang->line('application_name');?></label>
      <input type="text" class="form-control" name="name" placeholder="<?=$this->lang->line('application_type_form_name_here');?>" id="form-title" value="<?php if (isset($quotation)) {
    echo $quotation->name;
} ?>" required/>
      </div>
			<textarea id="formcontent" class="hidden" name="formcontent"></textarea>
      
</form>
  <div class='fb-main2'></div>

  <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/formbuilder-vendor.js"></script>
  <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/formbuilder.js"></script>

  <?php
  if (isset($quotation)) {
      $json = json_decode($quotation->formcontent, true);
      $formcontent = json_encode($json['fields']);
  }
  ?>

  <script>
    $(function(){

      $("form").validator();

      fb = new Formbuilder({
        selector: '.fb-main2',
        bootstrapData: <?php if (isset($formcontent)) {
      echo $formcontent;
  } else {
      echo '[]';
  } ?>
          
      });

      fb.on('save', function(payload){
        console.log(payload);
        $("#formcontent").text(payload);
      });


      switch ( window.orientation ) {

    case 0:
        alert('Please turn your phone sideways in order to use this page!');
    break;

}

    });
  </script>  
</div></div></div></div>
