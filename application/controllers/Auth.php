<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->MODEL('Authentication');
        
    }

	
	public function index()
	{
		$this->load->view('login');
	}


	public function check_email($data){
        $result = $this->db->get_where('users', array('email' => $data));
        if($result->num_rows() == 1){
         return true;
        }else{
         return false;
        }
     }

	public function login(){
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if($this->form_validation->run()== true){
            $email = $this->input->post('email');
            if($this->check_email($email)){   //call check_mail function to check mail is valid or not
                $formdata = [
                    'email'=> $email,
                    'password' => $this->input->post('password')
                ];
                $userId = $this->Authentication->login($formdata);
                if($userId !== false){
                    $this->session->set_userdata('user', $userId);
                    redirect(base_url('dashboard'));
                }
                else{
                    $this->session->set_flashdata('loginError', 'Incorrect Email or Password');
                }
            }
            else{
                $this->session->set_flashdata('loginError', 'Invalid Email ID');
            }
        }


		$this->load->view('login');
	
	}

    public function logout(){
        $this->session->unset_userdata('user');
        redirect(base_url());
    }


}