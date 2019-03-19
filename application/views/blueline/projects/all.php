


<div class="col-sm-13  col-md-12 main">
    <div class="row tile-row">
        <div class="col-md-3 col-xs-6 tile">
            <div class="icon-frame hidden-xs">
                <i class="ion-ios-lightbulb"></i>
            </div>
            <h1>
                <?php if (isset($projects_assigned_to_me[0])) {
                    echo $projects_assigned_to_me[0]->amount;
                } ?>
                <span>
					<?=$this->lang->line('application_projects');?>
				</span>
            </h1>
            <h2 >
                <?=$this->lang->line('application_assigned_to_me');?>
            </h2>
        </div>
        <div class="col-md-3 col-xs-6 tile">
            <div class="icon-frame secondary hidden-xs">
                <i class="ion-ios-list-outline"></i>
            </div>
            <h1>
                <?php if (isset($tasks_assigned_to_me)) {
                    echo $tasks_assigned_to_me;
                } ?>
                <span>
					<?=$this->lang->line('application_tasks');?>
				</span>
            </h1>
            <h2>
                <?=$this->lang->line('application_assigned_to_me');?>
            </h2>
        </div>
        <div class="col-md-6 col-xs-12 tile hidden-xs">
            <div style="width:97%; margin-top: -4px; margin-bottom: 17px; height: 80px;">
