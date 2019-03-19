<div class="col-sm-13  col-md-12 main">
     <div class="row">
        <div class="btn-group pull-right margin-right-3">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <?php $last_uri = $this->uri->segment($this->uri->total_segments()); if ($last_uri != 'cprojects') {
    echo $this->lang->line('application_' . $last_uri);
} else {
    echo $this->lang->line('application_all');
} ?> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <?php foreach ($submenu as $name => $value):?>
                  <li><a id="<?php $val_id = explode('/', $value); if (!is_numeric(end($val_id))) {
    echo end($val_id);
} else {
    $num = count($val_id) - 2;
    echo $val_id[$num];
} ?>" href="<?=site_url($value);?>"><?=$name?></a></li>
              <?php endforeach;?>
          </ul>
      </div>
    </div>
      <div class="row">
        <div class="box-shadow">
         <div class="table-head"><?=$this->lang->line('application_projects');?></div>
         <div class="table-div">
         <table class="data table" id="cprojects" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                <thead>
                  <tr>
                      <th width="20px" class="hidden-xs"><?=$this->lang->line('application_project_id');?></th>
                      <th class="hidden-xs" width="19px" class="no-sort sorting"></th>
                      <th><?=$this->lang->line('application_name');?></th>
                      <th class="hidden-xs"><?=$this->lang->line('application_client');?></th>
                      <th class="hidden-xs"><?=$this->lang->line('application_deadline');?></th>

                      <!-- COLUNA DE CATEGORIA / ESCONDIDO -->
                      <!-- <th class="hidden-xs"><?=$this->lang->line('application_category');?></th> -->

                      <!-- COLUNA DE ATRIBUÍDO À / ESCONDIDO ??? -->
                      <th class="hidden-xs"><?=$this->lang->line('application_assigned_to');?></th>

                  </tr></thead>

                <tbody>
                <?php foreach ($project as $value):

          ?>
                <tr id="<?=$value->id;?>">
                  <td class="hidden-xs"><?=$core_settings->project_prefix;?><?=$value->reference;?></td>
                  <td class="hidden-xs">

                    <div class="c100 p<?=$value->progress;?> <?=($value->progress == '100') ? 'green' : ''?> small tt" title="<?=$value->progress;?>%">
                        <div class="slice">
                            <div class="bar"></div>
                            <div class="fill"></div>
                        </div>
                    </div>
                </td>
                  <td onclick=""><?=$value->name;?></td>
                  <td class="hidden-xs"><a class="label label-info"><?php if (!is_object($value->company)) {
              echo $this->lang->line('application_no_client_assigned');
          } else {
              echo $value->company->name;
          }?></a></td>
                  <td class="hidden-xs"><span class="hidden-xs label label-success <?php if ($value->end <= date('Y-m-d') && $value->progress != 100) {
              echo 'label-important tt" title="' . $this->lang->line('application_overdue');
          } ?>"><?php $unix = human_to_unix($value->end);echo '<span class="hidden">' . $unix . '</span> '; echo date($core_settings->date_format, $unix);?></span></td>

                  <!-- COLUNA DE ATRIBUÍDO À / ESCONDIDO ??? -->
                  <td class="hidden-xs">
                    <?php foreach ($value->project_has_workers as $workers):?>
                      <img class="img-circle tt" src="<?=$workers->user->userpic;?>" title="<?php echo $workers->user->firstname . ' ' . $workers->user->lastname;?>" height="19px"><span class="hidden"><?php echo $workers->user->firstname . ' ' . $workers->user->lastname;?></span>
                    <?php endforeach;?>
                  </td>

                </tr>

            <?php endforeach;?>



              </tbody>
            </table>
            </div>
        </div>
      </div>
