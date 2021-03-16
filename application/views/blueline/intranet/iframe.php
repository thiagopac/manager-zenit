<style>

    .iframe-embed {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        height: 100%;
        width: 100%;
        border: 0;
    }
    .iframe-embed-wrapper {
        position: relative;
        display: block;
        height: 0;
        padding: 0;
        overflow: hidden;
    }
    .iframe-embed-responsive-16by9 {
        padding-bottom: 56.25%;
    }

</style>
<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">

        <?php if ($iframe->description != null) : ?>
            <div class="col-md-10 col-lg-10">
                <div class="alert alert-info"><i class="glyphicon glyphicon-exclamation-sign"></i> <?=$iframe->description?></div>
            </div>
        <?php endif; ?>

        <div class="col-md-10 col-lg-10">
            <div class="article-content">
                <div class="article">
                        <div class="iframe-embed-wrapper iframe-embed-responsive-16by9">
                            <iframe class="iframe-embed" src="<?=$iframe->link?>" frameborder="0" allowFullScreen="true"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>