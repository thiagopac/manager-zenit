<div class="col-md-3 col-lg-2 no-padding">
	<div class="list-group">
		<?php 

                foreach ($submenu as $name => $value):
                    if ($value == 'devider') {
                        echo '<div class="list-group-item-spacer"></div>';
                        continue;
                    }
                $badge = '';
                $active = '';
                if ($value == 'settings/updates' && $update_count) {
                    $badge = '<span class="badge badge-success">' . $update_count . '</span>';
                }
                if (str_replace('settings/', '', $value) == $breadcrumb_id) {
                    $active = 'active';
                }
                ?>
		<a class="list-group-item <?=$active;?>" id="<?php $val_id = explode(' / ', $value); if (!is_numeric(end($val_id))) {
                    echo end($val_id);
                } else {
                    $num = count($val_id) - 2;
                    echo $val_id[$num];
                } ?>" href="<?=site_url($value);?>">
			<?=$badge?>
				<span class="icon <?=$iconlist[$value];?> list-group-item-icon"></span>
				<span>
					<?=$name?>
				</span>
		</a>
		<?php endforeach;?>
	</div>
</div>