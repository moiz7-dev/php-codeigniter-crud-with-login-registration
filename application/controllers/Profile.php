<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function index()
    {
        $this->load->model('profile_model');
        $data['user'] = $this->profile_model->getUser($_SESSION['id']);
        $this->load->view('profile', $data);
    }

    public function update_profile()
    {
        $this->load->model('profile_model');
        $formdata['user'] = $this->input->post('uname');
        $formdata['email'] = $this->input->post('email');
        $formdata['fname'] = $this->input->post('fname');
        $formdata['lname'] = $this->input->post('lname');

        //check email & username already exists
        $id = $_SESSION['id'];
        
        $query = $this->db->query("SELECT user FROM `users` WHERE sno=$id");
        $old_user = $query->result_array()[0]['user'];

        $query = $this->db->query("SELECT email FROM `users` WHERE sno=$id");
        $old_email = $query->result_array()[0]['email'];
        
        $db_check_user = $this->db->get_where("users", array("user" => $formdata['user']));
        $db_check_email = $this->db->get_where("users", array("email" => $formdata['email']));

        //if email & username already
        if ($db_check_user->num_rows() && $db_check_email->num_rows() && $old_user != $formdata['user'] && $old_email != $formdata['email']) {
            $this->session->set_flashdata('error', 'Username & Email already exists!');
            redirect('profile');
        } elseif ($db_check_user->num_rows() && $old_user != $formdata['user']) {
            $this->session->set_flashdata('error', 'Username already exists!');
            redirect('profile');
        } elseif ($db_check_email->num_rows() && $old_email != $formdata['email']) {
            $this->session->set_flashdata('error', 'Email already exists!');
            redirect('profile');
        } else {
            
            //image upload config
            $config['upload_path'] = './profiles';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $this->load->library('upload', $config);

            //image upload for change
            $this->upload->do_upload('profile_img');
            $pic = array('upload_data' => $this->upload->data());
            $file_url = '';
            if (!$pic['upload_data']['file_name']) {
                $file_url = ($_SESSION['profile_img']);
            } else {
                $file_url = 'profiles/' . $pic['upload_data']['file_name'];
            }

            $formdata['profile_img'] = $file_url;
            $data['user'] = $this->profile_model->update($_SESSION['id'], $formdata);
            
            //set profile in nav bar by updating session data
            $this->session->set_userdata('profile_img', $file_url);
            $this->session->set_userdata('user_name', $formdata['user']);
            
            $this->session->set_flashdata('success', 'Data Updated successfully!');
            redirect('dashboard');
        }
    }
}
