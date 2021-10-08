<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Employee extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('Employee_model');
        $this->load->library('form_validation');
		$this->load->library('Calendar');
       

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

            case 'view':
                $this->view();
                break;

            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Employee Information';


        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $this->limit=10;
        // load data
        $Employees = $this->Employee_model->get_paged_list($this->limit, $offset)->result();
      
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('employee/index/');
        $config['total_rows'] = $this->Employee_model->count_all();
		 
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;

        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generate table data
        $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Employee Name', 'Departmant', 'Designation', 'Personal ID',"Status","Action");
        $i = 0 + $offset;
      
        foreach ($Employees as $Employee){
            $this->table->add_row(++$i,$Employee->Name,$Employee->department,$Employee->Designation,$Employee->PersonalId,$Employee->active,
                anchor('employee/view/'.$Employee->EmployeeId,'View',array('class'=>'btn btn-small btn-info')).' '.
                anchor('employee/update/'.$Employee->EmployeeId,'Update',array('class'=>'btn btn-small btn-warning'))
            );
        }
        $data['table'] = $this->table->generate();
        $this->template->write_view('content','employeelist',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

    }

    public function add()
    {
        $data['message'] ='';
        $this->set_fields();
        $data['action'] = site_url('employee/adddata');
        $data['name'] = '';
        $error = null;
        $title = 'Employee Information';
		 $data['department']= $this->Employee_model->department_all()->result();
		$data['calendar']= $this->calendar->generate();
        $data['link_back'] = anchor('employee/index/','Back to Employees',array('class'=>'back'));
        $this->template->write_view('content','employeeadd',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

    }

 

    public function adddata()
    {
	
        $this->form_validation->set_rules('EmployeeName', 'EmployeeName', 'required');
		
        $Employee = $this->postdata();

        if ($this->form_validation->run() == FALSE) {

            $data['name'] = 'error';
            $this->load->view('employeeadd', $data);
        } else {
            $id = $this->Employee_model->save($Employee);
            $data['message'] = '<div class="success">Add Employee Information success</div>';

        }

        $this->set_fields();
        $data['action'] = site_url('employee/adddata');
        $data['name'] = '';
        $error = null;
        $title = 'Employee Information';
        $data['link_back'] = anchor('employee/index/','Back to Employees',array('class'=>'back'));
        $this->template->write_view('content','employeeadd',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

    }

    public function update()
    {

        $id = $this->uri->segment(3);
        $data['message'] ='';
        $error = null;
        $title = 'Employee Information';
        $data['name'] = '';
		$data['department']= $this->Employee_model->department_all()->result();
        $data['action'] = site_url('employee/updatedata');
        $data['link_back'] = anchor('employee/index/','Back to Employees',array('class'=>'back'));


        $this->upadtedataload($id);
        $this->template->write_view('content','employeeadd',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

    }



    public function updatedata()
    {
        $data['message'] ='';
        $error = null;
        $title = 'Employee Information';

        $data['name'] = '';
        $data['action'] = site_url('employee/updatedata');
$data['department']= $this->Employee_model->department_all()->result();
        $this->form_validation->set_rules('EmployeeName', 'EmployeeName', 'required');
        $Employee =  $this->postdata();
        if ($this->form_validation->run() == FALSE) {

            $data['name'] = 'error';
            $this->load->view('employeeadd', $data);
        } else {
            $id=$this->input->post('EmployeeId');
            $this->Employee_model->update($id,$Employee);
            $data['message'] = '<div class="success">update Employee Information success</div>';

        }
        $data['link_back'] = anchor('employee/index/','Back to Employees',array('class'=>'back'));
        $this->upadtedataload($id);
        $this->template->write_view('content','employeeadd',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
    }

    public function view()
    {

        $id = $this->uri->segment(3);
        $data['link_back'] = anchor('employee/index/','Back to Employees',array('class'=>'back'));
        $error = null;
        $title = 'Employee Information';

        $this->upadtedataload($id);
        $this->template->write_view('content','employeeview',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
    }
	
	    function upadtedataload($id)
    {
        $Employee = $this->Employee_model->get_by_id($id)->row();


        $this->form_validation->EmployeeId =$id;
        $this->form_validation->Name = $Employee->Name;
        $this->form_validation->Department = $Employee->Department;
		 $this->form_validation->department = $Employee->department;
        $this->form_validation->Designation = $Employee->Designation;
        $this->form_validation->joiningdatedate = $Employee->joiningdate;
        $this->form_validation->Salary = $Employee->Salary;
        $this->form_validation->Address = $Employee->address;
        $this->form_validation->PhoneNum = $Employee->phonenum;
        $this->form_validation->age = $Employee->age;
        $this->form_validation->personalId = $Employee->PersonalId;
		$this->form_validation->leave = $Employee->Leave;
        $this->form_validation->active = $Employee->active;
        $this->form_validation->Note = $Employee->Note;
        $this->form_validation->image = $Employee->Image;
	
    }
	
	   function set_fields(){
        $this->form_validation->EmployeeId='';
        $this->form_validation->Name = '';
        $this->form_validation->Department = '';
        $this->form_validation->Designation = '';
        $this->form_validation->joiningdatedate ='';
        $this->form_validation->Salary = '';
        $this->form_validation->Address = '';
        $this->form_validation->PhoneNum = '';
        $this->form_validation->age = '';
        $this->form_validation->personalId = '';
		$this->form_validation->leave = '';
        $this->form_validation->active ='';
        $this->form_validation->Note = '';
        $this->form_validation->image ='';

    }
	
	function postdata()
	{
	$time = strtotime($this->input->post('date'));
		$newdate= date('Y-m-d',$time);

	    $config['upload_path'] = './uploads/';
	    $config['allowed_types'] = 'gif|jpg|png';

	if($_FILES["myfile"]["name"]!="" )
	{
       $this->load->library('upload', $config);

       $this->upload->do_upload('myfile');
	   $file_tep_name=$this->upload->data();
	   $file_name="/uploads/". $file_tep_name['file_name'];
	    $Employee = array('Name' => $this->input->post('EmployeeName'),
            'Department' => $this->input->post('Department'),
            'Designation' => $this->input->post('Designation'),
            'joiningdate' => $newdate,
            'salary' => $this->input->post('salary'),
            'Address' => $this->input->post('address'),
            'PhoneNum' => $this->input->post('Status'),
            'PhoneNum' => $this->input->post('Phone'),
            'age' => $this->input->post('age'),
            'personalId' => $this->input->post('personalid'),
			'Leave' => $this->input->post('leave'),
            'Note' => $this->input->post('Notes'),
			'active' =>$this->input->post('Status'),
			'image' =>  $file_name
        );
	  
	 
	 }
	 else 
	 {
       $Employee = array('Name' => $this->input->post('EmployeeName'),
            'Department' => $this->input->post('Department'),
            'Designation' => $this->input->post('Designation'),
            'joiningdate' => $newdate,
            'salary' => $this->input->post('salary'),
            'Address' => $this->input->post('address'),
            'PhoneNum' => $this->input->post('Status'),
            'PhoneNum' => $this->input->post('Phone'),
            'age' => $this->input->post('age'),
            'personalId' => $this->input->post('personalid'),
			'Leave' => $this->input->post('leave'),
            'Note' => $this->input->post('Notes'),
			'active' =>$this->input->post('Status'),
			
        );
		}
		return $Employee;
	}

}