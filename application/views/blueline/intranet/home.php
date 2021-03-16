<div id="row">

    <?php include 'intranet_menu.php'; ?>

    <div class="col-md-10 col-lg-10">
        <div class="article-content" style="width: inherit !important;">
            <div class="splide">
                <div class="splide__track">

                    <ul class="splide__list">

                        <?php foreach ($home_posts as $post) : ?>

                            <?php foreach ($post->intranet_file as $file) : ?>
                                <li class="splide__slide">
                                    <div class="splide__slide__container">
                                        <img style="width: 800px; height: auto" data-splide-lazy="<?=base_url()?>files/intranet/<?=$file->file?>">
                                    </div>
                                    <div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>

</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
<script src="//cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
<script>
    new Splide('.splide', {
        type: 'loop',
        autoplay: true,
        interval: 3000,
        pauseOnHover: true,
        // autoWidth: true,
        // autoHeight: true,
        focus    : 'center',
        lazyLoad: 'sequential'
    }).mount();
</script>