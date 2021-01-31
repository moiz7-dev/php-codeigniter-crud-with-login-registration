<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{
    // public $data = '';
    public function index()
    {
            $this->load->model('employee_model');
            $data['users'] = $this->employee_model->retrieve();          //employee details
            $this->load->model('company_model');
            $data['company'] = $this->company_model->retrieve();    //company details
            $this->load->view('employee', $data);

        }

        // public function foo(){
        //     $asd = 'this is index function';
        //     $this->data = $asd;
        //     // $data['users'] = $this->employee_model->retrieve();          //employee details
        //     // $this->load->model('company_model');
        //     // $data['company'] = $this->company_model->retrieve();    //company details
        //     $this->load->view('employee');
        // }


        // public function test(){
        //     // $data['user'] = $this->$data;
        //     // $this->load->view('test', $data);
        //     echo ($this->data);
        //     $this->foo();

        //     echo "<br>";
        //     echo($this->data);
        // }
        
        public function insert()       
        {
            $formdata['name'] = $this->input->post('name');
            $formdata['email'] = $this->input->post('email');
            $formdata['company'] = $this->input->post('company');
            $formdata['gender'] = $this->input->post('gender');
                
            $db_check_user = $this->db->get_where("employees", array("name" => $formdata['name']));
            $db_check_email = $this->db->get_where("employees", array("email" => $formdata['email']));

            if ($db_check_user->num_rows() && $db_check_email->num_rows()) {
                $this->session->set_flashdata('error', 'Employee & Email already exists!');
                redirect('employee');
            } elseif ($db_check_user->num_rows()) {
                $this->session->set_flashdata('error', 'Employee already exists!');
                redirect('employee');
            } elseif ($db_check_email->num_rows()) {
                $this->session->set_flashdata('error', 'Email already exists!');
                redirect('employee');}
                else{
                    $this->load->model('employee_model');
                    $this->employee_model->insert($formdata);
                    redirect('employee');
                }
        }
        
        public function edit($userId)
        {
            $this->load->model('employee_model');
            $this->load->model('company_model');
            $data['user'] = $this->employee_model->getUser($userId);
            $data['company'] = $this->company_model->retrieve();  
            $this->load->view('employee_edit', $data);
        }
        
        public function update($userId)
        {
            $this->load->model('employee_model');
            $formdata['name'] = $this->input->post('name');
            $formdata['email'] = $this->input->post('email');
            $formdata['company'] = $this->input->post('company');
            $formdata['gender'] = $this->input->post('gender');
            $data['user'] = $this->employee_model->update($userId, $formdata);
            $this->session->set_flashdata('success', 'Data Updated successfully!');
            redirect('employee');
    }
    
    public function delete($userId)
    {
        $this->load->model('employee_model');
        $this->employee_model->delete($userId);
        $this->session->set_flashdata('delete', 'Data Deleted successfully!');
        redirect('employee');
    }
}
