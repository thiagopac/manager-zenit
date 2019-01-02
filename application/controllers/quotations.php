<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Quotations extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->input->cookie('language') != '') {
            $language = $this->input->cookie('fc2language');
        } else {
            $language = 'english';
        }
        $this->lang->load('quotation', $language);
        if ($this->client) {
            redirect('cprojects');
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'quotations') {
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
                        $this->lang->line('application_all') => 'quotations',
                        $this->lang->line('application_New') => 'quotations/filter/new',
                        $this->lang->line('application_Reviewed') => 'quotations/filter/reviewed',
                        $this->lang->line('application_Accepted') => 'quotations/filter/accepted'
                        ];
        $this->view_data['submenu2'] = [
                        $this->lang->line('application_all') => 'quotations',
                        $this->lang->line('application_New') => 'quotations/customfilter/new',
                        $this->lang->line('application_Reviewed') => 'quotations/customfilter/reviewed',
                        $this->lang->line('application_Accepted') => 'quotations/customfilter/accepted'
                        ];
    }

    public function index()
    {
        if ($this->user->admin == 0) {
            $this->view_data['quotations'] = $this->user->quotes;
            $this->view_data['custom_quotations'] = $this->user->quoterequests;
        } else {
            $this->view_data['quotations'] = Quote::all();
            $this->view_data['custom_quotations'] = Quoterequest::all();
        }

        $this->content_view = 'quotations/all';
    }

    public function filter($condition)
    {
        $this->view_data['custom_quotations'] = Quoterequest::all();
        switch ($condition) {
            case 'new':
                $this->view_data['quotations'] = Quote::find('all', ['conditions' => ['status = ?', 'New']]);
                break;
            case 'reviewed':
                $this->view_data['quotations'] = Quote::find('all', ['conditions' => ['status = ?', 'reviewed']]);
                break;
            case 'accepted':
                $this->view_data['quotations'] = Quote::find('all', ['conditions' => ['status = ?', 'accepted']]);
                break;
            default:
                $this->view_data['quotations'] = Quote::all();
                break;
        }

        $this->content_view = 'quotations/all';
    }

    public function customfilter($condition)
    {
        $this->view_data['quotations'] = Quote::all();
        switch ($condition) {
            case 'new':

                                $this->view_data['custom_quotations'] = Quoterequest::find('all', ['conditions' => ['status = ?', 'New']]);
                break;
            case 'reviewed':
                $this->view_data['custom_quotations'] = Quoterequest::find('all', ['conditions' => ['status = ?', 'reviewed']]);
                break;
            case 'accepted':
                $this->view_data['custom_quotations'] = Quoterequest::find('all', ['conditions' => ['status = ?', 'accepted']]);
                break;
            default:
                $this->view_data['custom_quotations'] = Quoterequest::all();
                break;
        }

        $this->content_view = 'quotations/all';
    }

    public function custom()
    {
        $this->view_data['quotations'] = Quoterequest::all();
        $this->content_view = 'quotations/custom_all';
    }

    public function quoteforms()
    {
        $this->view_data['quotations'] = Customquote::all();
        $this->content_view = 'quotations/customquote_form_all';
    }

    public function cview($id = false)
    {
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'quotations',
                        ];
        $this->view_data['quotation'] = Quoterequest::find($id);

        //$this->view_data['client'] = Company::find('all',array('conditions' => array('inactive=? AND name=?','0', $this->view_data['quotation']->company)));
        $this->content_view = 'quotations/custom_view';
    }

    public function view($id = false)
    {
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'quotations',
                        ];
        $this->view_data['quotation'] = Quote::find($id);
        $this->view_data['client'] = Company::find('all', ['conditions' => ['inactive=? AND name=?', '0', $this->view_data['quotation']->company]]);
        $this->content_view = 'quotations/view';
    }

    public function create_client($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $client = Company::create($_POST);
            $new_client_reference = $_POST['reference'] + 1;
            $client_reference = Setting::first();
            $client_reference->update_attributes(['company_reference' => $new_client_reference]);
            if (!$client) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_company_add_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_company_add_success'));
            }
            redirect('clients');
        } else {
            $this->view_data['client'] = Quote::find($id);
            $next_reference = Company::last();
            $reference = $next_reference->reference + 1;
            $this->view_data['client_reference'] = $reference;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_new_company');
            $this->view_data['form_action'] = 'quotations/create_client';
            $this->content_view = 'quotations/_clients';
        }
    }

    public function update($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST = array_map('addslashes', $_POST);

            $quotation = Quote::find($id);
            $quotation = $quotation->update_attributes($_POST);
            if (!$quotation) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_quotation_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_quotation_success'));
            }
            redirect('quotations/view/' . $id);
        } else {
            $this->view_data['quotations'] = Quote::find($id);
            $this->view_data['users'] = user::find('all', ['conditions' => ['status=?', 'active']]);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_quotation');
            $this->view_data['form_action'] = 'quotations/update/' . $id;
            $this->content_view = 'quotations/_quotations';
        }
    }

    public function formupdate($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $quotation = Customquote::find($id);
            $quotation = $quotation->update_attributes($_POST);
            if (!$quotation) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_quotation_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_quotation_success'));
            }
            redirect('quotations/quoteforms');
        } else {
            $this->view_data['quotation'] = Customquote::find($id);
            $this->view_data['users'] = user::find('all', ['conditions' => ['status=?', 'active']]);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_quotation');
            $this->view_data['form_action'] = 'quotations/formupdate/' . $id;
            $this->content_view = 'quotations/_formupdate';
        }
    }

    public function cupdate($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $quotation = Quoterequest::find_by_id($id);
            $quotation = $quotation->update_attributes($_POST);
            if (!$quotation) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_quotation_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_quotation_success'));
            }
            redirect('quotations/cview/' . $id);
        } else {
            $this->view_data['quotations'] = Quoterequest::find_by_id($id);
            $this->view_data['users'] = user::find('all', ['conditions' => ['status=?', 'active']]);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_quotation');
            $this->view_data['form_action'] = 'quotations/cupdate/' . $id;
            $this->content_view = 'quotations/_quotations';
        }
    }

    public function delete($id = false)
    {
        $quotation = Quote::find_by_id($id);
        $quotation->delete();
        if (!$quotation) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_quotation_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_quotation_success'));
        }
        redirect('quotations');
    }

    public function cdelete($id = false)
    {
        $quotation = Quoterequest::find_by_id($id);
        $quotation->delete();
        if (!$quotation) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_quotation_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_quotation_success'));
        }
        redirect('quotations');
    }

    public function formdelete($id = false)
    {
        $quotation = Customquote::find_by_id($id);
        $quotation->delete();
        if (!$quotation) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_quotation_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_quotation_success'));
        }
        redirect('quotations/quoteforms');
    }

    public function formbuilder($id = false)
    {
        if ($id != false) {
            $this->view_data['quotation'] = Customquote::find_by_id($id);
        }
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'quotations',
                        ];
        $this->content_view = 'quotations/formbuilder';
    }

    public function build($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);

            $_POST['user_id'] = $this->user->id;
            if ($id != false) {
                $quote = Customquote::find_by_id($id);
                $quote = $quote->update_attributes($_POST);
                if (!$quote) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_quotation_form_update_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_quotation_form_update_success'));
                }
            } else {
                $quote = Customquote::create($_POST);
                if (!$quote) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_quotation_form_add_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_quotation_form_add_success'));
                }
            }

            redirect('quotations/quoteforms');
        }
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'quotations',
                        ];
        $this->content_view = 'quotations/formbuilder';
    }
}
