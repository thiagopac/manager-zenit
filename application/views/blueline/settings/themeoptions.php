<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_theme_options');?>
		</div>
		<div class="table-div settings">
			<?php 
        $attributes = ['class' => '', 'id' => 'theme_options'];
        echo form_open_multipart($form_action, $attributes);
        ?>

			<div class="form-header">
				<?=$this->lang->line('application_theme_colors');?>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_activate_custom_colors');?>
						</label>
						<input name="custom_colors" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_activate_custom_colors');?>"
						 value="1" <?php if ($settings->custom_colors == '1') {
            ?> checked="checked"
						<?php
        } ?>>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_top_bar_background');?>
						</label>
						<input id="top_bar_background" name="top_bar_background" type="text" class="form-control colorpickerinput" value="<?=$settings->top_bar_background;?>"
						/>
						<span class="top_bar_background color-previewer" style="background-color:<?=$settings->top_bar_background;?>"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_top_bar_color');?>
						</label>
						<input id="top_bar_color" name="top_bar_color" type="text" class="form-control colorpickerinput" value="<?=$settings->top_bar_color;?>"
						/>
						<span class="top_bar_color color-previewer" style="background-color:<?=$settings->top_bar_color;?>"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_body_background');?>
						</label>
						<input id="body_background" name="body_background" type="text" class="form-control colorpickerinput" value="<?=$settings->body_background;?>"
						/>
						<span class="body_background color-previewer" style="background-color:<?=$settings->body_background;?>"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_menu_background');?>
						</label>
						<input id="menu_background" name="menu_background" type="text" class="form-control colorpickerinput" value="<?=$settings->menu_background;?>"
						/>
						<span class="menu_background color-previewer" style="background-color:<?=$settings->menu_background;?>"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_menu_color');?>
						</label>
						<input id="menu_color" name="menu_color" type="text" class="form-control colorpickerinput" value="<?=$settings->menu_color;?>"
						/>
						<span class="menu_color color-previewer" style="background-color:<?=$settings->menu_color;?>"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>
							<?=$this->lang->line('application_primary_color');?>
						</label>
						<input id="primary_color" name="primary_color" type="text" class="form-control colorpickerinput" value="<?=$settings->primary_color;?>"
						/>
						<span class="primary_color color-previewer" style="background-color:<?=$settings->primary_color;?>"></span>
					</div>

				</div>


			</div>

			<div class="form-header">
				<?=$this->lang->line('application_login_page');?>
			</div>



			<div class="form-group">
				<label>
					<?=$this->lang->line('application_login');?>
						<?=$this->lang->line('application_logo');?>

							<?php if ($core_settings->login_logo != '') {
            ?>
							<button type="button" class="btn-option po " data-toggle="popover" data-placement="right" data-content="<div style='padding:10px'><img src='<?=base_url(); ?><?=$core_settings->login_logo; ?>'></div>"
							 data-original-title="<?=$this->lang->line('application_login'); ?> <?=$this->lang->line('application_logo'); ?>">
								<i class="ion-eye"></i>
							</button>
							<?php
        } ?>
				</label>
				<div>
					<input id="uploadFile2" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>"
					 disabled="disabled" />
					<div class="fileUpload btn btn-primary">
						<span>
							<i class="icon dripicons-upload"></i>
							<span class="hidden-xs">
								<?=$this->lang->line('application_select');?>
							</span>
						</span>
						<input id="uploadBtn2" type="file" name="userfile2" class="upload" />
					</div>
				</div>

			</div>

			<div class="form-group">
				<label>
					<?=$this->lang->line('application_login_background');?>
				</label>
				<select name="login_background" id="login_background" class="formcontrol chosen-select ">
					<?php foreach ($backgrounds as $value) {
            ?>
					<option value="<?=$value; ?>" <?php if ($settings->login_background == $value) {
                ?>selected=""
						<?php
            } ?> >
							<?=$value; ?>
					</option>
					<?php
        } ?>
				</select>
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_upload_background');?>
				</label>
				<div>
					<input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled"
					/>
					<div class="fileUpload btn btn-primary">
						<span>
							<i class="icon dripicons-upload"></i>
							<span class="hidden-xs">
								<?=$this->lang->line('application_select');?>
							</span>
						</span>
						<input id="uploadBtn" type="file" name="userfile" class="upload" />
					</div>
				</div>

			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_login_style');?>
				</label>
				<select name="login_style" id="login_style" class="formcontrol chosen-select ">
					<option value="left" <?php if ($settings->login_style == 'left') {
            ?>selected=""
						<?php
        } ?> >
							<?=$this->lang->line('application_left');?>
					</option>
					<option value="center" <?php if ($settings->login_style == 'center') {
            ?>selected=""
						<?php
        } ?> >
							<?=$this->lang->line('application_center');?>
					</option>
				</select>
			</div>

			<div class="image-page-frame">
				<img class="hidden-xs <?php if ($settings->login_style != ' left ') {
            echo 'hidden ';
        }?>" id="login_style_left" style="max-height:200px" src="<?=base_url()?>/assets/blueline/images/login_side.jpg">
				<img class="hidden-xs <?php if ($settings->login_style != ' center ') {
            echo 'hidden ';
        }?>" id="login_style_center" style="max-height:130px; margin-top:25px; margin-left: 110px; position:absolute;"
				 src="<?=base_url()?>/assets/blueline/images/login_side.jpg">
				<img class="hidden-xs" id="background_preview" style="max-height:200px" src="<?=base_url()?>/assets/blueline/images/backgrounds/<?=$settings->login_background;?>">
				<img class="visible-xs img-responsive" src="<?=base_url()?>/assets/blueline/images/backgrounds/<?=$settings->login_background;?>">
			</div>

			<script>
				$(function() {
					var colors = {
						'#161b1f': '#161b1f',
						'#d8dce3': '#d8dce3',
						'#11a7db': '#11a7db',
						'#2aa96b': '#2aa96b',
						'#5bc0de': '#5bc0de',
						'#f0ad4e': '#f0ad4e',
						'#ed5564': '#ed5564'
					};
					var sliders = {
						saturation: {
							maxLeft: 200,
							maxTop: 200
						},
						hue: {
							maxTop: 200
						},
						alpha: {
							maxTop: 200
						}
					};
					$('.colorpickerinput').colorpicker({
						customClass: 'colorpicker-2x',
						colorSelectors: colors,
						align: 'left',
						sliders: sliders
					}).on('changeColor', function(e) {
						if (e.target.id == "body_background") {
							$('body')[0].style.backgroundColor = e.color;
							$('.body_background.color-previewer')
								.css('background', e.color);

						}
						if (e.target.id == "menu_background") {
							$('.sidebar-bg')[0].style.backgroundColor = e.color;
							$('.menu_background.color-previewer')
								.css('background', e.color);
							$('.user_online__indicator')
								.css('border-color', e.color);

						}
						if (e.target.id == "primary_color") {
							$(
									'.btn-primary, .progress-bar, .popover-title, .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover, .fc-state-default, .chosen-container-multi .chosen-choices li.search-choice'
								)
								.css('background', e.color);

							$('.table-head, #main .action-bar, #message .header, .form-header, .notification-center__header a.active')
								.css('box-shadow', ' 0 -2px 0 0 ' + e.color + ' inset');

							$('.form-header')
								.css('color', e.color);
							var oldcolor = e.color.toRGB();
							newcolor = "rgba(" + oldcolor.r + ", " + oldcolor.g + ", " + oldcolor.b + ", 0.8)";
							$(
									'.nav.nav-sidebar>li.active>a, .modal-header, .ui-slider-range, .ui-slider-handle:before,.list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus,.icon-frame'
								)
								.css('background-image', 'linear-gradient(to right, ' + e.color + ' 0%, ' + e.color + ' 100%)');

							$('.primary_color.color-previewer')
								.css('background', e.color);
						}
						if (e.target.id == "menu_color") {
							$('.sidebar a, .sidebar h4, .nav>li>a, .nav-sidebar span.menu-icon i')
								.css('color', e.color);

							$('.menu_color.color-previewer')
								.css('background', e.color);

						}
						if (e.target.id == "top_bar_background") {
							$('.mainnavbar')
								.css('background-color', e.color);
							$('.topbar__icon_alert')
								.css('border-color', e.color);

							$('.top_bar_background.color-previewer')
								.css('background', e.color);
						}
						if (e.target.id == "top_bar_color") {
							$('.mainnavbar')
								.css('color', e.color);

							$('.top_bar_background.color-previewer')
								.css('background', e.color);
						}




					});
				});
			</script>



			<div class="form-group no-border">
				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>

			<?php echo form_close(); ?>
		</div>
	</div>
		<script>
			$('#login_background').on('change', function(evt, params) {
				$("#background_preview").attr("src", "<?=base_url()?>/assets/blueline/images/backgrounds/" + params.selected);
			});
			$('#login_style').on('change', function(evt, params) {
				$("#login_style_left").toggleClass("hidden");
				$("#login_style_center").toggleClass("hidden");

			});
		</script>
	</div>
</div>