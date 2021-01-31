<?php
class Profile_model extends CI_Model
{

    public function getUser($userId)        //retrieve user profile data
    {
        $this->db->where('sno', $userId);
        return $this->db->get('users')->row_array();
    }

    public function update($userId, $formdata)      //updates user profile data
    {
        $this->db->where('sno', $userId);
        $this->db->update('users', $formdata);
    }

    public function password_update($userId, $formdata)        //updates user Password
    {
        $this->db->where('sno', $userId);
        $this->db->update('users', $formdata);
    }
}
