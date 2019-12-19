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

        $this->view_data['submenu'] = [
            $this->lang->line('application_entrance_output') => 'materialmanagement',
            $this->lang->line('application_dynamic_alarms') => 'materialmanagement/rules',
            $this->lang->line('application_deposits') => 'materialmanagement/deposits',
            $this->lang->line('application_stock_areas') => 'materialmanagement/stock_areas',
            $this->lang->line('application_deposit_stock_areas') => 'materialmanagement/deposit_stock_areas',
            $this->lang->line('application_material_types') => 'materialmanagement/material_types',
            $this->lang->line('application_materials') => 'materialmanagement/materials'
        ];

        $this->view_data['iconlist'] = [
            'materialmanagement' => 'dripicons-swap',
            'materialmanagement/rules' => 'dripicons-warning',
            'materialmanagement/deposits' => 'dripicons-store',
            'materialmanagement/stock_areas' => 'dripicons-view-thumb',
            'materialmanagement/deposit_stock_areas' => 'dripicons-view-list-large',
            'materialmanagement/material_types' => 'dripicons-list',
            'materialmanagement/materials' => 'dripicons-suitcase'
        ];

        $this->config->load('defaults');
    }

    public function deposit_amount($deposit_id = false){

        $materials = DepositAmount::find_by_sql("SELECT material.id, material.description, stock_area.name, quantity FROM deposit_amount
                                                INNER JOIN material on material.id = deposit_amount.material_id
                                                INNER JOIN material_type on material_type.id = material.material_type_id
                                                INNER JOIN stock_area on stock_area.id = material_type.stock_area_id
                                                where deposit_amount.deposit_id = ?", [$deposit_id]);
        
        $this->theme_view = 'modal';
        $this->view_data['title'] = $this->lang->line('application_deposit_amount');
        $this->view_data['materials'] = $materials;
        $this->content_view = 'materialhandling/_depositamount';
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
            $this->view_data['form_action'] = 'materialmanagement/entrance_create/' . $deposit_id;
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

            $entrance->deposit_id = $deposit_id;
            $entrance->material_id = $material_id;
            $entrance->date = $date;

            if($entrance->quantity > $quantity){
                $deposit_amount->quantity -= ($entrance->quantity - $quantity);
            }
            elseif($entrance->quantity < $quantity){
                $deposit_amount->quantity += ($quantity - $entrance->quantity);
            }

            $deposit_amount->save();

            $entrance->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_entrance_success'));
            
            $this->rule_check();
            
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

            $this->rule_check();

            redirect('materialmanagement/index');
        }
        else{
            
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_output');
            if($deposit_id){
                $this->view_data['deposit_id'] = $deposit_id;
                $this->view_data['materials'] = DepositAmount::find_by_sql("SELECT material_id AS 'id', material.description FROM deposit_amount INNER JOIN material on material.id = deposit_amount.material_id WHERE deposit_id = ? AND quantity > 0 ORDER BY material.id ASC", [$deposit_id]);
            }
            else{
                $deposits = DepositAmount::find_by_sql("SELECT DISTINCT deposit_amount.deposit_id, deposit.name FROM deposit_amount INNER JOIN deposit on deposit.id = deposit_amount.deposit_id WHERE quantity > 0 ORDER BY deposit.id ASC");
                $materials = DepositAmount::find_by_sql("SELECT DISTINCT material_id AS 'id', description FROM deposit_amount INNER JOIN material on material.id = deposit_amount.material_id WHERE quantity > 0 ORDER BY material.id ASC");
                $this->view_data['deposits'] = $deposits;
                $this->view_data['materials'] = $materials;
            }

            $this->view_data['form_action'] = 'materialmanagement/output_create/' . $deposit_id;
            $this->content_view = 'materialhandling/_outputform';
        }
    }

    public function output_update($output_id = false){

        if($_POST){

            $deposit_id = $_POST['deposit_id'];
            $material_id = $_POST['material_id'];
            $quantity = $_POST['quantity'];
            
            $date = $_POST['date'];

            $output = MaterialHandling::first(['conditions' => ["id = ?", $_POST['id']]]);
            $deposit_amount = DepositAmount::first(['conditions' => ["deposit_id = ? AND material_id = ?", $output->deposit_id, $output->material_id]]);

            if($deposit_amount->material_id != $material_id){
                
                $deposit_amount->quantity += $output->quantity;
                $deposit_amount->save();
                
                $deposit_amount = DepositAmount::first(['conditions' => ["deposit_id = ? AND material_id = ?", $deposit_id, $material_id]]);

                if($output->quantity > $quantity && $deposit_amount->quantity > $quantity){
                
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
                else{
                    if($deposit_amount->quantity >= $quantity){
                        
                        $deposit_amount->quantity -= $quantity;
                    }
                    else{
                        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_output_error'));
                        redirect('materialmanagement/index');
                    }
                }
    
                $deposit_amount->save();
            }
            else{

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
            }

            $output->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_output_success'));

            $this->rule_check();
            
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

    public function rules(){

        // $this->view_data['breadcrumb'] = $this->lang->line('application_dynamic_alarms');
        // $this->view_data['breadcrumb_id'] = 'parameterization/dynamic_alarms';

        $rules = Rule::find('all', ['conditions' => ['status != ? AND user_id = ?', 'deleted', $this->user->id]]);

        $material_rules = [];
        $stock_area_rules = [];
        
        foreach($rules as $rule){
            
            $rule->rule = json_decode($rule->rule);

            if($rule->rule->{'operator'} == '<'){
                $rule->rule->{'operator'} = $this->lang->line('application_less_than');
            }
            elseif($rule->rule->{'operator'} == '>'){
                $rule->rule->{'operator'} = $this->lang->line('application_greater_than');
            }
            elseif($rule->rule->{'operator'} == "="){
                $rule->rule->{'operator'} = $this->lang->line('application_equals');
            }

            $rule->rule->{'deposit_id'} = Deposit::first('all', ['conditions' => ["deposit.id = ?", $rule->rule->{'deposit_id'}]])->name;
            
            if($rule->rule->{'material_id'}){
                $rule->rule->{'material_id'} = Material::first('all', ['conditions' => ["material.id = ?", $rule->rule->{'material_id'}]])->description;
            }

            if($rule->rule->{'stock_area_id'}){
                $rule->rule->{'stock_area_id'} = StockArea::first('all', ['conditions' => ["stock_area.id = ?", $rule->rule->{'stock_area_id'}]])->name;
            }

            if($rule->type == $this->lang->line("application_material")){
                array_push($material_rules, $rule);
            }

            if($rule->type == $this->lang->line("application_stock_area")){
                array_push($stock_area_rules, $rule);
            }
        }

        $this->view_data['material_rules'] = $material_rules;
        $this->view_data['stock_area_rules'] = $stock_area_rules;
        $this->content_view = 'materialhandling/rules';
    }

    public function rule_message($deposit_id, $material_id = false, $stock_area_id = false, $operator, $value){

        $message = "";
        $operator_text = "";

        $deposit = Deposit::first('all', ['conditions' => ['id = ?', $deposit_id]]);
        
        if($operator == '<'){
            $operator_text = $this->lang->line('application_less_than');
        }
        elseif($operator == '>'){
            $operator_text = $this->lang->line('application_greater_than');
        }
        elseif($operator == '='){
            $operator_text = $this->lang->line('application_equals');
        }
        
        if($material_id){
            
            $material = Material::first('all', ['conditions' => ['id = ?', $material_id]]);
            $message = $material->description . " com quantidade " . $operator_text . " " . $value . " em ". $deposit->name;
        }
        elseif($stock_area_id){
            $stock_area = StockArea::first('all', ['conditions' => ['id = ?', $stock_area_id]]);
            $message = $stock_area->name . " com quantidade de material " . $operator_text . " " . $value . " em ". $deposit->name;
        }

        return $message;
    }

    public function material_rule_create(){

        if($_POST){

            $deposit_id = $_POST['deposit_id'];
            $material_id = $_POST['material_id'];
            $operator = $_POST['operator'];
            $value = $_POST['value'];

            $rule = new Rule();

            $rule->user_id = $this->user->id;
            
            $rule->type = $this->lang->line('application_material');

            $rule->send = '1';

            $rule->message = $this->rule_message($deposit_id, $material_id, null, $operator, $value);

            $rule->rule = json_encode(['deposit_id' => $deposit_id, 'material_id' => $material_id, 'operator' => $operator, 'value' => $value]);
            $rule->save();

            if ($rule) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_rule_success'));
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_rule_error'));
            }

            redirect('materialmanagement/rules');
        }
        else{
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_material_rule');
            $this->view_data['deposits'] = Deposit::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['materials'] = Material::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['form_action'] = 'materialmanagement/material_rule_create';
            $this->content_view = 'materialhandling/_materialruleform';
        }
    }

    public function material_rule_update($rule_id = false){

        $rule = Rule::first('all', ['conditions' => ['id = ?', $rule_id]]);

        $rule->rule = json_decode($rule->rule);

        if($_POST){
            
            $rule->rule->{'deposit_id'} = $_POST['deposit_id'];
            $rule->rule->{'material_id'} = $_POST['material_id'];
            $rule->rule->{'operator'} = $_POST['operator'];
            $rule->rule->{'value'} = $_POST['value'];

            $rule->message = $this->rule_message($_POST['deposit_id'], $_POST['material_id'], null, $_POST['operator'], $_POST['value']);
            
            $rule->rule = json_encode($rule->rule);
            $rule->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_rule_success'));
            redirect('materialmanagement/rules');
        }
        else{

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_material_rule');
            $this->view_data['rule'] = $rule;
            $this->view_data['deposits'] = Deposit::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['materials'] = Material::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['form_action'] = 'materialmanagement/material_rule_update/' . $rule->id;
            $this->content_view = 'materialhandling/_materialruleform';
        }
    }

    public function stock_area_rule_create(){
        
        if($_POST){

            $deposit_id = $_POST['deposit_id'];
            $stock_area_id = $_POST['stock_area_id'];
            $operator = $_POST['operator'];
            $value = $_POST['value'];

            $rule = new Rule();

            $rule->user_id = $this->user->id;

            $rule->type = $this->lang->line('application_stock_area');

            $rule->send = '1';

            $rule->message = $this->rule_message($deposit_id, null, $stock_area_id, $operator, $value);

            $rule->rule = json_encode(['deposit_id' => $deposit_id, 'stock_area_id' => $stock_area_id, 'operator' => $operator, 'value' => $value]);
            $rule->save();

            if ($rule) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_rule_success'));
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_rule_error'));
            }

            redirect('materialmanagement/rules');
        }
        else{
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_stock_area_rule');
            $this->view_data['deposits'] = Deposit::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['materials'] = Material::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['stock_areas'] = StockArea::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['form_action'] = 'materialmanagement/stock_area_rule_create';
            $this->content_view = 'materialhandling/_stockarearuleform';
        }
    }
    
    public function stock_area_rule_update($rule_id = false){

        $rule = Rule::first('all', ['conditions' => ['id = ?', $rule_id]]);

        $rule->rule = json_decode($rule->rule);

        if($_POST){
            
            $rule->rule->{'deposit_id'} = $_POST['deposit_id'];
            $rule->rule->{'stock_area_id'} = $_POST['stock_area_id'];
            $rule->rule->{'operator'} = $_POST['operator'];
            $rule->rule->{'value'} = $_POST['value'];

            $rule->message = $this->rule_message($_POST['deposit_id'], null, $_POST['stock_area_id'], $_POST['operator'], $_POST['value']);
            
            $rule->rule = json_encode($rule->rule);
            $rule->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_rule_success'));
            redirect('materialmanagement/rules');
        }
        else{

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_material_rule');
            $this->view_data['rule'] = $rule;
            $this->view_data['deposits'] = Deposit::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['stock_areas'] = StockArea::find('all', ['conditions' => ["status != ? ORDER BY id ASC", "deleted"]]);
            $this->view_data['form_action'] = 'materialmanagement/stock_area_rule_update/' . $rule->id;
            $this->content_view = 'materialhandling/_stockarearuleform';
        }
    }

    public function rule_delete($rule_id = false){

        $rule = Rule::first('all', ['conditions' => ['id = ?', $rule_id]]);

        if($rule){

            $rule->status = 'deleted';
            $rule->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_rule_success'));
        }
        else{
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_rule_error'));
        }

        redirect('materialmanagement/rules');
    }

    public function rule_check(){

        $push_receivers = [];

        $rules = Rule::find('all', ['conditions' => ['status != ?', 'deleted']]);

        foreach($rules as $rule){

            $rule->rule = json_decode($rule->rule);

            $user = User::first(['conditions' => ['id = ? AND status = ?', $rule->user_id, 'active']]);
            
            $deposit_id = $rule->rule->{'deposit_id'};
            $operator = $rule->rule->{'operator'};
            $value = $rule->rule->{'value'};

            if($rule->type == $this->lang->line('application_material')){

                $material_id = $rule->rule->{'material_id'};
                
                $sql = "SELECT material.description FROM deposit_amount INNER JOIN material on material.id = deposit_amount.material_id WHERE deposit_id = " . $deposit_id . " AND material_id = " . $material_id . " AND quantity " . $operator . " " . $value;
                
                $result = DepositAmount::find_by_sql($sql);

                if($result && ($user->push_active == 1)){

                    if($rule->send){
                        
                        array_push($push_receivers, $user->email);
    
                        Notification::sendPushNotification($push_receivers, '[Aviso] - ' . $rule->message, base_url());

                        $attributes = array('user_id' => $user->id, 'message' => '<b>[Aviso]</b> - '.$rule->message, 'url' => base_url().'/materialmanagement');
                        Notification::create($attributes);

                        $rule->send = 0;
                    }
                }
                else{
                    $rule->send = 1;
                }
            }
            elseif($rule->type == $this->lang->line('application_stock_area')){

                $stock_area_id = $rule->rule->{'stock_area_id'};

                $sql = "SELECT IF(SUM(deposit_amount.quantity) " . $operator . " " . $value . ", true, false) as 'total' FROM deposit_amount INNER JOIN material on material.id = deposit_amount.material_id INNER JOIN material_type on material_type.id = material.material_type_id INNER JOIN stock_area on stock_area.id = material_type.stock_area_id INNER JOIN deposit on deposit.id = deposit_amount.deposit_id WHERE deposit.id = " . $deposit_id . " AND stock_area.id = " . $stock_area_id;

                $result = DepositAmount::find_by_sql($sql);

                if($result[0]->total && ($user->push_active == 1)){

                    if($rule->send){
                        
                        array_push($push_receivers, $user->email);
    
                        Notification::sendPushNotification($push_receivers, '[Aviso] - ' . $rule->message, base_url());

                        $attributes = array('user_id' => $user->id, 'message' => '<b>[Aviso]</b> - '.$rule->message, 'url' => base_url().'/materialmanagement');
                        Notification::create($attributes);

                        $rule->send = 0;
                    }
                }
                else{
                    $rule->send = 1;
                }
            }

            $rule->rule = json_encode($rule->rule);
            $rule->save();
        }
    }
    // refatorar a partir daqui
    public function deposits(){
        // $this->view_data['breadcrumb'] = $this->lang->line('application_deposits');
        // $this->view_data['breadcrumb_id'] = 'parameterization/deposits';

        $deposits = Deposit::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['deposits'] = $deposits;
        $this->content_view = 'materialhandling/deposits';
    }

    public function deposit_update($deposit = false){
        $deposit = Deposit::find($deposit);

        if ($_POST) {

            $deposit->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_deposit_success'));
            redirect('materialmanagement/deposits');
        } else {
            $this->view_data['deposit'] = $deposit;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_edit_deposit');
            $this->view_data['form_action'] = 'materialmanagement/deposit_update/' . $deposit->id;
            $this->content_view = 'materialhandling/_depositform';
        }
    }

    public function deposit_create(){

        if ($_POST) {

            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $deposit_exists = Deposit::find($options);
            if (empty($deposit_exists)) {
                $deposit = Deposit::create($_POST);
                if (!$deposit) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_deposit_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_deposit_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_deposit_exists'));
            }
            redirect('materialmanagement/deposits');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_deposit');
            $this->view_data['form_action'] = 'materialmanagement/deposit_create/';
            $this->content_view = 'materialhandling/_depositform';
        }
    }

    public function deposit_delete($deposit = false){

        if ($this->deposit->id != $deposit) {
            $options = ['conditions' => ['id = ?', $deposit]];
            $deposit = Deposit::find($options);
            $stock_areas = DepositStockArea::find('all', ['conditions' => ['deposit_id = ?', $deposit->id]]);
            if(!$stock_areas){

                $deposit->status = 'deleted';
                $deposit->save();
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_deposit_success'));
            }
            else{
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_deposit_error'));
            }
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_deposit_error'));
        }
        redirect('materialmanagement/deposits');
    }

    public function stock_areas(){

        $this->view_data['breadcrumb'] = $this->lang->line('application_stock_areas');
        $this->view_data['breadcrumb_id'] = 'parameterization/stock_areas';

        $stock_areas = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['stock_areas'] = $stock_areas;
        $this->content_view = 'materialhandling/stock_areas';
    }

    public function stock_area_update($stock_area = false){

        $stock_area = StockArea::find($stock_area);

        if ($_POST) {

            $stock_area->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_stock_area_success'));
            redirect('materialmanagement/stock_areas');
        } else {
            $this->view_data['stock_area'] = $stock_area;
            $this->theme_view = 'modal';

            $stock_areas = StockArea::all();
            $this->view_data['bd_stock_areas'] = $stock_areas;


            $this->view_data['title'] = $this->lang->line('application_edit_stock_area');
            $this->view_data['form_action'] = 'materialmanagement/stock_area_update/' . $stock_area->id;
            $this->content_view = 'materialhandling/_stockareaform';
        }
    }

    public function stock_area_create(){
        
        if ($_POST) {

            $stock_area = StockArea::create($_POST);
            if (!$stock_area) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_stock_area_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_stock_area_success'));
            }
            redirect('materialmanagement/stock_areas');
        } else {
            $this->theme_view = 'modal';

            $stock_areas = StockArea::all();
            $this->view_data['bd_stock_areas'] = $stock_areas;

            $this->view_data['title'] = $this->lang->line('application_add_stock_area');
            $this->view_data['form_action'] = 'materialmanagement/stock_area_create/';
            $this->content_view = 'materialhandling/_stockareaform';
        }
    }

    public function stock_area_delete($stock_area = false){

        $options = ['conditions' => ['id = ?', $stock_area]];
        $stock_area = StockArea::find($options);
        
        $material_types = MaterialType::find('all', ['conditions' => ['stock_area_id = ?', $stock_area->id]]);
        $deposits = DepositStockArea::find('all', ['conditions' => ['stock_area_id = ?', $stock_area->id]]);
        
        if(!$material_types && !$deposits){
            $stock_area->status = 'deleted';
            $stock_area->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_stock_area_success'));
        }
        else{
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_stock_area_error'));
        }

        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_stock_area_error'));
        redirect('materialmanagement/stock_areas');
    }

    public function materials(){

        $this->view_data['breadcrumb'] = $this->lang->line('application_materials');
        $this->view_data['breadcrumb_id'] = 'parameterization/materials';
        
        $materials = Material::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['materials'] = $materials;
        $this->content_view = 'materialhandling/materials';
    }
    
    public function material_update($material = false){

        $material = Material::find($material);
        
        if ($_POST) {
            
            $material->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_material_success'));
            redirect('materialmanagement/materials');
        } else {
            $this->view_data['material'] = $material;
            $this->theme_view = 'modal';
            $this->view_data['material_types'] = MaterialType::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['title'] = $this->lang->line('application_edit_material');
            $this->view_data['form_action'] = 'materialmanagement/material_update/' . $material->id;
            $this->content_view = 'materialhandling/_materialform';
        }
    }
    
    public function material_create(){

        if ($_POST) {

            $options = ['conditions' => ['description = ?', $_POST['description']]];
            $material_exists = Material::find($options);
            if (empty($material_exists)) {
                $material = Material::create($_POST);
                if (!$material) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_material_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_material_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_material_exists'));
            }
            redirect('materialmanagement/materials');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_material');
            $this->view_data['material_types'] = MaterialType::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['form_action'] = 'materialmanagement/material_create/';
            $this->content_view = 'materialhandling/_materialform';
        }
    }
    
    public function material_delete($material = false){

        if ($this->material->id != $material) {
            $options = ['conditions' => ['id = ?', $material]];
            $material = Material::find($options);
            $material->status = 'deleted';
            $material->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_material_success'));
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_material_error'));
        }
        redirect('materialmanagement/materials');
    }

    public function deposit_stock_areas(){

        $this->view_data['breadcrumb'] = $this->lang->line('application_deposit_stock_areas');
        $this->view_data['breadcrumb_id'] = 'parameterization/deposit_stock_areas';
        
        $deposit_stock_areas = DepositStockArea::find('all', ['conditions' => ['status != ?', "deleted"], 'include' => ['deposit', 'stock_area']]);
        $deposits = Deposit::find('all');

        $this->view_data['deposit_stock_areas'] = $deposit_stock_areas;
        $this->content_view = 'materialhandling/deposit_stock_areas';
    }

    public function deposit_stock_area_update($deposit_id = false, $stock_area_id = false){
        
        if ($_POST) {
            
            $options = ['conditions' => ['deposit_id = ? AND stock_area_id = ?', $_POST['deposit_id'], $_POST['stock_area_id']]];
            $deposit_stock_area = DepositStockArea::first($options);
            $deposit_stock_area->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_deposit_stock_area_success'));
            redirect('materialmanagement/deposit_stock_areas');
        } else {
            $options = ['conditions' => ['deposit_id = ? AND stock_area_id = ?', $deposit_id, $stock_area_id]];
            $deposit_stock_area = DepositStockArea::first($options);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_deposit_stock_area');
            $this->view_data['deposit_stock_area'] = $deposit_stock_area;
            $this->view_data['deposits'] = Deposit::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['stock_areas'] = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['form_action'] = 'materialmanagement/deposit_stock_area_update/' . $deposit_stock_area->deposit_id;
            $this->content_view = 'materialhandling/_depositstockareaform';
        }
    }
    
    public function deposit_stock_area_create(){
        
        if ($_POST) {

            $options = ['conditions' => ['deposit_id = ? AND stock_area_id = ?', $_POST['deposit_id'], $_POST['stock_area_id']]];
            $deposit_stock_area_exists = DepositStockArea::find($options);
            if (empty($deposit_stock_area_exists)) {
                $deposit_stock_area = DepositStockArea::create($_POST);
                if (!$deposit_stock_area) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_deposit_stock_area_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_deposit_stock_area_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_deposit_stock_area_exists'));
            }
            redirect('materialmanagement/deposit_stock_areas');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_deposit_stock_area');
            $this->view_data['deposits'] = Deposit::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['stock_areas'] = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['form_action'] = 'materialmanagement/deposit_stock_area_create/';
            $this->content_view = 'materialhandling/_depositstockareaform';
        }
    }

    public function deposit_stock_area_delete($deposit_stock_area = false){

        if ($this->deposit_stock_area->id != $deposit_stock_area) {
            $options = ['conditions' => ['id = ?', $deposit_stock_area]];
            $deposit_stock_area = DepositStockArea::find($options);

            $deposit_stock_area->status = 'deleted';
            $deposit_stock_area->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_deposit_stock_area_success'));

        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_deposit_stock_area_error'));
        }
        redirect('materialmanagement/deposit_stock_areas');
    }

    public function material_types(){

        $this->view_data['breadcrumb'] = $this->lang->line('application_material_types');
        $this->view_data['breadcrumb_id'] = 'parameterization/material_types';

        $material_types = MaterialType::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['material_types'] = $material_types;
        $this->content_view = 'materialhandling/material_types';
    }

    public function material_type_update($material_type = false){

        $options = ['conditions' => ['id = ?', $material_type]];
        $material_type = MaterialType::find($options);
        
        if ($_POST) {
            
            $material_type->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_material_type_success'));
            redirect('materialmanagement/material_types');
        } else {
            $this->view_data['material_type'] = $material_type;
            $this->theme_view = 'modal';
            $this->view_data['stock_areas'] = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['title'] = $this->lang->line('application_edit_material_type');
            $this->view_data['form_action'] = 'materialmanagement/material_type_update/' . $material_type->id;
            $this->content_view = 'materialhandling/_materialtypeform';
        }
    }

    public function material_type_create(){

        if ($_POST) {

            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $material_type_exists = MaterialType::find($options);
            if (empty($material_type_exists)) {
                $material_type = MaterialType::create($_POST);
                if (!$material_type) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_material_type_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_material_type_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_material_type_exists'));
            }
            redirect('materialmanagement/material_types');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_material_type');
            $this->view_data['stock_areas'] = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['form_action'] = 'materialmanagement/material_type_create/';
            $this->content_view = 'materialhandling/_materialtypeform';
        }
    }

    public function material_type_delete($material_type = false){

        $options = ['conditions' => ['id = ?', $material_type]];
        $material_type = MaterialType::find($options);
        
        $materials = Material::find('all', ['conditions' => ['material_type_id = ?', $material_type->id]]);
        
        if(!$materials){
            $material_type->status = 'deleted';
            $material_type->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_material_type_success'));
        }
        else{
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_material_type_error'));
        }

        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_material_type_error'));
        redirect('materialmanagement/material_types');
    }
}