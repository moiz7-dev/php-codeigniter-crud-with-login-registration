<?php
    class Company_model extends CI_Model{

        public function insert($formdata){
            $this->db->insert('companies', $formdata);       //inserts data to table
            $this->session->set_flashdata('success', 'Data added successfully!');
        }

        public function retrieve(){
            return $this->db->get('companies')->result_array();
        }

        public function getUser($userId){
            $this->db->where('id', $userId);
            return $this->db->get('companies')->row_array();
        }

        public function update($userId, $formdata)
        {
            $this->db->where('id', $userId);
            $this->db->update('companies', $formdata);
        }

        public function delete($userId)
        {
            $this->db->where('id', $userId);
            $this->db->delete('companies');
        }
    }
?>