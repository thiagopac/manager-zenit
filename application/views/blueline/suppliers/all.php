<div class="col-sm-12  col-md-12 main">
		<div class="row">
			<a href="<?=base_url()?>suppliers/supplier/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_new_supplier');?></a>
            <a href="<?=base_url()?>suppliers/category/create" class="btn btn-success" data-toggle="mainmodal"><?=$this->lang->line('application_new_segment');?></a>

            <div class="btn-group pull-right margin-right-3">
                <button type="button" class="btn <?=$active_state_filter != $this->lang->line('application_state') && $active_state_filter != null  ? 'btn-danger' : 'btn-primary'?> dropdown-toggle" data-toggle="dropdown">
                    <?php if ($active_state_filter) {
                        echo $active_state_filter;
                    } else {
                        echo $this->lang->line('application_state');
                    } ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">

                    <li>
                        <a id="" href="<?=base_url()?>suppliers?state=&deadline=<?=$active_deadline_filter?>&payment=<?=$active_payment_filter?>&segment=<?=$active_segment_filter?>">
                            <?=$this->lang->line('application_all');?>
                        </a>
                    </li>
                    <? foreach($stateList as $state) : ?>
                            <li>
                                <a id="<?=$state?>" href="<?=base_url()?>suppliers?state=<?=$state?>&deadline=<?=$active_deadline_filter?>&payment=<?=$active_payment_filter?>&segment=<?=$active_segment_filter?>">
                                    <?=$state?>
                                </a>
                            </li>
                    <? endforeach; ?>
                </ul>
            </div>

            <div class="btn-group pull-right margin-right-3">
                <button type="button" class="btn <?=$active_deadline_filter != $this->lang->line('application_supplier_deadline') && $active_deadline_filter != null ? 'btn-danger' : 'btn-primary'?> dropdown-toggle" data-toggle="dropdown">
                    <?php if ($active_deadline_filter) {
                        echo $active_deadline_filter;
                    } else {
                        echo $this->lang->line('application_supplier_deadline');
                    } ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">

                    <li>
                        <a id="" href="<?=base_url()?>suppliers?state=<?=$active_state_filter?>&deadline=&payment=<?=$active_payment_filter?>&segment=<?=$active_segment_filter?>">
                            <?=$this->lang->line('application_all');?>
                        </a>
                    </li>
                    <?php
                    ?>
                    <? foreach($deadlineList as $deadline) : ?>
                            <li>
                                <a id="<?=$deadline?>" href="<?=base_url()?>suppliers?state=<?=$active_state_filter?>&deadline=<?=$deadline?>&payment=<?=$active_payment_filter?>&segment=<?=$active_segment_filter?>">
                                    <?=$deadline?>
                                </a>
                            </li>
                    <? endforeach; ?>
                </ul>
            </div>

            <div class="btn-group pull-right margin-right-3">
                <button type="button" class="btn <?=$active_payment_filter != $this->lang->line('application_payment_condition') && $active_payment_filter != null  ? 'btn-danger' : 'btn-primary'?> dropdown-toggle" data-toggle="dropdown">
                    <?php if ($active_payment_filter) {
                        echo $active_payment_filter;
                    } else {
                        echo $this->lang->line('application_payment_condition');
                    } ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">

                    <li>
                        <a id="" href="<?=base_url()?>suppliers?state=<?=$active_state_filter?>&deadline=<?=$active_deadline_filter?>&payment=&segment=<?=$active_segment_filter?>">
                            <?=$this->lang->line('application_all');?>
                        </a>
                    </li>
                    <?php
                    ?>
                    <? foreach($paymentList as $payment) : ?>
                        <li>
                            <a id="<?=$payment?>" href="<?=base_url()?>suppliers?state=<?=$active_state_filter?>&deadline=<?=$active_deadline_filter?>&payment=<?=$payment?>&segment=<?=$active_segment_filter?>">
                                <?=$payment?>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>

            <div class="btn-group pull-right margin-right-3">
                <button type="button" class="btn <?=$active_segment_filter != $this->lang->line('application_segments')  && $active_deadline_filter != null  ? 'btn-danger' : 'btn-primary'?> dropdown-toggle" data-toggle="dropdown">
                    <?php if ($active_segment_filter) {
                        echo $active_segment_filter;
                    } else {
                        echo $this->lang->line('application_segments');
                    } ?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">

                    <li>
                        <a id="" href="<?=base_url()?>suppliers?state=<?=$active_state_filter?>&deadline=<?=$active_deadline_filter?>&payment=<?=$active_payment_filter?>&segment=">
                            <?=$this->lang->line('application_all');?>
                        </a>
                    </li>
                    <?php
                    ?>
                    <? foreach($segmentList as $segment) : ?>
                        <li>
                            <a id="<?=$segment?>" href="<?=base_url()?>suppliers?state=<?=$active_state_filter?>&deadline=<?=$active_deadline_filter?>&payment=<?=$active_payment_filter?>&segment=<?=$segment?>">
                                <?=$segment?>
                            </a>
                        </li>
                    <? endforeach; ?>
                </ul>
            </div>

		</div>
		<div class="row">
		<div class="box-shadow">
		<div class="table-head"> <?=$this->lang->line('application_suppliers');?></div>
		<div class="table-div">
		<table class="data table" id="suppliers" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>

            <th><?=$this->lang->line('application_id');?></th>
			<th><?=$this->lang->line('application_name');?></th>
            <th><?=$this->lang->line('application_registered_number');?></th>
            <th><?=$this->lang->line('application_state_registration_abrv');?></th>
            <th><?=$this->lang->line('application_municipal_registration_abrv');?></th>
