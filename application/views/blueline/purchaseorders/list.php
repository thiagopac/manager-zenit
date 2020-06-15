<?php
if($purchase_orders){

    foreach ($purchase_orders as $value):
        $unix = human_to_unix($value->created_at); ?>
        <li class="<?php if($filter){echo $filter;}?> hidden" data-link="<?=base_url()?>purchaseorders/view/<?=$value->id;?><?php if(isset($filter)){echo "/".$filter;} ?><?php if(isset($filter)){ if($filter == "Sent"){echo "/".$value->id;} } ?>">
            <div class="col col-1">
                <p class="title">
                    <strong>[<?=$this->lang->line('application_purchase_order');?> <?=$value->id;?>]</strong>
                    <?=json_decode($value->response)->work?>
                </p>
            </div>
            <div class="col col-2">
                <div class="subject"><?=$value->subject;?></div>
                <div class="date">
                    <?php if($value->user_id != null){echo User::find($value->user_id)->firstname;}else{ echo $value->id; } ?> -
                    <?php echo time_ago($unix, true);?>
                </div>
            </div>
        </li>
    <?php endforeach;?>

<?php } else{ ?>
    <li style="padding-left:21px"><?=$this->lang->line('application_no_messages');?></li>
<?php } ?>

<script>
    jQuery(document).ready(function($) {
        $("#main .message-list li").removeClass("hidden").delay(300).addClass("visible");
        var cols = {},

            messageIsOpen = false;

        cols.showOverlay = function() {
            $('body').addClass('show-main-overlay');
        };
        cols.hideOverlay = function() {
            $('body').removeClass('show-main-overlay');
        };


        cols.showMessage = function() {
            $('body').addClass('show-message');
            messageIsOpen = true;
        };
        cols.hideMessage = function() {
            $('body').removeClass('show-message');
            $('#main .message-list li').removeClass('active');
            messageIsOpen = false;
        };


        cols.showSidebar = function() {
            $('body').addClass('show-sidebar');
        };
        cols.hideSidebar = function() {
            $('body').removeClass('show-sidebar');
        };

// Show sidebar when trigger is clicked

        $('.trigger-toggle-sidebar').on('click', function() {
            cols.showSidebar();
            cols.showOverlay();
        });


        $('.trigger-message-close').on('click', function() {
            cols.hideMessage();
            cols.hideOverlay();
        });


// When you click on a message, show it

        $('#main .message-list li').on('click', function(e) {
            var item = $(this),
                target = $(e.target);
            NProgress.start();
            if(target.is('label')) {
                item.toggleClass('selected');
            } else {
                if(messageIsOpen && item.is('.active')) {
                    cols.hideMessage();
                    cols.hideOverlay();
                    NProgress.done();
                } else {
                    if(messageIsOpen) {
                        cols.hideMessage();
                        item.addClass('active');
                        setTimeout(function() {
                            var url = item.data('link');
                            if (url.indexOf('#') === 0) {

                            } else {
                                $.get(url, function(data) {
                                    $('#message').html(data);
                                }).done(function() {
                                    NProgress.done();
                                    cols.showMessage();

                                });
                            }
                        }, 300);
                    } else {
                        item.addClass('active');

                        var url = item.data('link');
                        if (url.indexOf('#') === 0) {

                        } else {
                            $.get(url, function(data) {
                                $('#message').html(data);
                            }).done(function() {
                                NProgress.done();
                                cols.showMessage();

                            });
                        }
                    }
                    cols.showOverlay();
                }
            }
        });

// This will prevent click from triggering twice when clicking checkbox/label

        $('input[type=checkbox]').on('click', function(e) {
            e.stopImmediatePropagation();
        });



// When you click the overlay, close everything

        $('#main > .overlay').on('click', function() {
            cols.hideOverlay();
            cols.hideMessage();
            cols.hideSidebar();
        });



// Enable sexy scrollbars
        $('.nano').nanoScroller();

        $('.message-list-load').click(function(){
            $('.message-list-load').removeClass('active').addClass('inactive');
            $(this).removeClass('inactive').addClass('active');
        });

    });
</script>
<style>
    .message-list-load.active {
        box-shadow:inset 0 0 0 100px rgba(0,0,0,0.1);
    }
</style>