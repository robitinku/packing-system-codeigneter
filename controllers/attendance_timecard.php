<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class Attendance_timecard extends  User_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('attendance_model');
        $this->load->library('form_validation');
		$this->load->model('maintenance_model');
       

    }

    function _remap( $method )
    {

        // $method contains the second segment of your URI
        switch( $method )
        {
            case 'index':
                $this->index();
                break;


            case 'attendancelist':
                $this->attendancelist();
                break;
				
			case 'update':
                $this->update();
                break;
			case 'intime':
                $this->intime();
                break;
			case 'updatedata':
                $this->updatedata();
                break;
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Attendance Timecard';
        
       // $config['base_url'] = site_url('attendance/index/');
       // $data['department']= $this->attendance_model->department_all()->result();
		
		$data['table']='';
        $this->template->write_view('content','attendance_timecard_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

	  
	

    }

	public function attendancelist()
   {
       $offset=0;
       $date=$this->input->post('post_data');
       $temptime=strtotime($date);
       $newdate=date("y-m-d",$temptime);
       //$uri_segment = 3;
       //$offset = $this->uri->segment($uri_segment);
      // $this->limit=2;
       // load data
       //$Employees = $this->Employee_model->get_paged_list($this->limit, $offset)->result();

       // generate pagination
       //$this->load->library('pagination');
       ////$config['base_url'] = site_url('attendanceedit/attendancelist/');
       $data1=$this->attendance_model->attendance_list_timecard($newdate)->result();
       //$config['total_rows'] =3; //count($data1);

      

      // $config['per_page'] = $this->limit;
       //$config['uri_segment'] = $uri_segment;
       //$this->pagination->initialize($config);
       //$data['pagination'] = $this->pagination->create_links();


     

        $this->load->library('table');
       $tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
       $this->table->set_template($tmpl);
       $this->table->set_empty("&nbsp;");
       $this->table->set_heading('No', 'Employee Name','Department', 'Shift','InTime','OutTime','WorkingHour','C Hour','Snaks',                                'Lunch','Dinner','LDinner','Food','CShiftPay','Overtime', 'Total');
       $i = 0;

       foreach ($data1 as $attendance){
           $this->table->add_row(++$i,$attendance->Name,$attendance->department,$attendance->Shift,$attendance->InTime,
                                 $attendance->OutTime,$attendance->WorkingHour,$attendance->CHr,$attendance->Snaks,$attendance->Lunch,$attendance->Dinner,$attendance->LDinner,$attendance->Food,$attendance->CShiftPay,$attendance->overtime,$attendance->Total
              // anchor('attendanceedit/update/'.$attendance->id,'update',array('class'=>'update'))

           );
       }
       $data['table'] = $this->table->generate();
      // echo $data['pagination'];
       echo $data['table']; 


   }	
   
   
}
	?>
