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

        if ($_GET['state'] == $this->lang->line('application_state')){
            $_GET['state'] = null;
        }

        if ($_GET['deadline'] == $this->lang->line('application_supplier_deadline')){
            $_GET['deadline'] = null;
        }

        if ($_GET['payment'] == $this->lang->line('application_payment_condition')){
            $_GET['payment'] = null;
        }

        if ($_GET['segment'] == $this->lang->line('application_segments')){
            $_GET['segment'] = null;
        }

        if ($_GET['state'] != null || $_GET['deadline'] != null || $_GET['payment'] != null || $_GET['segment'] != null){

            if ($_GET['state'] == null){
                $_GET['state'] = "%";
            }

            if ($_GET['deadline'] == null){
                $_GET['deadline'] = "%";
            }

            if ($_GET['payment'] == null){
                $_GET['payment'] = "%";
            }


            $segment_id = null;

            if ($_GET['segment'] == null){
                $_GET['segment'] = "%";
                $segment_id = '%';
            }

            $all_segments = SupplierCategory::find('all');

            if ($_GET['segment'] != null){
                foreach ($all_segments as $segment){
                    if ($segment->name == $_GET['segment']){
                        $segment_id = "%$segment->id%";
                    }
                }
            }

            $filter = ['conditions' => ['state LIKE ? AND supplier_deadline LIKE ? AND payment_condition LIKE ? AND supplier_category_ids LIKE ?',  $_GET['state'], $_GET['deadline'], $_GET['payment'], $segment_id]];

            $this->view_data['suppliers'] = Supplier::find('all', $filter);
        }else{
            $this->view_data['suppliers'] = Supplier::find('all');
        }

        if ($_GET['state'] == '%'){
            $active_state_filter = $this->lang->line('application_state');
        }else{
            $active_state_filter = $_GET['state'];
        }

        if ($_GET['deadline'] == '%'){
            $active_deadline_filter = $this->lang->line('application_supplier_deadline');
        }else{
            $active_deadline_filter = $_GET['deadline'];
        }

        if ($_GET['payment'] == '%'){
            $active_payment_filter = $this->lang->line('application_payment_condition');
        }else{
            $active_payment_filter = $_GET['payment'];
        }

        if ($_GET['segment'] == '%'){
            $active_segment_filter = $this->lang->line('application_segments');
        }else{
            $active_segment_filter = $_GET['segment'];
        }

        $this->view_data['active_state_filter'] = $active_state_filter;
        $this->view_data['active_deadline_filter'] = $active_deadline_filter;
        $this->view_data['active_payment_filter'] = $active_payment_filter;
        $this->view_data['active_segment_filter'] = $active_segment_filter;

        $stateList = array();
        $deadlineList = array();
        $paymentList = array();
        $segmentList = array();

        $all_suppliers = Supplier::find('all');
        $all_segments = SupplierCategory::all();

        foreach ($all_suppliers as $supplier){
            array_push($stateList, $supplier->state);
            array_push($deadlineList, $supplier->supplier_deadline);
            array_push($paymentList, $supplier->payment_condition);
        }

        foreach ($all_segments as $segment){
            array_push($segmentList, $segment->name);
        }

        $stateList = array_unique($stateList);
        $deadlineList = array_unique($deadlineList);
        $paymentList = array_unique($paymentList);

        $this->view_data['stateList'] = $stateList;
        $this->view_data['deadlineList'] = $deadlineList;
        $this->view_data['paymentList'] = $paymentList;
        $this->view_data['segmentList'] = $segmentList;

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
