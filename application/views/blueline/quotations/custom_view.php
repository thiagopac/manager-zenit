<div class="col-sm-12  col-md-12 main">  
	<div id="options" class="row">
			<a href="<?=base_url()?>quotations/cupdate/<?=$quotation->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_edit_quotation');?></a>

		
</div>

		<div class="row">
			<div class="span12">
				<div class="table-head"><?=$this->lang->line('application_quotation_details');?></div>
				<div class="subcont">
					<ul class="details">
						<li><span><?=$this->lang->line('application_quotation');?>:</span> <?php if(is_object($quotation->customquote)){echo $quotation->customquote->name;}else{ echo "-";};?></li>
						<li class="<?=$quotation->status;?>"><span><?=$this->lang->line('application_status');?>:</span> <a class="label <?php if($quotation->status == "New"){echo "label-important";}elseif($quotation->status == "Accepted"){ echo "label-success";}elseif($quotation->status == "Reviewed"){ echo "label-warning";} ?>"><?=$this->lang->line('application_'.$quotation->status);?></a></li>
						<li><span><?=$this->lang->line('application_worker');?>:</span> <?php if(is_object($quotation->user)){echo $quotation->user->firstname; echo " ".$quotation->user->lastname;}else{echo "-";}?></li>
						<li><span><?=$this->lang->line('application_date');?>:</span> <?php  $unix = human_to_unix($quotation->date); echo date('jS F Y H:i', $unix);?></li>
					</ul>
				</div>
			</div>

	</div>
			<br/>
			<div class="row">
		<div class="table-head"><?=$this->lang->line('application_answers');?></div>
		<div class="subcont">
		<ul class="details">
			<li><?=$quotation->form;?></li>
		</ul>
			</div>
			</div>

	 		
	</div>