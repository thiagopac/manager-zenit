<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">

        <div class="col-md-10 col-lg-10">
            <div class="alert alert-info"><i class="glyphicon glyphicon-exclamation-sign"></i> Aqui você encontrará as orientações e manuais de procedimentos dos projetos.</div>
        </div>

        <?php foreach ($procedures_projects as $project) : ?>

        <?php $project_posts = IntranetProceduresPost::all(['conditions' => ['deleted != ? AND intranet_project_id = ?', 1, $project->id]]) ?>
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
                                <?php foreach ($project_posts as $post) : ?>
                                    <p>
                                        <a target="_blank" href="<?=base_url()?>/files/intranet/<?=$post->file?>"><?=$post->title;?></a>
                                    </p>
                                    <p><?=$post->description;?></p>
                                    <hr />
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