<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class income_report extends  User_Controller{

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


            case 'income_statement':
                $this->income_statement();
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
        $title = 'Income Statement Report';
        $data['report_name']='Income Statement';
		$data['title']='Income Statement Report';
		$data['table']='';
		$this->template->write_view('content','report/income_report_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
		

    }

	public function income_statement()
   {
   
            $month=$this->input->post('month');
	    $year=$this->input->post('year');
           $first_day = date('y-m-01', strtotime($month." 1," .$year ));

           $last_day = date('y-m-t', strtotime($month." 1," .$year ));
          
        
           $this->load->library('table');
       $tmpl = array ( 'table_open'  => '<table class="bordered">' );
       $this->table->set_template($tmpl);
       $this->table->set_empty("&nbsp;");
     
		$account = $this->report_model->accountbalance($first_day)->row();
		if($account !=null)
		{
		$this->table->add_row("Cash In Hand",$account->amount);
	       echo $this->table->generate();
		}
		$banks = $this->report_model->bankwithdate($first_day)->result();
                 if($banks !=null)
		{
		foreach($banks as $bank)
		$this->table->add_row($bank->bank_name,$bank->amount);
	        echo $this->table->generate();
                }
                echo "<br/>Revenue<br/>"; 
		$revenues=$this->report_model->get_paged_list_coustomer($first_day,$last_day)->result();
		if($revenues!=null)
		{
		foreach($revenues as $revenue)
		$this->table->add_row($revenue->CoustomerName,$revenue->amount);
	    echo $this->table->generate();
		}
		 echo "<br/>Expence<br/>"; 
         $expenses=$this->report_model->expense($first_day,$last_day)->result();
		 if($expenses!=null)
		{
        foreach($expenses as $expense)
		$this->table->add_row($expense->type,$expense->amount);
	    echo $this->table->generate();
		}
            echo "<br/>Supplier<br/>";
        $Suplliers=$this->report_model->Supllier($first_day,$last_day)->result();
		 if($Suplliers!=null)
		{
		foreach($Suplliers as $Supllier)
		$this->table->add_row($Supllier->supplier_name,$Supllier->amount);
	    echo $this->table->generate();
		}
		$salarys=$this->report_model->salary($first_day,$last_day)->result();
                
		if($salarys[0]->salary>0)
		{
		$this->table->add_row("Salary",$salarys[0]->salary);
	    echo $this->table->generate();
		}
		$accountlast = $this->report_model->accountbalancelast($last_day)->row();
		if($accountlast !=null)
		{
        $this->table->add_row("Cash In Hand",$accountlast->amount);
	    echo $this->table->generate();
	    }
		 
		$bankslast = $this->report_model->bankwithdatelast($last_day)->result();
		if($bankslast !=null)
		{
		foreach($bankslast as $bank)
		$this->table->add_row($bank->bank_name,$bank->amount);
	        echo $this->table->generate();
	      }


		
        
	  
    } 
 

   	
 public function revenue() 
    {

        $error = null;
        $title = 'Revenue Report';
        $data['report_name']='revenuelist';
		$data['title']='Revenue Report';
		$data['table']='';
        $this->template->write_view('content','report/report_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

	  
	

    }

	public function revenuelist()
   {
         $offset=0;
	   
       $firstdate=$this->input->post('month');
	   $lastdate=$this->input->post('year');
      
        
        $data1=$this->report_model->get_paged_list_coustomer($firstdate,$lastdate)->result();
      
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
		   $this->table->add_ramountow("",$data1[$j]->type,$data1[$j]->description,$data1[$j]->amount);
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
