<div id="row">

	<?php include 'parameterization_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_areas');?>
				<span class="pull-right">
					<a href="<?=base_url()?>parameterization/area_create" class="btn btn-primary" data-toggle="mainmodal">
						<?=$this->lang->line('application_add_area');?>
					</a>
				</span>
		</div>
		<div class="table-div responsive">
			<table id="areas" class="data-no-search table" cellspacing="0" cellpadding="0">
				<thead>
                    <th class="hidden-xs hidden-lg hidden-md hidden-sm hidden-print hidden"></th>
                    <th style="width:80px" class="hidden-xs">
                        <?=$this->lang->line('application_id');?>
                    </th>
					<th class="hidden-xs">
						<?=$this->lang->line('application_name');?>
					</th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_department');?>
                    </th>
				</thead>
				<?php foreach ($areas as $area):?>

				<tr id="<?=$area->id;?>">
					<td class="hidden-xs">
						<?=$area->id;?>
					</td>
					<td>
                        <?=$area->name;?>
					</td>
                    <td>
                        <?=$area->department->name;?>
                    </td>

					<td class="option" width="8%">
						<button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>parameterization/area_delete/<?=$area->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$area->id;?>'>"
						 data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
							<i class="icon dripicons-cross"></i>
						</button>
						<a href="<?=base_url()?>parameterization/area_update/<?=$area->id;?>" class="btn-option" data-toggle="mainmodal">
							<i class="icon dripicons-gear"></i>
						</a>
					</td>
				</tr>

				<?php endforeach;?>
			</table>
		</div>
	</div>
	</div>
</div>