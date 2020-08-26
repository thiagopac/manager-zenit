<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10" style="margin-bottom: 20px;">

        <div class="col-md-10 col-lg-10">
            <div class="article-content">
                <div class="article">
                    <div class="article-header">
                        <div class="article-title">
                            <?='<span class="tt"><b>'.ucwords($home_fixed->title).'</b></span> '?>
                            <small class="article-datetime"> <?=$this->lang->line('application_at');?> <b><?=date($core_settings->date_format . '</b> à\s <b>' . $core_settings->date_time_format, human_to_unix($home_fixed->updated_at)).'</b>'?></small>
                        </div>
                    </div>
                    <div class="article-body">
                        <p>
                            <?=$home_fixed->description;?>
                        </p>
                        <p>
                            <img src="<?=base_url()?>/files/intranet/<?=$home_fixed->file?>" style="width: 100%; height: 100%"/>
                        </p>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-lg-2">
            <div class="article-content">
                <div class="article">
                    <div class="article-header">
                        <div class="article-title">
                            <?='<span class="tt"><b>'.ucwords($home_detail->title).'</b></span> '?>
                        </div>
                    </div>
                    <div class="article-body">
                        <p style="text-align: center; padding: 40px">
                            <span style="text-align: center; font-size: 50px"><?=$home_detail->description?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <?php foreach ($home_posts as $post) : ?>
            <div class="col-md-10 col-lg-10">
                <div class="article-content">
                    <div class="article">
                        <div class="article-header">
                            <div class="article-title">
                                <?='<span class="tt"><b>'.ucwords($post->title).'</b></span> '?>
                                <small class="article-datetime"> <?=$this->lang->line('application_at');?> <b><?=date($core_settings->date_format . '</b> à\s <b>' . $core_settings->date_time_format, human_to_unix($post->created_at)).'</b>'?></small>
                            </div>
                        </div>
                        <div class="article-body">
                            <p>
                                <?=$post->description;?>
                            </p>
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

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>



</div>