<!--                <canvas id="tileChart" width="auto" height="80"></canvas>-->
            </div>
        </div>
    </div>
    <div class="row">
        <a href="
			<?=base_url()?>projects/create" class="btn btn-primary" data-toggle="mainmodal">
            <?=$this->lang->line('application_create_new_project');?>
        </a>
        <div class="btn-group pull-right margin-right-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if ($last_uri != 'projects') {
                    echo $this->lang->line('application_' . $last_uri);
                } else {
                    echo $this->lang->line('application_open');
                } ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <?php foreach ($submenu as $name => $value):?>
                    <li>
                        <a id="
						<?php $val_id = explode('/', $value); if (!is_numeric(end($val_id))) {
                            echo end($val_id);
                        } else {
                            $num = count($val_id) - 2;
                            echo $val_id[$num];
                        } ?>" href="
						<?=site_url($value);?>">
                            <?=$name?>
                        </a>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_projects');?>
            </div>
            <div class="table-div">
                <table class="data table" id="projects" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr>
                        <th width="20px" class="hidden-xs">
                            <?=$this->lang->line('application_project_id');?>
                        </th>
                        <th class="" width="19px" class="no-sort sorting"></th>
                        <th>
                            <?=$this->lang->line('application_name');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_client');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_deadline');?>
                        </th>
                        <th class="hidden-xs">
                            <?=$this->lang->line('application_assigned_to');?>
                        </th>
                        <th>
                            <?=$this->lang->line('application_action');?>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; foreach ($project as $value): $i = $i + 1;?>
                        <tr id="
							<?=$value->id;?>">
                            <td class="hidden-xs">
                                <span class="static-color-preview" style="background-color:<?=$value->color?>"></span>
                                <?=$core_settings->project_prefix;?>
                                <?=$value->reference;?>
                            </td>
                            <td class="">
                                <div class="c100 p
									<?=$value->progress;?>
									<?=($value->progress == '100') ? 'green' : ''?> small tt" title="
									<?=$value->progress;?>%">
                                    <div class="slice">
                                        <div class="bar"></div>
                                        <div class="fill"></div>
                                    </div>
                                </div>
                            </td>
                            <td onclick="">
                                <?=$value->name;?>
                            </td>
                            <td class="hidden-xs">
                                <a class="label label-info">
                                    <?php if (!is_object($value->company)) {
                                        echo $this->lang->line('application_no_client_assigned');
                                    } else {
                                        echo $value->company->name;
                                    }?>
                                </a>
                            </td>
                            <td class="hidden-xs">
								<span class="hidden-xs label label-success
									<?php if ($value->end <= date('Y-m-d') && $value->progress != 100) {
                                    echo 'label-important tt" title="' . $this->lang->line('application_overdue');
                                } ?>">
									<?php $unix = human_to_unix($value->end);echo '
									<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format, $unix);?>
								</span>
                            </td>
                            <td class="hidden-xs">
                                <?php foreach ($value->project_has_workers as $workers): ?>
                                    <img class="img-circle tt" src="
									<?=$workers->user->userpic;?>" title="
									<?php echo $workers->user->firstname . ' ' . $workers->user->lastname;?>" height="19px">
                                    <span class="hidden">
										<?php echo $workers->user->firstname . ' ' . $workers->user->lastname;?>
									</span>
                                <?php endforeach;?>
                            </td>
                            <td class="option" width="8%">
                                <button type="button" title="
										<?=$this->lang->line('application_delete'); ?>" class="btn-option delete po tt" data-toggle="popover" data-placement="left" data-content="
										<a class='btn btn-danger po-delete ajax-silent' href='
											<?=base_url()?>projects/delete/
											<?=$value->id;?>'>
											<?=$this->lang->line('application_yes_im_sure');?>
										</a>
										<button class='btn po-close'>
											<?=$this->lang->line('application_no');?>
										</button>
										<input type='hidden' name='td-id' class='id' value='
											<?=$value->id;?>'>" data-original-title="
											<b>
												<?=$this->lang->line('application_really_delete');?>
											</b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="
											<?=base_url()?>projects/update/
											<?=$value->id;?>" class="btn-option tt" title="
											<?=$this->lang->line('application_edit_project'); ?>" data-toggle="mainmodal">
                                    <i class="icon dripicons-gear"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){



//chartjs

        //    var ctx = $("#tileChart").get(0).getContext("2d");
        //
        //
        //    <?php
        //    $days = [];
        //    $data = '';
        //    $this_week_days = [
        //        date('Y-m-d', strtotime('monday this week')),
        //        date('Y-m-d', strtotime('tuesday this week')),
        //        date('Y-m-d', strtotime('wednesday this week')),
        //        date('Y-m-d', strtotime('thursday this week')),
        //        date('Y-m-d', strtotime('friday this week')),
        //        date('Y-m-d', strtotime('saturday this week')),
        //        date('Y-m-d', strtotime('sunday this week'))];
        //
        //    $labels = '';
        //    foreach ($projects_opened_this_week as $value) {
        //        $days[$value->date_formatted] = $value->amount;
        //    }
        //    $counter = 0;
        //    foreach ($this_week_days as $selected_day) {
        //        $counter++;
        //        $unix = human_to_unix($selected_day . ' 00:00');
        //        $labels .= '"' . date($core_settings->date_format, $unix) . '"';
        //        if ($counter != 7) {
        //            $labels .= ',';
        //        }
        //        $y = 0;
        //        if (isset($days[$selected_day])) {
        //            $y = $days[$selected_day];
        //        }
        //        $data .= $y;
        //        if ($counter != 7) {
        //            $data .= ',';
        //        }
        //        $selday = $selected_day;
        //    } ?>
        //
        //    var ctx = document.getElementById("tileChart").getContext("2d");
        //    var myBarChart = new Chart(ctx, {
        //        type: 'line',
        //        data: {
        //            labels: [
        //                <?//=$labels?>//],
        //            datasets: [{
        //                label: "<?//=addslashes(htmlspecialchars($this->lang->line('application_new_projects')));?>//",
        //                backgroundColor: "rgba(51, 195, 218, 0.3)",
        //        borderColor: "rgba(51, 195, 218, 1)",
        //        pointBorderColor: "rgba(51, 195, 218, 0)",
        //        pointBackgroundColor: "rgba(51, 195, 218, 1)",
        //        pointHoverBackgroundColor: "rgba(51, 195, 218, 1)",
        //        pointHitRadius: 25,
        //        pointRadius: 2,
        //        borderWidth: 2,
        //        data: [
        //        <?//=$data;?>//]
        //}]
        //},
        //    options: {
        //
        //        title: {
        //            display: true,
        //                text: ' '
        //        },
        //        maintainAspectRatio: false,
        //            tooltips:{
        //            enabled: true,
        //        },
        //        legend:{
        //            display: false
        //        },
        //        scales: {
        //            yAxes: [{
        //                gridLines: {
        //                    display: false,
        //                    lineWidth: 2,
        //                    color: "rgba(51, 195, 218, 0)"
        //                },
        //                ticks: {
        //                    beginAtZero:true,
        //                    display: false,
        //
        //                }
        //            }],
        //                xAxes: [{
        //                gridLines: {
        //                    display: false,
        //                    lineWidth: 2,
        //                    color: "rgba(51, 195, 218, 0)"
        //                },
        //                ticks: {
        //                    beginAtZero:true,
        //                    display: false,
        //
        //                }
        //            }]
        //        }
        //    }
        //
        //});



        });

    </script>
