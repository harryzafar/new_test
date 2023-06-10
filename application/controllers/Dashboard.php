<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Dashboard extends CI_Controller{

    public function __construct(){
        parent::__construct();
        if(!$this->session->userdata('user')){
            $this->session->set_flashdata('loginError', "Please Login First");
            redirect(base_url());
        }
       
        
    }


    public function index(){
        $data['userId'] = $this->session->userdata('user'); //userId
        $this->load->Model('Authentication'); //load model
        $user_details['user'] = $this->Authentication->get_user_detail($data); //fetch User detail for showing dashboard
        
        $this->load->view('dashboard',$user_details );
    }


    public function import(){

        $this->load->model('Import_model');  //load model for import


        $config['upload_path']   = './public/uploads/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size']      = 2048;

        $this->load->library('upload', $config); //load upload library

        if (!$this->upload->do_upload('sheet')) {
            $error = $this->upload->display_errors();
            echo $error;
        } else {
            echo "uploaded Successfully";
            $file_data = $this->upload->data();
            $file_path = './public/uploads/' . $file_data['file_name'];

            // insert into database
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_path);
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($file_path);
            $sheet = $spreadsheet->getSheet(0);

            $count_Rows = 0;
            foreach($sheet->getRowIterator() as $row){
                $username = $spreadsheet->getActiveSheet()->getCell('A'.$row->getRowIndex());
                $email = $spreadsheet->getActiveSheet()->getCell('B'.$row->getRowIndex());
                $description = $spreadsheet->getActiveSheet()->getCell('C'.$row->getRowIndex());
                 $data = [
                    'username'=>$username,
                    'email'=> $email,
                    'description'=>$description
                 ];

                 $this->db->insert('datasheet',$data);
                 $count_Rows++;
            }
            echo "inserted";

        }
    
       
    }

    public function show_table(){
        $all_rows = $this->db->get('datasheet');

       

        $draw = intval($this->input->post('draw'));

        $start = intval($this->input->post('start'));   //for pagination
        $length = intval($this->input->post('length'));

        $this->db->limit($length, $start); //query for pagination limit

        // for search query
        $valid_column =[
            0=>'username',
            1=>'email',
            2=>'description'
        ];
        $search = $this->input->post('search');
        $search_value = $search['value'];
        if(!empty($search_value)){
            $x = 0;
            foreach($valid_column as $sterm){
                if($x == 0){
                    $this->db->like($sterm, $search_value);
                }else{
                    $this->db->or_like($sterm, $search_value);
                }
                $x++;
            }
            
        }


        if($all_rows->num_rows() > 0){
            foreach($all_rows->result() as $row){
                $data[] = array(
                $row->id,
                $row->username,
                $row->email,
                $row->description 
                );

            }
            $total_records = $this->db->count_all_results('datasheet');
            $response = [
                'draw' => $draw,
                'recordsTotal' => $total_records,
                'recordsFiltered'=>$total_records,
                'data'=>$data
            ];
            
            echo json_encode($response);
        }
        else{
            $response = [];
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aData'] = [];
            echo json_encode($response); 
        }
        

    }



}

