<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class MaterialManagement extends MY_Controller{

    public function __construct(){

        parent::__construct();
        $access = false;
        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'materialmanagement') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    public function filter($deposit_id = false){

        $this->view_data['selected_deposit_id'] = $deposit_id;

        $entrances = MaterialHandling::find('all', ['conditions' => ["status != ? AND handling_type = ? AND deposit_id = ?", "deleted", "entrance", $deposit_id], 'include' => ['deposit', 'material']]);
        $outputs = MaterialHandling::find('all', ['conditions' => ["status != ? AND handling_type = ? AND deposit_id = ?", "deleted", "output", $deposit_id], 'include' => ['deposit', 'material']]);
        $deposits = Deposit::all();
        $this->view_data['entrances'] = $entrances;
        $this->view_data['outputs'] = $outputs;
        $this->view_data['deposits'] = $deposits;
        $this->content_view = 'materialhandling/all';
    }

    public function index($id = false){
        
        $entrances = MaterialHandling::find('all', ['conditions' => ["status != ? AND handling_type = ?", "deleted", "entrance"], 'include' => ['deposit', 'material']]);
        $outputs = MaterialHandling::find('all', ['conditions' => ["status != ? AND handling_type = ?", "deleted", "output"], 'include' => ['deposit', 'material']]);
        $deposits = Deposit::all();
        $this->view_data['entrances'] = $entrances;
        $this->view_data['outputs'] = $outputs;
        $this->view_data['deposits'] = $deposits;
        $this->content_view = 'materialhandling/all';
    }

    public function entrance_create($deposit_id = false){

        if($_POST){

            $deposit_id = $_POST['deposit_id'];
            $material_id = $_POST['material_id'];
            $quantity = $_POST['quantity'];

            $deposit_amount = DepositAmount::first(['conditions' => ["deposit_id = ? AND material_id = ?", $deposit_id, $material_id]]);

            if($deposit_amount){
                $deposit_amount->quantity += $quantity;
                $deposit_amount->save();
            }
            else{
                
                $deposit_amount = new DepositAmount();

                $deposit_amount->deposit_id = $deposit_id;
                $deposit_amount->material_id = $material_id;
                $deposit_amount->quantity = $quantity;
                
                $deposit_amount->save();
            }

            $_POST['handling_type'] = 'entrance';

            $entrance = MaterialHandling::create($_POST);

            if(!$entrance){
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_entrance_error'));
            }
            else{
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_entrance_success'));
            }

            redirect('materialmanagement/index');
        }
        else{
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_entrance');
            if($deposit_id){
                $this->view_data['deposit_id'] = $deposit_id;
            }
            else{
                $this->view_data['deposits'] = Deposit::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            }
            $this->view_data['materials'] = Material::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['form_action'] = 'materialmanagement/entrance_create';
            $this->content_view = 'materialhandling/_entranceform';
        }
    }

    public function entrance_update($entrance_id = false){

        if($_POST){

            $deposit_id = $_POST['deposit_id'];
            $material_id = $_POST['material_id'];
            $quantity = $_POST['quantity'];
            $date = $_POST['date'];

            $deposit_amount = DepositAmount::first(['conditions' => ["deposit_id = ? AND material_id = ?", $deposit_id, $material_id]]);
            $entrance = MaterialHandling::first(['conditions' => ["id = ?", $_POST['id']]]);

            $deposit_amount->deposit_id = $deposit_id;
            $deposit_amount->material_id = $material_id;
            $deposit_amount->date = $date;

            if($entrance->quantity > $quantity){
                $deposit_amount->quantity -= ($entrance->quantity - $quantity);
            }
            elseif($entrance->quantity < $quantity){
                $deposit_amount->quantity += ($quantity - $entrance->quantity);
            }

            $deposit_amount->save();

            $entrance->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_entrance_success'));
            redirect('materialmanagement/index');
        }
        else{
            $entrance = MaterialHandling::first(['conditions' => ["id = ?", $entrance_id]]);
            $deposits = Deposit::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $materials = Material::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_entrance');

            $this->view_data['entrance'] = $entrance;
            $this->view_data['deposits'] = $deposits;
            $this->view_data['materials'] = $materials;

            $this->view_data['form_action'] = 'materialmanagement/entrance_update/' . $entrance->id;
            $this->content_view = 'materialhandling/_entranceform';
        }
    }

    public function entrance_delete($entrance = false){

        $options = ['conditions' => ['id = ?', $entrance]];
        $entrance = MaterialHandling::find($options);

        if($entrance){
            
            $deposit_id = $entrance->deposit_id;
            $material_id = $entrance->material_id;

            $deposit_amount = DepositAmount::first(['conditions' => ["deposit_id = ? AND material_id = ?", $deposit_id, $material_id]]);
            $deposit_amount->quantity -= $entrance->quantity;
            $deposit_amount->save();

            $entrance->status = "deleted";
            $entrance->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_entrance_success'));
        }
        else{
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_entrance_error'));
        }

    }

    public function output_create($deposit_id = false){

        if($_POST){

            $deposit_id = $_POST['deposit_id'];
            $material_id = $_POST['material_id'];
            $quantity = $_POST['quantity'];

            $deposit_amount = DepositAmount::first(['conditions' => ["deposit_id = ? AND material_id = ?", $deposit_id, $material_id]]);

            if($deposit_amount->quantity >= $quantity){
                $deposit_amount->quantity -= $quantity;
                $deposit_amount->save();

                $_POST['handling_type'] = 'output';

                $output = MaterialHandling::create($_POST);

                if(!$output){
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_output_error'));
                }
                else{
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_output_success'));
                }
            }
            else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_output_error'));
            }

            redirect('materialmanagement/index');
        }
        else{
            
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_output');
            if($deposit_id){
                $this->view_data['deposit_id'] = $deposit_id;
                $this->view_data['materials'] = DepositAmount::find_by_sql("SELECT material_id, description FROM deposit_amount INNER JOIN material on material.id = deposit_amount.material_id WHERE deposit_id = ? AND quantity > 0 ORDER BY material.id ASC", [$deposit_id]);
            }
            else{
                $deposits = DepositAmount::find_by_sql("SELECT DISTINCT deposit_amount.deposit_id, deposit.name FROM deposit_amount INNER JOIN deposit on deposit.id = deposit_amount.deposit_id WHERE quantity > 0 ORDER BY deposit.id ASC");
                $materials = DepositAmount::find_by_sql("SELECT DISTINCT material_id, description FROM deposit_amount INNER JOIN material on material.id = deposit_amount.material_id WHERE quantity > 0 ORDER BY material.id ASC");
                $this->view_data['deposits'] = $deposits;
                $this->view_data['materials'] = $materials;
            }

            $this->view_data['form_action'] = 'materialmanagement/output_create';
            $this->content_view = 'materialhandling/_outputform';
        }
    }

    public function output_update($output_id = false){

        if($_POST){

            $deposit_id = $_POST['deposit_id'];
            $material_id = $_POST['material_id'];
            $quantity = $_POST['quantity'];
            $date = $_POST['date'];

            $deposit_amount = DepositAmount::first(['conditions' => ["deposit_id = ? AND material_id = ?", $deposit_id, $material_id]]);
            $output = MaterialHandling::first(['conditions' => ["id = ?", $_POST['id']]]);

            $output->deposit_id = $deposit_id;
            $output->material_id = $material_id;
            $output->date = $date;

            if($output->quantity > $quantity){
                
                $deposit_amount->quantity += ($output->quantity - $quantity);
            }
            elseif($output->quantity < $quantity){

                if($deposit_amount->quantity >= ($quantity - $output->quantity)){
                    
                    $deposit_amount->quantity -= ($quantity - $output->quantity);
                }
                else{
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_output_error'));
                    redirect('materialmanagement/index');
                }
            }

            $deposit_amount->save();

            $output->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_output_success'));
            redirect('materialmanagement/index');
        }
        else{
            $output = MaterialHandling::first(['conditions' => ["id = ?", $output_id]]);
            $deposits = Deposit::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $materials = Material::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_output');

            $this->view_data['output'] = $output;
            $this->view_data['deposits'] = $deposits;
            $this->view_data['materials'] = $materials;

            $this->view_data['form_action'] = 'materialmanagement/output_update/' . $output->id;
            $this->content_view = 'materialhandling/_outputform';
        }
    }

    public function output_delete($output = false){

        $options = ['conditions' => ['id = ?', $output]];
        $output = MaterialHandling::find($options);

        if($output){

            $deposit_id = $output->deposit_id;
            $material_id = $output->material_id;

            $deposit_amount = DepositAmount::first(['conditions' => ["deposit_id = ? AND material_id = ?", $deposit_id, $material_id]]);
            $deposit_amount->quantity += $output->quantity;
            $deposit_amount->save();

            $output->status = "deleted";
            $output->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_output_success'));
        }
        else{
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_output_error'));
        }

    }
}