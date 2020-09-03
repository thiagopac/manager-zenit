<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Intranet extends MY_Controller {

    public function __construct(){
        parent::__construct();
        unset($_POST['DataTables_Table_0_length']);
        $access = false;
        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'intranet') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }

        $submenu = [
            $this->lang->line('application_home') => 'intranet/home',
            $this->lang->line('application_institutional') => 'intranet/institutional',
            $this->lang->line('application_procedures') => 'intranet/procedures',
            $this->lang->line('application_communication') => 'intranet/communication',
            $this->lang->line('application_photo_gallery') => 'intranet/photos',
            $this->lang->line('application_videos') => 'intranet/videos'
        ];

        $iconlist = [
            'intranet/home' => 'dripicons-web',
            'intranet/institutional' => 'dripicons-graduation',
            'intranet/procedures' => 'dripicons-clipboard',
            'intranet/communication' => 'dripicons-volume-medium',
            'intranet/photos' => 'dripicons-photo-group',
            'intranet/videos' => 'dripicons-media-next'
        ];

        $forms = IntranetForm::find('all', ['conditions' => ['deleted != ? AND active = ? ORDER BY ordered ASC', 1, 1]]);

        $submenu_line = array();
        $iconlist_line = array();

        foreach ($forms as $form){
            $submenu_line["$form->name"] = "intranet/form/".$form->id;
            $iconlist_line["intranet/form/".$form->id] = 'dripicons-document-edit';
        }

        $submenu = array_merge($submenu, $submenu_line);
        $iconlist = array_merge($iconlist, $iconlist_line);

        if ($this->user->department_has_user("RH", $this->user) == true) {
            $submenu[$this->lang->line('application_projects_events')] = 'intranet/project';
            $iconlist['intranet/project'] = 'dripicons-suitcase';

            $submenu['Menus de formulários'] = 'intranet/forms';
            $iconlist['intranet/forms'] = 'dripicons-duplicate';
        }

        $this->view_data['submenu'] = $submenu;
        $this->view_data['iconlist'] = $iconlist;

        $this->config->load('defaults');
    }
    
    public function index(){
        $this->home();
    }

    public function home(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_home');
        $this->view_data['breadcrumb_id'] = 'intranet/home';

        $home_detail = IntranetHomeDetail::first();
        $this->view_data['home_detail'] = $home_detail;

        $home_fixeds = IntranetHomeFixed::all(['conditions' => ['deleted != ? ORDER BY id DESC', 1]]);
        $this->view_data['home_fixeds'] = $home_fixeds;

        $home_posts = IntranetHomePost::all(['conditions' => ['deleted != ? ORDER BY id DESC', 1], 'include' => ['intranet_file']]);
        $this->view_data['home_posts'] = $home_posts;

        $this->content_view = 'intranet/home';
    }

    public function institutional(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_institutional');
        $this->view_data['breadcrumb_id'] = 'intranet/institutional';

        $institutional_posts = IntranetInstitutionalFixed::all(['conditions' => ['deleted != ? ORDER BY id ASC', 1]]);
        $this->view_data['institutional_posts'] = $institutional_posts;

        $this->content_view = 'intranet/institutional';
    }

    public function procedures(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_procedures');
        $this->view_data['breadcrumb_id'] = 'intranet/procedures';

        $procedures_projects = IntranetProject::all(['conditions' => ['deleted != ? ORDER BY id ASC', 1]]);
        $this->view_data['procedures_projects'] = $procedures_projects;

        $this->content_view = 'intranet/procedures';
    }

    public function communication(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_communication');
        $this->view_data['breadcrumb_id'] = 'intranet/communication';

        $intranet_contacts = IntranetContact::all(['conditions' => ['deleted != ?', 1]]);
        $this->view_data['intranet_contacts'] = $intranet_contacts;

        $this->content_view = 'intranet/communication';
    }

    public function photos(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_photo_gallery');
        $this->view_data['breadcrumb_id'] = 'intranet/photos';

        $photo_projects = IntranetProject::all(['conditions' => ['deleted != ? ORDER BY id ASC', 1], 'include' => ['intranet_photo']]);
        $this->view_data['photo_projects'] = $photo_projects;

        $this->content_view = 'intranet/photos';
    }

    public function videos(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_videos');
        $this->view_data['breadcrumb_id'] = 'intranet/videos';

        $video_projects = IntranetProject::all(['conditions' => ['deleted != ? ORDER BY id ASC', 1], 'include' => ['intranet_video']]);
        $this->view_data['video_projects'] = $video_projects;

        $this->content_view = 'intranet/videos';
    }

    public function video($video_id){

        $video = IntranetVideo::find($video_id);
        $this->view_data['video'] = $video;

        $this->view_data['title'] = $this->lang->line('application_video');

        $this->theme_view = 'modal';
        $this->content_view = 'intranet/_video';
    }

    public function contact_update($id = false){
        $contact = IntranetContact::find($id);

        if ($_POST) {

            $contact->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_edit_success'));
            redirect('intranet/communication');
        } else {
            $this->view_data['contact'] = $contact;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_edit_contact');
            $this->view_data['form_action'] = 'intranet/contact_update/' . $contact->id;
            $this->content_view = 'intranet/_contact';
        }
    }

    public function contact_create(){

        if ($_POST) {

            $options = ['conditions' => ['email = ?', $_POST['email']]];
            $contact_exists = IntranetContact::find($options);

            if (empty($contact_exists)) {

                $contact = IntranetContact::create($_POST);
                if (!$contact) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_add_success'));
                }
            }else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_exists'));
            }

            redirect('intranet/communication');
        } else {
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_add_contact');
            $this->view_data['form_action'] = 'intranet/contact_create/';
            $this->content_view = 'intranet/_contact';
        }
    }

    public function contact_delete($contact_id = false){

        $options = ['conditions' => ['id = ?', $contact_id]];
        $contact = IntranetContact::find($options);
        $contact->deleted = 1;
        $contact->save();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));
        redirect('intranet/communication');
    }

    public function project(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_projects_events');
        $this->view_data['breadcrumb_id'] = 'intranet/project';

        $intranet_projects = IntranetProject::all(['conditions' => ['deleted != ?', 1]]);
        $this->view_data['intranet_projects'] = $intranet_projects;

        $this->content_view = 'intranet/project';
    }

    public function project_update($id = false){
        $project = IntranetProject::find($id);

        if ($_POST) {

            $project->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_edit_success'));
            redirect('intranet/project');
        } else {
            $this->view_data['project'] = $project;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_edit_project');
            $this->view_data['form_action'] = 'intranet/project_update/' . $project->id;
            $this->content_view = 'intranet/_project';
        }
    }

    public function project_create(){

        if ($_POST) {

            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $project_exists = IntranetProject::find($options);

            if (empty($project_exists)) {

                $project = IntranetProject::create($_POST);
                if (!$project) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_add_success'));
                }
            }else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_exists'));
            }

            redirect('intranet/project');
        } else {
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_add_project_event');
            $this->view_data['form_action'] = 'intranet/project_create/';
            $this->content_view = 'intranet/_project';
        }
    }

    public function project_delete($project_id = false){

        $options = ['conditions' => ['id = ?', $project_id]];
        $project = IntranetProject::find($options);
        $project->deleted = 1;
        $project->save();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));
        redirect('intranet/project');
    }

    public function form($form_id){

        $form = IntranetForm::find($form_id);

        $this->view_data['breadcrumb'] = $form->name;
        $this->view_data['breadcrumb_id'] = "intranet/form/".$form->id;
        $this->view_data['form'] = $form;

        $this->content_view = 'intranet/form';
    }

    public function forms(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = 'Menus de formulários';
        $this->view_data['breadcrumb_id'] = 'intranet/forms';

        $intranet_forms = IntranetForm::all(['conditions' => ['deleted != ?', 1]]);
        $this->view_data['intranet_forms'] = $intranet_forms;

        $this->content_view = 'intranet/forms';
    }

    public function form_update($id = false){
        $form = IntranetForm::find($id);

        if ($_POST) {

            $form->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_edit_success'));
            redirect('intranet/forms');
        } else {
            $this->view_data['form'] = $form;
            $this->theme_view = 'modal';

            $this->view_data['title'] = 'Editar formulário';
            $this->view_data['form_action'] = 'intranet/form_update/' . $form->id;
            $this->content_view = 'intranet/_form';
        }
    }

    public function form_create(){

        if ($_POST) {

            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $form_exists = IntranetForm::find($options);

            if (empty($form_exists)) {

                $form = IntranetForm::create($_POST);
                if (!$form) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_add_success'));
                }
            }else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_exists'));
            }

            redirect('intranet/forms');
        } else {
            $this->theme_view = 'modal';

            $this->view_data['title'] = "Adicionar formulário";
            $this->view_data['form_action'] = 'intranet/form_create/';
            $this->content_view = 'intranet/_form';
        }
    }

    public function form_delete($form_id = false){

        $options = ['conditions' => ['id = ?', $form_id]];
        $form = IntranetForm::find($options);
        $form->deleted = 1;
        $form->save();
        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));
        redirect('intranet/forms');
    }


//    public function insert_deposit_amount($from, $to){
//        gerar inserts para novos deposit_amount de materiais criados pelo Renny que não geraram automaticamente
//        for ($i = $from; $i <= $to, $i++;){
//
//            echo 'INSERT INTO `deposit_amount` (`deposit_id`, `material_id`, `quantity`) VALUES (2, '.$i.', 0);';
//            echo '<br />';
//
//            if ($i == 941) exit;
//        }
//
//    }
}
