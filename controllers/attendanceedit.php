<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class AttendanceEdit extends  User_Controller{

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
        $title = 'Daily Attendance ';
        
       // $config['base_url'] = site_url('attendance/index/');
       // $data['department']= $this->attendance_model->department_all()->result();
		
		$data['table']='';
        $this->template->write_view('content','attendance_edit_view',array('data'=>$data,'error'=>$error,'title'=>$title));
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
       $data1=$this->attendance_model->attendance_list($newdate)->result();
       //$config['total_rows'] =3; //count($data1);



      // $config['per_page'] = $this->limit;
       //$config['uri_segment'] = $uri_segment;
       //$this->pagination->initialize($config);
       //$data['pagination'] = $this->pagination->create_links();




       $this->load->library('table');
       $tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
       $this->table->set_template($tmpl);
       $this->table->set_empty("&nbsp;");
       $this->table->set_heading('No', 'Employee Name','Department', 'Designation', 'Personal Id', 'InTime','OutTime','Shift','');
       $i = 0 + $offset;

       foreach ($data1 as $attendance){
           $this->table->add_row(++$i,$attendance->Name,$attendance->department,$attendance->Designation,$attendance->PersonalId,$attendance->intime,$attendance->outime,
                                 $attendance->shift,
               anchor('attendanceedit/update/'.$attendance->id,'update',array('class'=>'btn btn-small btn-warning'))

           );
       }
       $data['table'] = $this->table->generate();
      // echo $data['pagination'];
       echo $data['table'];





        

   }	
   
   	public function update()
   {
        $id = $this->uri->segment(3);
        $data['message'] ='';
        $error = null;
        $title = 'Attendace Information';
        $data['name'] = '';
        $data['action'] = site_url('attendanceedit/updatedata');
        $data['link_back'] = anchor('attendanceedit/index/','Back to Attendance',array('class'=>'back'));

         $this ->updatedataload($id);

        $this->template->write_view('content','attendance_update',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();


   }
   
function updatedataload($id)
{
    $attendance = $this->attendance_model->get_by_id($id)->row();
    $intime=explode(":",$attendance->intime);
    $this->form_validation->Name = $attendance->Name;
    $this->form_validation->Department = $attendance->Department;
    $this->form_validation->Designation = $attendance->Designation;
    $this->form_validation->personalId = $attendance->PersonalId;
	$this->form_validation->date = $attendance->date;
	$this->form_validation->employee_id = $attendance->employeeid;

    $this->form_validation->Id=$attendance->id;
    $this->form_validation->inmin=	$intime[1];
    $this->form_validation->inhour=$intime[0];
    $this->form_validation->shift=$attendance->shift;
    if($attendance->outime!=null)
    {
        $time=explode(":",$attendance->outime);
        $this->form_validation->outmin=	$time[1];
        $this->form_validation->outhour=$time[0];
    }
    else
    {
        $this->form_validation->outmin="";
        $this->form_validation->outhour="";
    }
}

    public function updatedata()
   {

        $error =''  ;
        $title = 'Attendace Information';

        $data['name'] = '';
        $data['action'] = site_url('attendanceedit/updatedata');



            $id=$this->input->post('id');
            $inhour=$this->input->post('inhour');
            $inmin=$this->input->post('inmin');
            $arr = array($inhour,$inmin);
            $intime=implode(":",$arr);
            $outhour=$this->input->post('outhour');
			
            $outmin=$this->input->post('outmin');
             if($outhour!=null && $outmin!=null){
                 $arr = array($outhour,$outmin);
                 $outtime=implode(":",$arr);

             }
       else
           $outtime=null;


       $attandance = array( 'id'=>$this->input->post('id'),
           'intime' => $intime,
           'outtime' => $outtime,
		   'shift'=>$this->input->post('shift')

       );
	   
       $this->attendance_model->update($attandance);
       $data['message'] = '<div class="success">Update Attendace Information Success</div>';


        $data['link_back'] = anchor('attendanceedit/index/','Back to Attendace',array('class'=>'back'));
       $this ->updatedataload($id);
	   $casulastaftimecard=$this->timecard($attandance['intime'],$attandance['outtime'],$attandance['shift']);
	    
	
	   $casulastaftimecard['Date']=$this->form_validation->date;
		$casulastaftimecard['EmployeeId']=$this->form_validation->employee_id;
		  $casulastaftimecard['attendance_id']=  $id;
       $this->attendance_model->updatetimecard($casulastaftimecard);

        $this->template->write_view('content','attendance_update',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
   }
function timecard($intime,$outtime,$shift)
	{
		 	/* $shiftA = $this->maintenance_model->get_by_Catgoryname("shift A")->row();
			$shiftB = $this->maintenance_model->get_by_Catgoryname("shift B")->row();
			$shiftC = $this->maintenance_model->get_by_Catgoryname("shift C")->row();
			
			if(strtotime($shiftA->inrange)<strtotime($intime) && strtotime($shiftA->outrange)>=strtotime($intime) )
			$shift= "A";
			if(strtotime($shiftB->inrange)<strtotime($intime) && strtotime($shiftB->outrange)>=strtotime($intime) )
			$shift= "B";
			if(strtotime($shiftC->inrange)<strtotime($intime) && strtotime($shiftC->outrange)>=strtotime($intime)  && strtotime($intime)>strtotime($outtime) )
			$shift= "C"; */
			
			
			if($shift=="C")
			$cr=2;
			else
			$cr=0;
			
			if($shift=="C")
			{
			$inhour=explode(":",$intime);
			$outhour=explode(":",$outtime);

			$workinghour=24-$inhour[0]+$outhour[0]+$cr;
			}
			else
			{
			$inhour=explode(":",$intime);
			$outhour=explode(":",$outtime);

			$workinghour=$outhour[0]-$inhour[0]+$cr;

			}
			if($workinghour>9)
			$overtime=$workinghour-9;
			else
			$overtime=null;
			$food=0;
			$snackvalue = $this->maintenance_model->get_by_Catgoryname("snack")->row();
			if($intime>0)
			{
			$snack=1;
			$food=$food+$snackvalue->value;
			}			
			else
			$snack=0;
			
			$lunch = $this->maintenance_model->get_by_Catgoryname("Lunch")->row();
			if(strtotime($lunch->inrange)>strtotime($intime) && strtotime($lunch->outrange<strtotime($outtime) ))
			{
			$lunch=1;
			$food=$food+$lunch->value;
			}
			else
			$lunch=0;
			
			$Dinner = $this->maintenance_model->get_by_Catgoryname("Dinner")->row();
			if(strtotime($Dinner->inrange)>strtotime($intime) && strtotime($Dinner->outrange<strtotime($outtime) ))
			{$dinner=1;
			$food=$food+$Dinner->value;
			}
			
			else
			$dinner=0;
			
			$lDinner = $this->maintenance_model->get_by_Catgoryname("L.dinner")->row();
			//if(strtotime($lDinner->inrange)>strtotime($intime) && strtotime($lDinner->outrange<strtotime($outtime) ))
			if($shift=="C")
			{
			$food=$food+$lDinner->value;
			$ldinner=1;
			}
			else
			$ldinner=0;
			
            $cshiftpay=0;
			if($shift=="C")
			$cshiftpay=13.5*2;
          $total=$cshiftpay+$food;
          $casulastaftimecard=array('Date'=>null,
		  'EmployeeId'=>null,
		  'Shift'=>$shift,
		  'InTime'=>$intime,
		  'OutTime'=>$outtime,
		  'WorkingHour'=>$workinghour,
		  'CHr'=>$cr,
		  'Snaks'=>$snack,
		  'Lunch'=>$lunch,
		  'Dinner'=>$dinner,
		  'LDinner'=>$ldinner,
		  'Food'=>$food,
		  'CShiftPay'=>$cshiftpay,
		  'Total'=>$total,
		   'overtime'=>$overtime
		  );
		  
		  return $casulastaftimecard;
			
			
			
	}
}
	?>
