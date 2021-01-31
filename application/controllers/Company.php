<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Company extends CI_Controller
{
    public function index()
    {
        $this->load->model('company_model');
        $data['users'] = $this->company_model->retrieve();
        $this->load->view('company', $data);
    }
    
    public function insert()
    {
        $formdata['company'] = $this->input->post('company');
        $formdata['email'] = $this->input->post('email');

        $db_check_user = $this->db->get_where("companies", array("company" => $formdata['company']));
        $db_check_email = $this->db->get_where("companies", array("email" => $formdata['email']));

        if ($db_check_user->num_rows() && $db_check_email->num_rows()) {
            $this->session->set_flashdata('error', 'Company & Email already exists!');
            redirect('company');
        } elseif ($db_check_user->num_rows()) {
            $this->session->set_flashdata('error', 'Company already exists!');
            redirect('company');
        } elseif ($db_check_email->num_rows()) {
            $this->session->set_flashdata('error', 'Email already exists!');
            redirect('company');
        } else {
            $this->load->model('company_model');
            $this->company_model->insert($formdata);
            redirect('company');
        }
    }

    public function edit($userId)
    {
        $this->load->model('company_model');
        $data['user'] = $this->company_model->getUser($userId);
        $this->load->view('company_edit', $data);
    }

    public function update($userId)
    {
        $this->load->model('company_model');
        $formdata['company'] = $this->input->post('company');
        $formdata['email'] = $this->input->post('email');
        $data['user'] = $this->company_model->update($userId, $formdata);
        $this->session->set_flashdata('success', 'Data Updated successfully!');
        redirect('company');
    }

    public function delete($userId)
    {
        $this->load->model('company_model');
        $this->company_model->delete($userId);
        $this->session->set_flashdata('delete', 'Data Deleted successfully!');
        redirect('company');
    }
}
