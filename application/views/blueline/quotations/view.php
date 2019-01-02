<div class="row">
<div class="col-sm-12  col-md-12">  
	
			<a href="<?=base_url()?>quotations/update/<?=$quotation->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_edit_quotation');?></a>
			<?php if (empty($client)) {
    ?><a href="<?=base_url()?>quotations/create_client/<?=$quotation->id; ?>" class="btn btn-primary" data-toggle="mainmodal"> <?=$this->lang->line('application_quotation_add_client'); ?></a><?php
} ?>
		
</div>
</div>
		<div class="row">
			<div class="col-md-6">
				<div class="box-shadow">
				<div class="table-head"><?=$this->lang->line('application_quotation_details');?></div>
				<div class="subcont">
					<ul class="details">
						<li class="<?=$quotation->status;?>"><span><?=$this->lang->line('application_status');?>:</span> <a class="label <?php if ($quotation->status == 'New') {
        echo 'label-important';
    } elseif ($quotation->status == 'Accepted') {
        echo 'label-success';
    } elseif ($quotation->status == 'Reviewed') {
        echo 'label-warning';
    } ?>"><?=$this->lang->line('application_' . $quotation->status);?></a></li>
						<li><span><?=$this->lang->line('application_worker');?>:</span> <?php if (is_object($quotation->user)) {
        echo $quotation->user->firstname . ' ' . $quotation->user->lastname;
    } else {
        echo '-';
    }?></li>
						<li><span><?=$this->lang->line('application_date');?>:</span> <?php  $unix = human_to_unix($quotation->date); echo date('jS F Y H:i', $unix);?></li>
					</ul>
				</div>
		</div>
			</div>
			<div class="col-md-6">
				<br>
				<div class="box-shadow">
				<div class="table-head"><?=$this->lang->line('application_personal_info');?></div>
					<div class="subcont">
						<ul class="details">
							<li><span><?=$this->lang->line('quotation_question_7');?>:</span> <?php if (empty($quotation->company)) {
        echo '-';
    } else {
        echo $quotation->company;
    }?></li>
							<li><span><?=$this->lang->line('quotation_question_8');?>:</span> <?=$quotation->fullname;?></li>
							<li><span><?=$this->lang->line('quotation_question_9');?>:</span> <?=$quotation->email;?></li>
							<li><span><?=$this->lang->line('quotation_question_10');?>:</span> <?=$quotation->phone;?></li>
							<li><span><?=$this->lang->line('quotation_question_11');?>:</span> <?=$quotation->address;?></li>
							<li><span><?=$this->lang->line('quotation_question_12');?>:</span> <?=$quotation->city;?></li>
							<li><span><?=$this->lang->line('quotation_question_13');?>:</span> <?=$quotation->zip;?></li>
							<li><span><?=$this->lang->line('quotation_question_14');?>:</span> <?=$quotation->country;?></li>
						</ul>
					</div>
				</div>
			</div>
	</div>
			
<div class="row">
<div class="col-sm-12  col-md-12"> 
	<div class="box-shadow">
		<div class="table-head"><?=$this->lang->line('application_answers');?></div>
		<div class="table-div">
			<div class="question"><?=$this->lang->line('quotation_question_1');?></div> <div class="answer"><?=$this->lang->line('quotation_question_1_aw_' . $quotation->q1);?></div>
			<div class="question"><?=$this->lang->line('quotation_question_2');?></div> <div class="answer"><?=$this->lang->line('quotation_question_2_aw_' . $quotation->q2);?></div>
			<div class="question"><?=$this->lang->line('quotation_question_3');?></div> <div class="answer"><?=$this->lang->line('quotation_question_3_aw_' . $quotation->q3);?></div>
			<div class="question"><?=$this->lang->line('quotation_question_4');?></div> <div class="answer"><?php if (isset($quotation->q4)) {
        echo $quotation->q4;
    } else {
        echo '-';
    };?></div>
			<div class="question"><?=$this->lang->line('quotation_question_5');?></div> <div class="answer"><?php if (isset($quotation->q5)) {
        echo $quotation->q5;
    } else {
        echo '-';
    };?></div>
			<div class="question"><?=$this->lang->line('quotation_question_6');?></div> <div class="answer"><?=$this->lang->line('quotation_question_6_aw_' . $quotation->q6);?></div>
			<div class="question"><?=$this->lang->line('quotation_question_15');?></div> <div class="answer"><?=$quotation->comment;?></div>
		</ul>
			</div>
			</div>
	</div>
	</div> 		
	</div>
</div>