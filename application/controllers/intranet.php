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

        $this->view_data['submenu'] = [
            $this->lang->line('application_home') => 'intranet/home',
            $this->lang->line('application_institutional') => 'intranet/institutional',
            $this->lang->line('application_procedures') => 'intranet/procedures',
            $this->lang->line('application_communication') => 'intranet/communication',
            $this->lang->line('application_ideas_and_improvements_form') => 'intranet/form',
            $this->lang->line('application_photo_gallery') => 'intranet/photos',
            $this->lang->line('application_videos') => 'intranet/videos'
        ];

        $this->view_data['iconlist'] = [
            'intranet/home' => 'dripicons-web',
            'intranet/institutional' => 'dripicons-graduation',
            'intranet/procedures' => 'dripicons-clipboard',
            'intranet/communication' => 'dripicons-volume-medium',
            'intranet/form' => 'dripicons-document-edit',
            'intranet/photos' => 'dripicons-photo-group',
            'intranet/videos' => 'dripicons-media-next'
        ];

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

        $home_fixed = IntranetHomeFixed::first();
        $this->view_data['home_fixed'] = $home_fixed;

        $home_posts = IntranetHomePost::all(['conditions' => ['deleted != ? ORDER BY id DESC', 1    ]]);
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

        $intranet_contacts = IntranetContact::all(['conditions' => ['deleted != ? ORDER BY name ASC', 1]]);
        $this->view_data['intranet_contacts'] = $intranet_contacts;

        $this->content_view = 'intranet/communication';
    }

    public function form(){

        $this->view_data['breadcrumb'] = $this->lang->line('application_form');
        $this->view_data['breadcrumb_id'] = 'intranet/form';

        $this->content_view = 'intranet/form';
    }

    public function photos(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_photo_gallery');
        $this->view_data['breadcrumb_id'] = 'intranet/photos';

        $photo_projects = IntranetProject::all(['conditions' => ['deleted != ? ORDER BY id ASC', 1]]);
        $this->view_data['photo_projects'] = $photo_projects;

        $this->content_view = 'intranet/photos';
    }

    public function videos(){
        $core_settings = Setting::first();
        $this->view_data['core_settings'] = $core_settings;

        $this->view_data['breadcrumb'] = $this->lang->line('application_videos');
        $this->view_data['breadcrumb_id'] = 'intranet/videos';

        $video_projects = IntranetProject::all(['conditions' => ['deleted != ? ORDER BY id ASC', 1]]);
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
