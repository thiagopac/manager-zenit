<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">

        <div class="col-md-10 col-lg-10">
            <div class="alert alert-info"><i class="glyphicon glyphicon-exclamation-sign"></i> Aqui você poderá conhecer a cultura e curiosidades da Ownergy.</div>
        </div>

        <?php foreach ($institutional_posts as $key => $post) : ?>
        <div class="col-md-10 col-lg-10">
            <div class="article-content">
                <div class="article">
                    <div class="article-header">
                        <div class="article-title">
                            <?='<span class="tt"><b>'.ucwords($post->title).'</b></span> '?>
                            <small class="article-datetime"> <?=$this->lang->line('application_at');?> <b><?=date($core_settings->date_format . '</b> à\s <b>' . $core_settings->date_time_format, human_to_unix($post->updated_at)).'</b>'?></small>
                        </div>
                    </div>
                    <div class="article-body">
                        <p>
                            <?=$post->description;?>
                        </p>
                        <p>
                            <?php if (explode('.', $post->file)[1] == 'jpg' ||
                            explode('.', $post->file)[1] == 'png' ||
                            explode('.', $post->file)[1] == 'gif' ||
                            explode('.', $post->file)[1] == 'jpeg' ||
                            explode('.', $post->file)[1] == 'bmp') : ?>
                        <p>
                            <img src="<?=base_url()?>/files/intranet/<?=$post->file?>" style="width: 100%; height: 100%"/>
                        </p>
                        <?php else : ?>
                            <p>
                                <a target="_blank" href="<?=base_url()?>/files/intranet/<?=$post->file?>"><?=$this->lang->line('application_view_file');?></a>
                            </p>
                        <?php endif; ?>
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

</div>