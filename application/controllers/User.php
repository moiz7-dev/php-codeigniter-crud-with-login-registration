<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function login()
    {
        if (!isset($_POST['submit'])) {
            $this->load->view('login');
            return;
        }
        
        if (!empty($_POST['name'] && $_POST['password'])) {     //if empty fields
            $uname = $_POST['name'];
            $password = $_POST['password'];
            $db_check = $this->db->get_where("users", array("user" => $uname));
            if ($db_check->num_rows()) {        //if user found
                $row = $db_check->row_array();

                if (password_verify($password, $row['password'])) {

                    $result = $db_check->result_array();
                    $session_data = [
                        'id' => $result[0]['sno'],
                        'user_name'  => $result[0]['user'],
                        'password'     => $result[0]['password'],
                        'profile_img' => $result[0]['profile_img'],
                    ];
                    $this->session->set_userdata($session_data);
                    redirect('dashboard');
                } else {

                    $this->session->set_flashdata('error', 'Password incorrect!');
                    redirect('user/login');
                };
            } else {

                $this->session->set_flashdata('error', 'Username incorrect!');
                redirect('user/login');
            }
        } else {

            $this->session->set_flashdata('error', 'Forgot to enter any fields!');
            redirect('user/login');
        }
    }
    
    public function register()
    {
        if (!isset($_POST['submit'])) {
            $this->load->view('register');
            return;
        }

        $config['upload_path'] = './profiles';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $this->load->library('upload', $config);
        
        if (!empty($_POST['uname'] && $_POST['password'] && $_POST['cpassword'])) {     //if fields are not empty
            if ($_POST['password'] == $_POST['cpassword']) {
                
                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');
                $uname = $this->input->post('uname');
                $email = $this->input->post('email');
                $encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $db_check_user = $this->db->get_where("users", array("user" => $uname));
                $db_check_email = $this->db->get_where("users", array("email" => $email));
                
                //if email & username already
                if ($db_check_user->num_rows() && $db_check_email->num_rows()) {
                    $this->session->set_flashdata('error', 'Username & Email already exists!');
                    redirect('user/register');
                } elseif ($db_check_user->num_rows()) {
                    $this->session->set_flashdata('error', 'Username already exists!');
                    redirect('user/register');
                } elseif ($db_check_email->num_rows()) {
                    $this->session->set_flashdata('error', 'Email already exists!');
                    redirect('user/register');
                } else {
                    $this->upload->do_upload('profile_pic');
                    $pic = array('upload_data' => $this->upload->data());
                    $file_url = '';
                    if (!$pic['upload_data']['file_name']) {        //if not uploaded
                        $file_url = 'profiles/Default.jpg';
                    } else {                                        //if uploaded
                        $file_url = 'profiles/' . $pic['upload_data']['file_name'];
                    }
                    $data = array(
                        'fname' => $fname,
                        'lname' => $lname,
                        'user' => $uname,
                        'email' => $email,
                        'password' => $encrypted_password,
                        'profile_img' => $file_url
                    );
                    
                    $this->db->insert('users', $data);
                    $this->session->set_flashdata('registered', 'Registered successfully!<br>Please login to continue.');
                    redirect('user/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Password does not match!');
                redirect('user/register');
            }
        } else {
            $this->session->set_flashdata('error', 'Forgot to enter any fields!');
            redirect('user/register');
        }
    }

    public function change_password()
    {
        if (!isset($_POST['submit'])) {
            $this->load->view('change_password');
            return;
        }

        $oldpassword = $this->input->post('oldpassword');
        $where = array('sno' => $_SESSION['id']);
        $old_pass_check = $this->db->where($where);
        $old_pass_check = $this->db->get('users'); 
        $row = $old_pass_check->row_array();
        
        if (!password_verify($oldpassword, $row['password'])) {     //if old password matches
            $this->session->set_flashdata('error', 'Current Password is invalid!');
            redirect('user/change_password');
        }
        
        elseif ($_POST['password'] != $_POST['cpassword']){         //on password & cpassword match fail
            $this->session->set_flashdata('error', 'Password does not match!');
            redirect('user/change_password');
        }
        
        else{                                                       //on success
            $this->load->model('profile_model');
            $encrypted_password = password_hash($_POST['password'], PASSWORD_DEFAULT); //encrypts new password
            $formdata['password'] = $encrypted_password;
            $data['user'] = $this->profile_model->password_update($_SESSION['id'], $formdata);
            $this->session->set_flashdata('success', 'Password Changed successfully!');
            redirect('user/profile');
        }
    }

    public function logout()
    {
        session_unset();
        redirect('user/login');
    }

    public function profile()
    {
        if(!isset($_POST['submit'])){
        $this->load->model('profile_model');
        $data['user'] = $this->profile_model->getUser($_SESSION['id']);
        $this->load->view('profile', $data);
        return;
        }

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
            redirect('user/profile');
        } elseif ($db_check_user->num_rows() && $old_user != $formdata['user']) {
            $this->session->set_flashdata('error', 'Username already exists!');
            redirect('user/profile');
        } elseif ($db_check_email->num_rows() && $old_email != $formdata['email']) {
            $this->session->set_flashdata('error', 'Email already exists!');
            redirect('user/profile');
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
