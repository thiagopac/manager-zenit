<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10" style="margin-bottom: 20px;">

        <?php foreach ($photo_projects as $project) : ?>

        <?php $photos = IntranetPhoto::all(['conditions' => ['deleted != ? AND intranet_project_id = ? ORDER BY id DESC', 1, $project->id]]) ?>
            <div class="col-md-10 col-lg-10">
                <div class="article-content">
                    <div class="article">
                        <div class="article-header">
                            <div class="article-title">
                                <?='<span class="tt"><b>'.ucwords($project->name).'</b></span> '?>
                                <small class="article-datetime"> <?=$this->lang->line('application_at');?> <b><?=date($core_settings->date_format . '</b> à\s <b>' . $core_settings->date_time_format, human_to_unix($project->created_at)).'</b>'?></small>
                            </div>
                        </div>
                        <div class="article-body">
                            <div>
                                <?php foreach ($photos as $photo) : ?>
                                    <img data-action="zoom" style="margin: 4px; width: 200px; height: 150px" src="<?=base_url()?>files/intranet/<?=$photo->file?>" />
                                <?php endforeach; ?>
                            </div>


                            </p>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>