<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">

        <div class="col-md-10 col-lg-10">
            <div class="alert alert-info"><i class="glyphicon glyphicon-exclamation-sign"></i> Aqui vocês encontrará os projetos e eventos da <empresa></empresa> para adicionar fotos, vídeos ou documentos.</div>
        </div>

        <div class="col-md-10 col-lg-10">
            <div class="box-shadow">
                <div class="table-head">
                    <?=$this->lang->line('application_projects_events');?>
                </div>
                <div class="table-div responsive">
                    <table id="projects" class="data-sorting table noclick" data-page-length="<?=count($intranet_projects) ?>" cellspacing="0" cellpadding="0">
                        <thead>
                        <th>
                            <?=$this->lang->line('application_name');?>
                        </th>
                        <?php if ($this->user->department_has_user("RH", $this->user) == true) : ?>
                            <th>
                                <?=$this->lang->line('application_actions');?>
                            </th>
                        <?php endif; ?>
                        </thead>
                        <?php foreach ($intranet_projects as $project):?>

                            <tr id="<?=$project->id;?>">
                                <td>
                                    <?=$project->name;?>
                                </td>
                                <?php if ($this->user->department_has_user("RH", $this->user) == true) : ?>
                                    <td class="option" width="8%">
                                        <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left"
                                                data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>intranet/project_delete/<?=$project->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$project->id;?>'>"
                                                data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                            <i class="icon dripicons-cross"></i>
                                        </button>
                                        <a href="<?=base_url()?>intranet/project_update/<?=$project->id;?>" class="btn-option" data-toggle="mainmodal">
                                            <i class="icon dripicons-gear"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>

                        <?php endforeach;?>
                    </table>
                </div>
            </div>
        </div>
        <?php if ($this->user->department_has_user("RH", $this->user) == true) : ?>
            <div class="col-md-2 col-lg-2">
                <a href="<?=base_url()?>intranet/project_create" class="btn btn-primary" data-toggle="mainmodal" style="margin-right: 80px;">
                    <?=$this->lang->line('application_add_project_event');?>
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>