<!--            <th>--><?//=$this->lang->line('application_address');?><!--</th>-->
<!--            <th>--><?//=$this->lang->line('application_neighborhood');?><!--</th>-->
            <th><?=$this->lang->line('application_city');?></th>
            <th><?=$this->lang->line('application_state');?></th>
            <th><?=$this->lang->line('application_zipcode');?></th>
            <th><?=$this->lang->line('application_website');?></th>
			<th><?=$this->lang->line('application_contact');?></th>
<!--            <th>--><?//=$this->lang->line('application_phone');?><!--</th>-->
<!--			<th>--><?//=$this->lang->line('application_email');?><!--</th>-->
            <th><?=$this->lang->line('application_segments');?></th>
            <th><?=$this->lang->line('application_payment_condition_abrv');?></th>
            <th><?=$this->lang->line('application_supplier_deadline');?></th>
<!--            <th>--><?//=$this->lang->line('application_bank');?><!--</th>-->
<!--            <th>--><?//=$this->lang->line('application_branch');?><!--</th>-->
<!--            <th>--><?//=$this->lang->line('application_account');?><!--</th>-->

			<th><?=$this->lang->line('application_action');?></th>
		</thead>
		<?php foreach ($suppliers as $value):?>

		<tr id="<?=$value->id;?>" >
            <td><?=$value->id; ?></td>
			<td><?=$value->name; ?></td>
            <td><?=$value->registered_number; ?></td>
            <td><?=$value->state_registration; ?></td>
            <td><?=$value->municipal_registration; ?></td>
			<td><?=$value->city ?></td>
            <td><?=$value->state ?></td>
            <td><?=$value->zipcode; ?></td>
<!--            <td>--><?//="<a href='http://$value->website' target='_blank'>".$value->website."</a>"?><!--</td>-->

            <td>

                <?php $websites = explode(' ',$value->website);?>
                <?php foreach ($websites as $website) : ?>
                <?php
                    $size_break = 27;
                    if (strlen($website) > $size_break){
                        $website_url = $website;
                        $break = "<br />";
                        $_1_website = substr($website, 0, $size_break).$break;
                        $_2_website = substr($website, strlen($_1_website) - strlen($break), strlen($website) - strlen($_1_website) + strlen($break));
                        $website = $_1_website.$_2_website;

//                        $website = (strlen($website));
                    }
                ?>
                    <p><button class="label label-info"  onclick=" window.open('<?="http://".$website_url?>', '_blank'); return false;"><?=$website?></button></p>
                <?php endforeach; ?>
            </td>




            <td><?=$value->contact; ?></td>
<!--            <td>--><?//=$value->phone; ?><!--</td>-->
<!--            <td>--><?//=$value->email; ?><!--</td>-->
            <td><?=$value->supplier_category_ids!=null ? Supplier::supplierCategoriesStr($value->supplier_category_ids): ''; ?></td>
            <td><?=$value->payment_condition; ?></td>
            <td><?=$value->supplier_deadline; ?></td>

			<td class="option" width="8%">
                <button type="button" title="<?=$this->lang->line('application_delete'); ?>"
                        class="btn-option delete po tt" data-toggle="popover" data-placement="left"
                        data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>suppliers/supplier/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>"
                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i>
                </button>
                <a href="<?=base_url()?>suppliers/supplier/update/<?=$value->id;?>"  title="<?=$this->lang->line('application_edit'); ?>" class="btn-option tt" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
			</td>
		</tr>
		<?php endforeach;?>
	 	</table>
	 	<br clear="all">

	</div>
</div>