<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class raw_material extends  User_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('report_model');
       
       

    }

    function _remap( $method )
    {
if($this->session->userdata('sess_category'))
   {
     $session_data = $this->session->userdata('sess_category');
     if($session_data['user_category']!='super')
      $method="";
   }
        // $method contains the second segment of your URI
        switch( $method )
        {
            case 'index':
                $this->index();
                break;

				
			case 'report':
                $this->report();
                break;
			case 'reportdata':
                $this->reportdata();
                break;
			
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Raw Material Report';
     
		
		$data['table']='';
        $this->template->write_view('content','report/raw_material_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

	  
	

    }

	
	public function reportdata()
   {
      
       $data1=$this->report_model->totalstock()->result();
   
       
       
      

       $this->load->library('table');
       $tmpl = array ( 'table_open'  => '<table class="">' );
       $this->table->set_template($tmpl);
       $this->table->set_empty("&nbsp;");
	   
	   $j=0;
	  
	   for($k=0;$k<ceil (count($data1)/25);$k++)
	   {
	   echo  $data["div"]=  '<div style="page-break-after: always; ">';
	   echo  $data["div"]=  '<div style="height:100px;dispaly:bolck;"></div>';
	   echo $data['message'] = '<p class="title">Raw Material Report</p>';
       $this->table->set_heading('No','Category','Type', 'Amount');
       
        
       for (;$j<count($data1);){
	       
           $this->table->add_row($j,$data1[$j]->catagory,$data1[$j]->type,$data1[$j]->amount);
		   ++$j;
		   if($j%25==0)
             {
			   
                break;
       		
             }
			
       }
	   $data['table'] = $this->table->generate(); 
     
       echo $data['table']; 
	   echo $data["div"]= '</div>';

	   } 
       

   }	
   
   
}
	?>
