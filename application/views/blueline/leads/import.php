<div class="col-sm-13  col-md-12 main">  

	
	<div class="row">
		<div class="col-xl-3 col-md-4 col-sm-5">
			<div class="box-shadow">
			<?php $attributes = ['class' => '', 'id' => 'import'];
                echo form_open($form_action, $attributes); ?>
                <input type="hidden" name="csv_file" value="<?=$csv_file?>">
                <input type="hidden" name="status_id" value="<?=$status_id?>">
                <input type="hidden" name="private" value="<?=$private?>">
                <input type="hidden" name="source" value="<?=$source?>">
                <input type="hidden" name="user_id" value="<?=$user_id?>">
				
			 <div class="table-head">
	         	<?=$this->lang->line('application_import_leads');?>
	         	<span class="pull-right">
					<a class="btn btn-danger" href="<?=base_url() . 'leads'?>"><?=$this->lang->line('application_cancel');?></a>
	         		<button class="btn btn-success"><?=$this->lang->line('application_save');?></button>
	         	</span>
	         </div>
	         <div class="table-div">
		         <table class="table" id="leads" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		            <thead>
		            	<tr>
		                  	<th><?=$this->lang->line('application_column');?></th>
		                  	<th class="no-sort"></th>
		                  	<th>.CSV <?=$this->lang->line('application_column');?></th>
		            	</tr>
		            </thead> 
		            <tbody>
	          			<?php foreach ($db_fields as $key => $field): if (!in_array($field->name, $except_fields)) {
                    ?>
	          			<tr>
	                  		<td>
	                  			<?=$field->name; ?> <?=(in_array($field->name, $required_fields)) ? '*' : '' ?>
	                  		</td>
	                  		<td>
	                  			<i class="icon dripicons-arrow-thin-left"></i>
	                  		</td>
	                  		<td>
	                  			<select class="chosen-select" data-placeholder="<?= htmlspecialchars($this->lang->line('application_select_field')); ?>" name="<?=$field->name?>" <?=(in_array($field->name, $required_fields)) ? 'required' : '' ?>>
	                  				<?=$select_options?>
	                  			</select>
	                  		</td>
	                  	</tr>
	                  	<?php
                }  endforeach; ?>
		            </tbody> 
		         </table>   
		     </div>
			<?php echo form_close(); ?>
			</div>
		</div>
		<div class="col-xl-9 col-md-8 col-sm-7">
			<div class="box-shadow">
	         <div class="table-head">
	         	<?=$this->lang->line('application_csv_preview');?>
	         </div>
	         <div class="table-div responsive">
		         <table class="data table big-data" id="leads-import-preview" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		            <thead>
		            	<tr>
		              		<?php foreach ($columns as $column): ?>
		                  		<th><?=$column;?></th>
		                	<?php endforeach;?>
		            	</tr>
		            </thead> 
		            <tbody>
		                <?php $i = 0; foreach ($leads as $row): $i = $i + 1;?>
			                <tr>
				                  <?php foreach ($columns as $column): ?>
			                      		<td><?=$row[$column];?></td>
			                      <?php endforeach;?>
			                </tr>
		            	<?php endforeach;?>
		            </tbody>
		        </table>   
			</div>
			</div>
		</div>
	</div>
</div>