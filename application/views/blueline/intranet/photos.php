<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">

        <div class="col-md-10 col-lg-10">
            <div class="alert alert-info"><i class="glyphicon glyphicon-exclamation-sign"></i> Aqui você encontrará as fotos dos projetos e eventos da empresa. Clique para dar zoom.</div>
        </div>

        <?php foreach ($photo_projects as $project) : ?>
        <?php $photos =  $project->intranet_photo; ?>
        <?php if (count($photos) > 0) : ?>
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
                                    <img data-action="zoom" style="margin: 4px; width: 200px; height: 130px" src="<?=base_url()?>files/intranet/<?=$photo->file?>" />
                                <?php endforeach; ?>
                            </div>


                            </p>

                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</div>