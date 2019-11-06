<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Parameterization extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        unset($_POST['DataTables_Table_0_length']);
        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'parameterization') {
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
            $this->lang->line('application_departments') => 'parameterization/departments',
            $this->lang->line('application_areas') => 'parameterization/areas',
            $this->lang->line('application_deposits') => 'parameterization/deposits',
            $this->lang->line('application_stock_areas') => 'parameterization/stock_areas',
            $this->lang->line('application_materials') => 'parameterization/materials',
            $this->lang->line('application_deposit_stock_areas') => 'parameterization/deposit_stock_areas'
        ];

        $this->view_data['iconlist'] = [
            'parameterization/departments' => 'dripicons-network-1',
            'parameterization/areas' => 'dripicons-network-3',
            'parameterization/deposits' => 'dripicons-store',
            'parameterization/stock_areas' => 'dripicons-view-thumb',
            'parameterization/materials' => 'dripicons-suitcase',
            'parameterization/deposit_stock_areas' => 'dripicons-view-list-large'
        ];

        $this->config->load('defaults');
    }
    
    public function index()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_parameterization');
        $this->view_data['breadcrumb_id'] = 'parameterization/departments';

        $this->view_data['departments'] = Department::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->content_view = 'parameterization/departments';

        $this->load->helper('curl');
    }

    public function departments()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_departments');
        $this->view_data['breadcrumb_id'] = 'parameterization/departments';
        
        $options = ['conditions' => ['status != ?', 'deleted']];
        $departments = Department::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['departments'] = $departments;
        $this->content_view = 'parameterization/departments';
    }
    
    public function department_update($department = false)
    {
        $department = Department::find($department);
        
        if ($_POST) {
            
            $department->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_department_success'));
            redirect('parameterization/departments');
        } else {
            $this->view_data['department'] = $department;
            $this->theme_view = 'modal';
            
            $this->view_data['title'] = $this->lang->line('application_edit_department');
            $this->view_data['form_action'] = 'parameterization/department_update/' . $department->id;
            $this->content_view = 'parameterization/_departmentform';
        }
    }
    
    public function department_create()
    {
        if ($_POST) {

            $options = ['conditions' => ['name = ?', $_POST['name']]];
            $department_exists = Department::find($options);
            if (empty($department_exists)) {
                $department = Department::create($_POST);
                if (!$department) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_department_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_department_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_department_exists'));
            }
            redirect('parameterization/departments');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_department');
            $this->view_data['form_action'] = 'parameterization/department_create/';
            $this->content_view = 'parameterization/_departmentform';
        }
    }
    
    public function department_delete($department = false)
    {

        if ($this->department->id != $department) {
            $options = ['conditions' => ['id = ?', $department]];
            $department = Department::find($options);
            $department->status = 'deleted';
            $department->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_department_success'));
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_department_error'));
        }
        redirect('parameterization/departments');
    }

    public function areas()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_areas');
        $this->view_data['breadcrumb_id'] = 'parameterization/areas';

        $options = array('conditions' => 'status != \'deleted\'', 'include' => array('department'));
        $areas = DepartmentArea::all($options);
        $this->view_data['areas'] = $areas;
        $this->content_view = 'parameterization/areas';
    }

    public function area_update($area = false)
    {
        $area = DepartmentArea::find($area);

        if ($_POST) {

            $area->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_area_success'));
            redirect('parameterization/areas');
        } else {
            $this->view_data['area'] = $area;
            $this->theme_view = 'modal';

            $options = ['conditions' => ['status != ?', 'deleted']];
            $departments = Department::all($options);
            $this->view_data['bd_departments'] = $departments;


            $this->view_data['title'] = $this->lang->line('application_edit_area');
            $this->view_data['form_action'] = 'parameterization/area_update/' . $area->id;
            $this->content_view = 'parameterization/_areaform';
        }
    }

    public function area_create()
    {
        if ($_POST) {

            $area = DepartmentArea::create($_POST);
            if (!$area) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_area_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_area_success'));
            }
            redirect('parameterization/areas');
        } else {
            $this->theme_view = 'modal';

            $options = ['conditions' => ['status != ?', 'deleted']];
            $departments = Department::all($options);
            $this->view_data['bd_departments'] = $departments;

            $this->view_data['title'] = $this->lang->line('application_add_area');
            $this->view_data['form_action'] = 'parameterization/area_create/';
            $this->content_view = 'parameterization/_areaform';
        }
    }

    public function area_delete($area = false)
    {

        if ($this->area->id != $area) {
            $options = ['conditions' => ['id = ?', $area]];
            $area = DepartmentArea::find($options);
            $area->status = 'deleted';
            $area->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_area_success'));
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_area_error'));
        }
        redirect('parameterization/areas');
    }

    public function deposits()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_deposits');
        $this->view_data['breadcrumb_id'] = 'parameterization/deposits';

        $deposits = Deposit::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['deposits'] = $deposits;
        $this->content_view = 'parameterization/deposits';
    }

    public function deposit_update($deposit = false)
    {
        $deposit = Deposit::find($deposit);

        if ($_POST) {

            $deposit->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_deposit_success'));
            redirect('parameterization/deposits');
        } else {
            $this->view_data['deposit'] = $deposit;
            $this->theme_view = 'modal';

            $this->view_data['title'] = $this->lang->line('application_edit_deposit');
            $this->view_data['form_action'] = 'parameterization/deposit_update/' . $deposit->id;
            $this->content_view = 'parameterization/_depositform';
        }
    }

    public function deposit_create()
    {
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
            redirect('parameterization/deposits');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_deposit');
            $this->view_data['form_action'] = 'parameterization/deposit_create/';
            $this->content_view = 'parameterization/_depositform';
        }
    }


    public function deposit_delete($deposit = false)
    {

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
        redirect('parameterization/deposits');
    }

    public function stock_areas()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_stock_areas');
        $this->view_data['breadcrumb_id'] = 'parameterization/stock_areas';

        $stock_areas = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['stock_areas'] = $stock_areas;
        $this->content_view = 'parameterization/stock_areas';
    }

    public function stock_area_update($stock_area = false)
    {
        $stock_area = StockArea::find($stock_area);

        if ($_POST) {

            $stock_area->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_stock_area_success'));
            redirect('parameterization/stock_areas');
        } else {
            $this->view_data['stock_area'] = $stock_area;
            $this->theme_view = 'modal';

            $stock_areas = StockArea::all();
            $this->view_data['bd_stock_areas'] = $stock_areas;


            $this->view_data['title'] = $this->lang->line('application_edit_stock_area');
            $this->view_data['form_action'] = 'parameterization/stock_area_update/' . $stock_area->id;
            $this->content_view = 'parameterization/_stockareaform';
        }
    }

    public function stock_area_create()
    {
        if ($_POST) {

            $stock_area = StockArea::create($_POST);
            if (!$stock_area) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_stock_area_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_stock_area_success'));
            }
            redirect('parameterization/stock_areas');
        } else {
            $this->theme_view = 'modal';

            $stock_areas = StockArea::all();
            $this->view_data['bd_stock_areas'] = $stock_areas;

            $this->view_data['title'] = $this->lang->line('application_add_stock_area');
            $this->view_data['form_action'] = 'parameterization/stock_area_create/';
            $this->content_view = 'parameterization/_stockareaform';
        }
    }

    public function stock_area_delete($stock_area = false)
    {

        $options = ['conditions' => ['id = ?', $stock_area]];
        $stock_area = StockArea::find($options);
        
        $materials = Material::find('all', ['conditions' => ['stock_area_id = ?', $stock_area->id]]);
        $deposits = DepositStockArea::find('all', ['conditions' => ['stock_area_id = ?', $stock_area->id]]);
        
        if(!$materials && !$deposits){
            $stock_area->status = 'deleted';
            $stock_area->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_stock_area_success'));
        }
        else{
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_stock_area_error'));
        }

        $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_stock_area_error'));
        redirect('parameterization/stock_areas');
    }

    public function materials()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_materials');
        $this->view_data['breadcrumb_id'] = 'parameterization/materials';
        
        $materials = Material::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
        $this->view_data['materials'] = $materials;
        $this->content_view = 'parameterization/materials';
    }
    
    public function material_update($material = false)
    {
        $material = Material::find($material);
        
        if ($_POST) {
            
            $material->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_material_success'));
            redirect('parameterization/materials');
        } else {
            $this->view_data['material'] = $material;
            $this->theme_view = 'modal';
            $this->view_data['stock_areas'] = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['title'] = $this->lang->line('application_edit_material');
            $this->view_data['form_action'] = 'parameterization/material_update/' . $material->id;
            $this->content_view = 'parameterization/_materialform';
        }
    }
    
    public function material_create()
    {
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
            redirect('parameterization/materials');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_material');
            $this->view_data['stock_areas'] = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['form_action'] = 'parameterization/material_create/';
            $this->content_view = 'parameterization/_materialform';
        }
    }
    
    public function material_delete($material = false)
    {

        if ($this->material->id != $material) {
            $options = ['conditions' => ['id = ?', $material]];
            $material = Material::find($options);
            $material->status = 'deleted';
            $material->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_material_success'));
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_material_error'));
        }
        redirect('parameterization/materials');
    }

    public function deposit_stock_areas()
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_deposit_stock_areas');
        $this->view_data['breadcrumb_id'] = 'parameterization/deposit_stock_areas';
        
        $deposit_stock_areas = DepositStockArea::find('all', ['conditions' => ['status != ?', "deleted"], 'include' => ['deposit', 'stock_area']]);
        $deposits = Deposit::find('all');

        $this->view_data['deposit_stock_areas'] = $deposit_stock_areas;
        $this->content_view = 'parameterization/deposit_stock_areas';
    }

    public function deposit_stock_area_update($deposit_id = false, $stock_area_id = false)
    {
        
        if ($_POST) {
            
            $options = ['conditions' => ['deposit_id = ? AND stock_area_id = ?', $_POST['deposit_id'], $_POST['stock_area_id']]];
            $deposit_stock_area = DepositStockArea::first($options);
            $deposit_stock_area->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_deposit_stock_area_success'));
            redirect('parameterization/deposit_stock_areas');
        } else {
            $options = ['conditions' => ['deposit_id = ? AND stock_area_id = ?', $deposit_id, $stock_area_id]];
            $deposit_stock_area = DepositStockArea::first($options);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_deposit_stock_area');
            $this->view_data['deposit_stock_area'] = $deposit_stock_area;
            $this->view_data['deposits'] = Deposit::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['stock_areas'] = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['form_action'] = 'parameterization/deposit_stock_area_update/' . $deposit_stock_area->deposit_id;
            $this->content_view = 'parameterization/_depositstockareaform';
        }
    }
    
    public function deposit_stock_area_create()
    {
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
            redirect('parameterization/deposit_stock_areas');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_deposit_stock_area');
            $this->view_data['deposits'] = Deposit::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['stock_areas'] = StockArea::find('all', array('conditions' => array("status != ? ORDER BY id ASC ", "deleted")));
            $this->view_data['form_action'] = 'parameterization/deposit_stock_area_create/';
            $this->content_view = 'parameterization/_depositstockareaform';
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
        redirect('parameterization/deposit_stock_areas');
    }
}
