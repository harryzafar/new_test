<?php

class Authentication extends CI_Model{

    public function login($data){
        $row = $this->db->get_where('users', array('email' => $data['email']))->row_array();
         $hass_pass = $row['password'];
         if(password_verify($data['password'], $hass_pass)){
           $userId = $row['id'];
           return $userId;
         }
         else{
            return false;
         }
         
    }

    public function get_user_detail($data){
      $row = $this->db->get_where('users', array('id'=> $data['userId']));
      if($row->num_rows() == 1){
        return $row->row_array() ;
      }
      else{
        return false;
      }
    }
}
?>