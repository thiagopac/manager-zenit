<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10" style="margin-bottom: 20px;">

        <?php if ($home_fixed != null) : ?>
            <div class="col-md-10 col-lg-10">
                <div class="article-content">
                    <div class="article">
                        <div class="article-header">
                            <div class="article-title">
                                <span class="tt"><b><?=$home_fixed->title?></b></span>
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
        <?php endif; ?>

        <?php if ($home_detail->title != null) : ?>
        <div class="col-md-2 col-lg-2">
            <div class="article-content">
                <div class="article">
                    <div class="article-header">
                        <div class="article-title">
                            <span class="tt"><b><?=$home_detail->title?></b></span>
                        </div>
                    </div>
                    <div class="article-body">
                        <p style="text-align: center; padding-top: 40px; padding-bottom: 40px">
                            <span style="text-align: center; font-size: 50px"><?=$home_detail->description?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php foreach ($home_posts as $post) : ?>
            <div class="col-md-10 col-lg-10">
                <div class="article-content">
                    <div class="article">
                        <div class="article-header">
                            <div class="article-title">
                                <span class="tt"><b><?=$post->title?></b></span>
                                <small class="article-datetime"> <?=$this->lang->line('application_at');?> <b><?=date($core_settings->date_format . '</b> à\s <b>' . $core_settings->date_time_format, human_to_unix($post->created_at)).'</b>'?></small>
                            </div>
                        </div>
                        <div class="article-body">
                            <p>
                                <?=$post->description;?>
                            </p>

                            <?php foreach ($post->intranet_file as $file) : ?>
                                <?php if ($file->file != null) : ?>
                                    <?php if (explode('.', $file->file)[1] == 'jpg' ||
                                              explode('.', $file->file)[1] == 'png' ||
                                              explode('.', $file->file)[1] == 'gif' ||
                                              explode('.', $file->file)[1] == 'jpeg' ||
                                              explode('.', $file->file)[1] == 'tiff' ||
                                              explode('.', $file->file)[1] == 'bmp') : ?>

                                        <?php if (count($post->intranet_file) == 1) : ?>
                                            <p>
                                                <img src="<?=base_url()?>/files/intranet/<?=$file->file?>" style="width: 100%; height: 100%"/>
                                            </p>
                                        <?php else : ?>
                                                <img src="<?=base_url()?>/files/intranet/<?=$file->file?>" style="margin: 4px; width: 100px; height: 70px"/>
                                        <?php endif; ?>

                                    <?php else : ?>
                                        <p>
                                            <a target="_blank" href="<?=base_url()?>/files/intranet/<?=$file->file?>"><?=$this->lang->line('application_view_file');?></a>
                                        </p>
                                    <?php endif; ?>

                                <?php else : ?>
                                    <img style="margin: 4px; width: 100px; height: 60px" src="http://i3.ytimg.com/vi/<?=substr(explode("=", $file->link)[1], 0, 11    )?>/maxresdefault.jpg" />
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>



</div>