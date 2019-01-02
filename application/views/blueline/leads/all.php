<div class="col-sm-13  col-md-12 main">
	<div class="row">
		
		<div id="kanban-page">
			<a v-if="stages.length > 1" href="<?=base_url()?>leads/create" class="btn btn-primary" data-toggle="mainmodal" v-cloak>
			<?=$this->lang->line('application_create_lead');?>
			</a>
			<a href="<?=base_url()?>leads/status/create" class="btn btn-primary" data-toggle="mainmodal" v-cloak>
				<?=$this->lang->line('application_create_status');?>
			</a>
			<a v-if="stages.length > 1" href="<?=base_url()?>leads/import" class="btn btn-success" data-toggle="mainmodal" v-cloak>
				<?=$this->lang->line('application_import_leads');?>
			</a>
			<input class="kanban-search pull-right" :class="(search != '') ? 'active' : ''" type="text" name="search" v-model="search" placeholder="<?=$this->lang->line('application_search');?>"
			/>
			<div class="select-wrapper pull-right" v-cloak>
				<select class="kanban-tags" type="text" name="tagsearch" v-model="tagSearch" placeholder="<?=$this->lang->line('application_tags');?>">
					<option value="" selected>
						<?=$this->lang->line('application_all_tags');?>
					</option>
					<option v-for="tag in getAllTags" :value="tag" v-cloak>{{ tag }}</option>
				</select>
			</div>
			<kanban-board :stages="stages" :blocks="getLeads" @update-block="updateBlock" @delete-block="deleteBlock">
				<div v-for="(stage, index) in stages" :slot="stage.name" v-cloak>
					<div class="btn-group pull-right-responsive">
						<i class="options icon dripicons-dots-3 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a data-toggle="mainmodal" :href="'<?=base_url()?>leads/status/edit/'+stage.id">
									<?=$this->lang->line('application_edit');?>
								</a>
							</li>
							<li>
								<a @click="deleteStatus(stage.id, index)" href="#">
									<?=$this->lang->line('application_delete');?>
								</a>
							</li>
							<li v-if="index > 0">
								<a @click="moveStatus(stage.id, index, 'left')" href="#">
									<i class="icon dripicons-arrow-thin-left"></i>
									<?=$this->lang->line('application_move_left');?>
								</a>
							</li>
							<li v-if="index < maxStages-1">
								<a @click="moveStatus(stage.id, index, 'right')" href="#">
									<i class="icon dripicons-arrow-thin-right"></i>
									<?=$this->lang->line('application_move_right');?>
								</a>
							</li>
						</ul>
					</div>
				</div>

				<div v-for="(block, index) in getLeads" :slot="block.id" v-cloak>

					<div>
						<i class="status-icon private-icon pull-left ionicons ion-lock-combination tippy" title="<?=htmlspecialchars($this->lang->line('application_private_lead'));?>"
						 v-if="block.private != 0"></i>
						<span class="block-title">{{ block.name }}</span>
						<div class="pull-right switcher-button-container">
							<i class="status-icon switcher-button ionicons" :class="(block.icon != null && block.icon != '') ? block.icon : 'ion-ios-pricetag'"
							 @click="openThisSwitch(block.id)"></i>
							<transition name="fade-slide-down">
								<div v-if="openSwitch == block.id" class="switcher-group">
									<i v-if="block.icon != null && block.icon != ''" class="status-icon ionicons ion-ios-pricetag tippy" data-position="left"
									 title="" @click="setIcon(block.id, '')"></i>
									<i v-if="block.icon != 'cold'" class="status-icon ionicons cold tippy" data-position="left" title="<?=htmlspecialchars(addslashes($this->lang->line('application_cold')));?>"
									 @click="setIcon(block.id, 'cold')"></i>
									<i v-if="block.icon != 'hot'" class="status-icon ionicons hot tippy" data-position="left" title="<?=htmlspecialchars(addslashes($this->lang->line('application_hot')));?>"
									 @click="setIcon(block.id, 'hot')"></i>
									<i v-if="block.icon != 'won'" class="status-icon ionicons won tippy" data-position="left" title="<?=htmlspecialchars(addslashes($this->lang->line('application_won')));?>"
									 @click="setIcon(block.id, 'won')"></i>
								</div>
							</transition>
						</div>
					</div>

					<div class="block-subtitle">
						{{ block.company }}
					</div>

					<div v-if="inDueReminders(block.id)" @click="openThisBlock(block.id); loadReminders(block.id);" class="pull-right switcher-button-container">
						<i class="bell-icon icon dripicons-bell bell"></i>
					</div>

					<div class="block-details" v-if="block.id == openBlock" :class="(block.id == openBlock) ? 'block-details-open' : ''">
						<ul class="nav nav-tabs nav-tabs-lead">

							<li :class="(openDetails == block.id) ? 'active' : '' ">
								<a @click="loadDetails(block.id)" href="#details">
									<i class="icon dripicons-information tippy" title="<?=$this->lang->line('application_details');?>"></i>
								</a>
							</li>

							<li :class="(openActivities == block.id) ? 'active' : '' ">
								<a @click="loadActivities(block.id)" href="#activities">
									<i class="icon dripicons-message tippy" title="<?=$this->lang->line('application_activities');?>"></i>
								</a>
							</li>

							<li :class="(openReminders == block.id) ? 'active' : '' ">
								<a id="remindertab" @click="loadReminders(block.id)" href="#reminders">
									<i class="icon dripicons-bell tippy" title="<?=$this->lang->line('application_reminder');?>"></i>
								</a>
							</li>

							<li>
								<a data-toggle="mainmodal" :href="'<?=base_url()?>leads/edit/'+block.id">
									<i class="icon dripicons-gear tippy" title="<?=$this->lang->line('application_edit');?>"></i>
								</a>
							</li>
						</ul>

						<div class="tab-content">
							<div class="tab-pane tab1" v-if="openDetails == block.id" :class="(openDetails == block.id) ? 'in active animated slideInLeft' : '' ">
								<ul class="details">
									<li v-if="block.position  != ''">
										<span>
											<?=$this->lang->line('application_position');?>
										</span>
										{{ block.position }}
									</li>
									<li v-if="block.address != '' || block.city != '' || block.zipcode != '' || block.country != ''">
										<span>
											<?=$this->lang->line('application_address');?>
										</span>
										{{ block.address}} {{ block.city }} {{ block.zipcode}} {{ block.country }}
									</li>
									<li v-if="block.email  != ''">
										<span>
											<?=$this->lang->line('application_email');?>
										</span>
										{{ block.email }}
									</li>
									<li v-if="block.website  != ''">
										<span>
											<?=$this->lang->line('application_website');?>
										</span>
										<a :href="block.website" target="_blank">{{ block.website }}</a>
									</li>
									<li v-if="block.phone  != ''">
										<span>
											<?=$this->lang->line('application_phone');?>
										</span>
										{{ block.phone }}
									</li>
									<li v-if="block.mobile  != ''">
										<span>
											<?=$this->lang->line('application_mobile');?>
										</span>
										{{ block.mobile }}
									</li>
									<li v-if="block.language  != ''">
										<span>
											<?=$this->lang->line('application_language');?>
										</span>
										{{ block.language }}
									</li>
									<li v-if="block.source != ''">
										<span>
											<?=$this->lang->line('application_source');?>
										</span>
										{{ block.source }}
									</li>
									<li v-if="block.tags" class="tags">
										<span>
											<?=$this->lang->line('application_tags');?>
										</span>
										<span v-for="tag in blockTags(block.tags)" class="label label-success">{{ tag }}</span>
									</li>
									<li v-if="block.description  != ''">
										<span>
											<?=$this->lang->line('application_description');?>
										</span>
										<p v-html="block.description"></p>
									</li>
									<li v-if="block.user_id  != 0">
										<span>
											<?=$this->lang->line('application_agent');?>
										</span>
										{{ block.user.firstname }} {{ block.user.lastname }}
									</li>
									<li v-if="block.created != ''">
										<span>
											<?=$this->lang->line('application_created');?>
										</span>
										{{ datetime(block.created) }}
									</li>
									<li v-if="block.modified != ''">
										<span>
											<?=$this->lang->line('application_modified');?>
										</span>
										{{ datetime(block.modified) }}
									</li>
									<li v-if="block.valid_until != ''">
										<span>
											<?=$this->lang->line('application_valid_until');?>
										</span>
										{{ datetime(block.valid_until) }}
									</li>
								</ul>
							</div>

							<div class="tab-pane tab2" v-if="openActivities == block.id" :class="(openActivities == block.id) ? 'in active animated slideInRight' : '' ">

								<div class="form-group filled chat_message_input">

									<textarea name="message" v-model.trim.lazy="commentForm.message" class="form-control autogrow message" placeholder="<?=$this->lang->line('application_write_message');?>"></textarea>
									<span class="options">

										<i class="ion-ios-paperplane-outline tippy" v-if="!formLoading" @click="submitComment(block.id)" title="<?=$this->lang->line('application_send');?>"></i>
										<img class="loading" src="<?=base_url()?>assets/blueline/images/loading_mini_ripple.gif" v-show="formLoading" />
										<i class="ion-android-attach tippy chat-attach" v-if="!formLoading" title="<?=$this->lang->line('application_attachment');?>"></i>
										<input type="file" name="userfile" @change="uploadAttachment" :data-image-holder="'image_holder_'+block.id" class="chat-attachment lead-attachment hidden">

									</span>
									<div class="lead-image-preview" v-if="attachment.file">
										<div class="lead-upload-progress" v-if="uploadProcess">
											{{ uploadProcess }}%
											<div class="progress">
												<div class="progress-bar" role="progressbar" :aria-valuenow="uploadProcess" aria-valuemin="0" aria-valuemax="100" :style="'width:'+ uploadProcess+'%'"></div>
											</div>
										</div>
										<span v-if="!uploadProcess" class="remove tippy" @click="removeAttachment" title="<?=$this->lang->line('application_delete');?>">
											<i class="ionicons ion-close-round"></i>
										</span>
										<img v-if="attachment.image" :src="attachment.image" />
										<div v-if="!attachment.image" class="file-icon file-icon-lg" :data-type="getFileType"></div>
										<p class="file-name">{{ attachment.name }}</p>
									</div>
								</div>

								<div class="center" v-show="activitiesLoading">
									<div class="pulse"></div>
									<div class="pulse-inner"></div>
								</div>

								<div class="center" v-if="comments == '' && !activitiesLoading">
									<p class="shadow-icon">
										<i class="ionicons ion-ios-chatbubble-outline"></i>
									</p>
									<span class="shadow-text">
										<?=$this->lang->line('application_no_activities_yet');?>
									</span>
								</div>

								<div v-if="!activitiesLoading">
									<transition-group name="list" tag="ul" class="lead-comments" appear>
										<li v-for="comment in comments" v-bind:key="comment.id">
											<img class="userpic img-circle" :src="comment.user.userpic">
											<span class="username">{{ comment.user.firstname }} {{ comment.user.lastname }}</span>
											<span class="time">{{ getTime(comment.datetime, "MMM Do YY") }}</span>
											<div class="comment-wrapper arrow-box arrow-top-left">
												<p>{{ comment.message }}</p>
											</div>
											<div class="lead-attachment" v-if="comment.attachment">
												<a v-if="isImage(comment.attachment_link)" :href="'<?=base_url()?>files/media/'+comment.attachment_link" :data-lightbox="'lead'+comment.lead_id"
												 :data-title="comment.attachment">
													<img :src="'<?=base_url()?>files/media/thumb_'+comment.attachment_link" />
												</a>
												<a v-if="!isImage(comment.attachment_link)" :href="'<?=base_url()?>leads/attachment/'+comment.id">
													<div v-if="!isImage(comment.attachment_link)" class="file-icon file-icon-lg" :data-type="getExt(comment.attachment_link)"></div>
												</a>
												<p class="file-name">{{ comment.attachment }}</p>
											</div>
										</li>
									</transition-group>
								</div>

							</div>

							<div class="tab-pane tab3" v-if="openReminders == block.id" :class="(openReminders == block.id) ? 'in active animated slideInRight' : '' ">

								<a :href="'<?=base_url()?>leads/reminder/create/'+block.id" class="btn btn-primary btn-block lead-reminder-button" data-toggle="mainmodal">
									<?=$this->lang->line('application_create_reminder');?>
								</a>

								<div class="center" v-show="reminders == '' && !remindersLoading">
									<p class="shadow-icon">
										<i class="ionicons ion-ios-bell-outline"></i>
									</p>
									<span class="shadow-text">
										<?=$this->lang->line('application_no_reminders_yet');?>
									</span>
								</div>

								<div class="center" v-show="remindersLoading">
									<div class="pulse"></div>
									<div class="pulse-inner"></div>
								</div>

								<transition-group name="list" tag="ul" class="lead-reminders" appear>
									<li v-for="(reminder, index) in reminders" v-bind:key="reminder.id">
										<div class="reminder-wrapper has-hover-options" :class="[(isDue(reminder.datetime) && reminder.done == 0) ? 'red' : 'green', (reminder.done == 1) ? 'gray' : '']">
											<i class="icon dripicons-bell" :class="[(isDue(reminder.datetime) && reminder.done == 0) ? 'bell' : '']"></i>
											<span class="reminder-datetime" :title="overDue(reminder.datetime)" :class="(reminder.done == 0) ? 'tippy' : ''">
												{{ datetime(reminder.datetime) }}
											</span>
											<div class="pull-right hover-options">
												<i class="icon dripicons-trash" @click="deleteReminder(reminder.id, index)"></i>
												<a :href="'<?=base_url()?>leads/reminder/edit/'+reminder.id" data-toggle="mainmodal">
													<i class="icon dripicons-pencil"></i>
												</a>
											</div>

											<p>
												<i @click="toggleReminder(reminder.id)" class="ionicons reminder-check tippy" :class="(reminder.done == 1) ? 'ion-android-checkbox-outline' : 'ion-android-checkbox-outline-blank'"
												 title="<?=$this->lang->line('application_done');?>"></i> {{ reminder.title }}</p>
										</div>
									</li>
								</transition-group>
							</div>

						</div>
					</div>
					<div class="row block-actions">

						<a class="col-xs-2 center tippy" :class="(block.address != '' || block.city != '' || block.zipcode != '' || block.country != '') ? '' : 'grayout'"
						 :href="'https://maps.google.com?q='+block.address+'+'+block.city+'+'+block.zipcode+'+'+block.country" target="_blank"
						 :title="(block.address != '' || block.city != '' || block.zipcode != '' || block.country != '') ? block.address+' '+block.city+' '+block.zipcode+' '+block.country : ''">
							<i class="icon dripicons-direction"></i>
						</a>
						<a class="col-xs-2 center tippy" :class="(block.website != '') ? '' : 'grayout'" :href="block.website" :title="block.website"
						 target="_blank">
							<i class="icon dripicons-web"></i>
						</a>
						<a class="col-xs-2 center tippy" :class="(block.email != '') ? '' : 'grayout'" :href="'mailto:'+block.email" :title="block.email" target="_blank">
							<i class="icon dripicons-mail"></i>
						</a>
						<a class="col-xs-2 center tippy" :class="(block.phone != '') ? '' : 'grayout'" :href="'tel:'+normalizePhoneNumber(block.phone)"
						 :title="block.phone">
							<i class="icon dripicons-phone"></i>
						</a>
						<a class="col-xs-2 center tippy" :class="(block.mobile != '') ? '' : 'grayout'" :href="'tel:'+normalizePhoneNumber(block.mobile)"
						 :title="block.mobile">
							<i class="icon dripicons-device-mobile"></i>
						</a>
						<a class="col-xs-2 center tippy" href="#" @click="openThisBlock(block.id)" title="<?=$this->lang->line('application_details');?>">
							<i class="icon dripicons-dots-3"></i>
						</a>
					</div>

				</div>
				
			</kanban-board>
				<div class="kanban-empty-state" v-if="maxStages == 1 && kanbanReady" v-cloak>
					<svg width="64px" height="64px" viewBox="0 0 64 64" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" opacity="0.312330163">
							<g id="share" transform="translate(32.000000, 32.000000) rotate(-90.000000) translate(-32.000000, -32.000000) " fill="#1D1D1B" fill-rule="nonzero">
								<path d="M63.386,16.193 L63.388,16.191 C63.39,16.188 63.392,16.185 63.394,16.181 C63.566,15.986 63.692,15.751 63.793,15.503 C63.825,15.427 63.846,15.355 63.869,15.278 C63.927,15.087 63.963,14.889 63.975,14.682 C63.981,14.606 63.993,14.534 63.991,14.456 C63.991,14.416 64.001,14.38 63.999,14.341 C63.985,14.102 63.937,13.871 63.863,13.654 C63.857,13.631 63.841,13.613 63.833,13.59 C63.745,13.351 63.619,13.139 63.47,12.945 C63.449,12.918 63.442,12.882 63.42,12.855 L53.109,0.709 C52.32,-0.221 51.025,-0.239 50.215,0.672 C49.407,1.582 49.392,3.074 50.183,4.006 L55.741,10.555 C47.62,9.479 39.637,11.188 39.26,11.272 C14.614,15.739 -2.827,38.499 0.38,62.008 C0.539,63.172 1.408,64 2.399,64 C2.505,64 2.611,63.991 2.719,63.973 C3.835,63.77 4.597,62.564 4.423,61.277 C1.566,40.337 17.479,19.995 39.96,15.919 C40.063,15.895 48.311,14.125 56.077,15.345 L47.5,20.438 C46.495,21.036 46.102,22.458 46.619,23.615 C47.135,24.774 48.367,25.223 49.375,24.632 L62.895,16.604 C63.078,16.493 63.242,16.354 63.386,16.193 Z" id="Shape"></path>
							</g>
						</g>
					</svg>
					<?=$this->lang->line('application_no_status_yet');?>
				</div>
			<notifications group="kanban" position="bottom right" />
		</div>
	</div>
</div>

<?php if (isset($search)) :?>
	<script>
        sessionStorage . setItem('lead', '<?=$search?>');
	</script>
<?php endif; ?>