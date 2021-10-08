<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class attendance_report extends  User_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('report_model');
        $this->load->model('database_model');
       

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


            case 'attendancelist':
                $this->attendancelist();
                break;
				
			case 'report':
                $this->report();
                break;
			case 'reportdata':
                $this->reportdata();
                break;
			case 'updatedata':
                $this->updatedata();
                break;
			case 'revenue':
                $this->revenue();
                break;
			case 'revenuelist':
                $this->revenuelist();
                break;
			case 'expense':
                $this->expense();
                break;
			case 'expenselist':
                $this->expenselist();
                break;	
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Attendance Report';
        $data['report_name']='attendancelist';
		$data['title']='Attendance Report';
		$data['table']='';
        $this->template->write_view('content','report/report_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

	  
	

    }

	public function attendancelist()
   {
       $offset=0;
	   
       $firstdate=$this->input->post('month');
	   $lastdate=$this->input->post('year');
      
        
        $data1=$this->report_model->attendance_list_timecard($firstdate,$lastdate)->result();
      
        $this->load->library('table');
       $tmpl = array ( 'table_open'  => '<table class="bordered">' );
       $this->table->set_template($tmpl);
       $this->table->set_empty("&nbsp;");
      
	    $j=0;
	 
	   for($k=0;$k<ceil (count($data1)/25);$k++)
	   {
	   echo  $data["div"]=  '<div style="page-break-after: always; ">';
	   echo  $data["div"]=  '<div style="height:100px;dispaly:bolck;"></div>';
	   echo $data["message"]= '<p class="title">Attendance Report</p>';
       $this->table->set_heading('Date', 'Employee Name','Department', 'Shift','InTime','OutTime','Overtime');
       
        $temdate=null;
       for (;$j<count($data1);){
	       if($temdate!=$data1[$j]->Date)
		   {
		   $temdate=$data1[$j]->Date;
           $this->table->add_row($data1[$j]->Date,$data1[$j]->Name,$data1[$j]->department,$data1[$j]->Shift,$data1[$j]->InTime,$data1[$j]->OutTime,$data1[$j]->overtime);
		   }
		   else
		   $this->table->add_row("",$data1[$j]->Name,$data1[$j]->department,$data1[$j]->Shift,$data1[$j]->InTime,$data1[$j]->OutTime,$data1[$j]->overtime);
		   ++$j;
		   if($j%25==0)
             {
			   
                break;
       		
             }
			
       }
	   echo $data["table"]=  $this->table->generate(); 
       echo $data["div"]= '</div>';
       
     }
 } 
 

   	
 public function revenue() 
    {

        $error = null;
        $title = 'Revenue Report';
		$data['coustomer'] = $this->database_model->coustomer()->result();
        $data['report_name']='revenuelist';
		$data['title']='Revenue Report';
		$data['table']='';
        $this->template->write_view('content','report/revenue_report',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

	  
	

    }

	public function revenuelist()
   {
         $offset=0;
	   
       $firstdate=$this->input->post('month');
	   $lastdate=$this->input->post('year');
       $coustomer=$this->input->post('coustomer');
        
        $data1=$this->report_model->get_paged_list_coustomer($firstdate,$lastdate,$coustomer)->result();
      
        $this->load->library('table');
       $tmpl = array ( 'table_open'  => '<table class="bordered">' );
       $this->table->set_template($tmpl);
       $this->table->set_empty("&nbsp;");
      
	    $j=0;
	 
	   for($k=0;$k<ceil (count($data1)/25);$k++)
	   {
	   echo  $data["div"]=  '<div style="page-break-after: always; ">';
	   echo  $data["div"]=  '<div style="height:100px;dispaly:bolck;"></div>';
	   echo $data["message"]= '<p class="title">Revenue Report</p>';
       $this->table->set_heading('Date', 'Coustomer Name','Amount');
       
        $temdate=null;
       for (;$j<count($data1);){
	       if($temdate!=$data1[$j]->date)
		   {
		   $temdate=$data1[$j]->date;
           $this->table->add_row($data1[$j]->date,$data1[$j]->CoustomerName,$data1[$j]->amount);
		   }
		   else
		   $this->table->add_row("",$data1[$j]->CoustomerName,$data1[$j]->amount);
		   ++$j;
		   if($j%25==0)
             {
			   
                break;
       		
             }
			
       }
	   echo $data["table"]=  $this->table->generate(); 
       echo $data["div"]= '</div>';
       
     } 
 

   }   
     public function expense() 
    {

        $error = null;
        $title = 'Expense Report';
        $data['report_name']='expenselist';
		$data['title']='Expense Report';
		$data['table']='';
        $this->template->write_view('content','report/report_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

	  
	

    }

	public function expenselist()
   {
         $offset=0;
	   
       $firstdate=$this->input->post('month');
	   $lastdate=$this->input->post('year');
      
        
        $data1=$this->report_model->expense($firstdate,$lastdate)->result();
      
        $this->load->library('table');
       $tmpl = array ( 'table_open'  => '<table class="bordered">' );
       $this->table->set_template($tmpl);
       $this->table->set_empty("&nbsp;");
      
	    $j=0;
	 
	   for($k=0;$k<ceil (count($data1)/25);$k++)
	   {
	   echo  $data["div"]=  '<div style="page-break-after: always; ">';
	   echo  $data["div"]=  '<div style="height:100px;dispaly:bolck;"></div>';
	   echo $data["message"]= '<p class="title">Expense Report</p>';
       $this->table->set_heading('Date','Type','Description','Amount');
       
        $temdate=null;
       for (;$j<count($data1);){
	       if($temdate!=$data1[$j]->date)
		   {
		   $temdate=$data1[$j]->date;
           $this->table->add_row($data1[$j]->date,$data1[$j]->type,$data1[$j]->description,$data1[$j]->amount);
		   }
		   else
		   $this->table->add_row("",$data1[$j]->type,$data1[$j]->description,$data1[$j]->amount);
		   ++$j;
		   if($j%25==0)
             {
			   
                break;
       		
             }
			
       }
	   echo $data["table"]=  $this->table->generate(); 
       echo $data["div"]= '</div>';
       
     } 
 

   }  
	
}
	?>
