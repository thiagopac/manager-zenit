
<?php 
$attributes = ['class' => '', 'id' => '_quotation'];
echo form_open($form_action, $attributes);
?>
<style type="text/css">	
	input.labelauty + label {
		width: 100%;
	}
	.table-div {
		padding:15px;
	}
</style>
<div class="box-shadow">
<div class="table-head"><?=$quotation->name;?></div>
	<div class="table-div">	
			<?=$fields;?>
		<div class="bottom">
			<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('quotation_save');?>"/>
		</div>
	<input type="hidden" id="tfields" name="tfields" value=""/>
	<?php echo form_close(); ?>
	</div>
</div>

<script type="text/javascript">

var xResultString = '';

$('.control-label').each(function(){
  xResultString += $.trim($(this).html()+"||");
 })
$('#tfields').val(xResultString);
</script>