<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Suppliers extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cdashboard');
        } elseif ($this->user) {
            $this->view_data['project_access'] = false;
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'suppliers') {
                    $access = true;
                }
                if ($value->link == 'suppliers') {
                    $this->view_data['project_access'] = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    public function index(){
        $state_filter = ['conditions' => ['state = ?',  $_GET['state']]];

        if ($_GET['state'] != null){
            $this->view_data['suppliers'] = Supplier::find('all', $state_filter);

            $settings = Setting::first();
            $statesList = $settings->list_states();

            $active_state_filter = $statesList[$_GET['state']];

        }else{
            $this->view_data['suppliers'] = Supplier::find('all');
        }

        if ($_GET['state'] == null){
            $active_state_filter = $this->lang->line("application_state");
        }

        $this->view_data['active_state_filter'] = $active_state_filter;

        $this->content_view = 'suppliers/all';
    }

    public function supplier($condition = false, $id = false) {
        switch ($condition) {
            case 'create':
                if ($_POST) {
                    unset($_POST['send']);

                    $str_cats = implode(",",$_POST['supplier_categories']);
                    $_POST['supplier_category_ids'] = $str_cats;

                    unset($_POST['supplier_categories']);

                    $_POST['city'] = ucwords(strtolower($_POST['city']));

                    $supplier = Supplier::create($_POST);

                    if (!$supplier) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_add_success'));
                    }
                    redirect('suppliers');
                } else {
                    $this->view_data['banks'] = Bank::find('all');
                    $this->view_data['categories'] = $allcats = SupplierCategory::find('all');

                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_new_supplier');
                    $this->view_data['form_action'] = 'suppliers/supplier/create';
                    $this->content_view = 'suppliers/_supplier';
                }
            break;
            case 'update':
                if ($_POST) {
                    unset($_POST['send']);
                    $id = $_POST['id'];
                    if (isset($_POST['view'])) {
                        $view = $_POST['view'];
                        unset($_POST['view']);
                    }

                    $_POST['city'] = ucwords(strtolower($_POST['city']));

                    $str_cats = implode(",",$_POST['supplier_categories']);
                    $_POST['supplier_category_ids'] = $str_cats;
                    unset($_POST['supplier_categories']);

                    $supplier = Supplier::find_by_id($id);
                    $supplier->update_attributes($_POST);
                    if (!$supplier) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_edit_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_edit_success'));
                    }
                    redirect('suppliers');
                } else {
                    $this->view_data['supplier'] = $sup = Supplier::find_by_id($id);
                    $this->view_data['banks'] = Bank::find('all');
                    $this->view_data['categories'] = SupplierCategory::find('all');


                    if ($sup->supplier_category_ids != null){
                        $sup_cats = array();
                        $sup_cats_ids = explode(",",$sup->supplier_category_ids);
                        foreach ($sup_cats_ids as $id){
                            array_push($sup_cats, SupplierCategory::find($id));
                        }

                        $this->view_data['sup_cats'] = $sup_cats;
                    }

                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_edit_supplier');
                    $this->view_data['form_action'] = 'suppliers/supplier/update';
                    $this->content_view = 'suppliers/_supplier';
                }
                break;
                case 'delete':
                    $supplier = Supplier::find_by_id($id);

                    $supplier->delete();
                    $this->content_view = 'suppliers/all';
                    if (!$supplier) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_success'));
                    }
                        redirect('suppliers');
                break;
        }
    }

    public function category($condition = false, $id = false) {
        switch ($condition) {
            case 'create':
                if ($_POST) {
                    unset($_POST['send']);

                    $category = SupplierCategory::create($_POST);

                    if (!$category) {
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_add_success'));
                    }
                    redirect('suppliers');
                } else {

                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_new_segment');
                    $this->view_data['form_action'] = 'suppliers/category/create';
                    $this->content_view = 'suppliers/_category';
                }
                break;
        }
    }

}
