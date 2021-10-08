<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class bank  extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('database_model');
        $this->load->library('form_validation');
		
       

    }

    function _remap( $method )
    {

        // $method contains the second segment of your URI
        switch( $method )
        {
            case 'index':
                $this->index();
                break;


            case 'add':
                $this->add();
                break;
            case 'adddata':
                $this->adddata();
                break;

            case 'update':
                $this->update();
                break;

            case 'updatedata':
                $this->updatedata();
                break;
             case 'table':
                $this->table();
                break;

            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {
         
        $error = null;
        $title = 'Bank Information';
     
         
         $data['table'] =$this->tableganarate();
      
         $this->template->write_view('content','bankview',array('data'=>$data,'error'=>$error,'title'=>$title));
         $this->template->render(); 
	   
	  
		

    }

 function tableganarate()
 {       
        $banks = $this->database_model->bank()->result();
        $this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-bordered" style="width:200px;">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Bank Name','Branch','Account No','Balance',"Action","");
        $i = 0;
      
        foreach ($banks as $bank ){
            $this->table->add_row(++$i,$bank ->bank_name,$bank ->branchname,$bank ->account_name,number_format($bank ->amount,2),
             '<input type="hidden" value="'.$bank ->id.'" name="id"/> <a href="#" class="btn btn-small btn-warning">update </a>',
             anchor('bank_detail/index/'.$bank ->id,'Detail',array('class'=>'btn btn-small btn-info'))
 

            );
        }
        return $this->table->generate();
 
 }

 

    public function adddata()
    {
	
    	    $bank =  $this->input->post('bank');
			
           
			
			 
           $id = $this->database_model->save($bank,'bank_name');
			//print_r($bank);
           echo "Add Successfully"; 

      

    }

    public function update()
    {
        $id=$this->input->post('id');
        $bank = $this->database_model->get_by_id($id,'bank_name')->row();
            $bank = array('id' =>$bank->id,
		   'bank_name' =>$bank->bank_name,
		   'branchname' =>$bank->branchname,
		   'account_name'=>$bank->account_name
		   );
  	    print(json_encode($bank)) ; 
		
       

    }



    public function updatedata()
    {
	          $bank =  $this->input->post('bank');
			
		
            $this->database_model->updatedata($bank,'bank_name');
			 echo "Update Successfully"; 
    }

   

	


}