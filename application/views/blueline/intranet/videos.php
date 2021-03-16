<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">

        <div class="col-md-10 col-lg-10">
            <div class="alert alert-info"><i class="glyphicon glyphicon-exclamation-sign"></i> Aqui você encontrará os vídeos dos projetos e eventos da empresa. Clique para assistir.</div>
        </div>

        <?php foreach ($video_projects as $project) : ?>
        <?php $videos = $project->intranet_video; ?>
            <?php if (count($videos) > 0) : ?>
                <div class="col-md-10 col-lg-10">
                    <div class="article-content">
                        <div class="article">
                            <div class="article-header">
                                <div class="article-title">
                                    <span class="tt"><b><?=$project->name?></b></span>
                                    <small class="article-datetime"> <?=$this->lang->line('application_at');?> <b><?=date($core_settings->date_format . '</b> à\s <b>' . $core_settings->date_time_format, human_to_unix($project->created_at)).'</b>'?></small>
                                </div>
                            </div>
                            <div class="article-body">
                                <div>
                                    <?php foreach ($videos as $video) : ?>
                                        <a data-toggle="mainmodal" href="<?=base_url()?>intranet/video/<?=$video->id?>"><img style="margin: 4px; width: 200px; height: 120px" src="http://i3.ytimg.com/vi/<?=substr(explode("=", $video->link)[1], 0, 11    )?>/maxresdefault.jpg" /></a>
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