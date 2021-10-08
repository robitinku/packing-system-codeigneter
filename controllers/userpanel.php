<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Userpanel extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
	    $this->load->database();
        $this->load->model('coustomer_model');
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
	 $title = 'Coustomer Information';
    
		
 // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
         $this->limit=10;
        // load data
        $coustomers = $this->coustomer_model->get_paged_list($this->limit, $offset)->result();
      
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('userpanel/index/');
        $config['total_rows'] = $this->coustomer_model->count_all();
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
        $this->table->set_heading('No', 'Coustomer Name', 'Contract Name', 'Billing Addresss', 'City','StateForProvince', 'Postal Code','Status',"","");
        $i = 0 + $offset;
		//$coustomer->CountryRegion,$coustomer->ContractTitle,$coustomer->PhoneNum,$coustomer->FaxNum,$coustomer->EMail,$coustomer->Notes
       //'Country Region', 'Contract Title','Phone Number', 'Fax Number', 'E-Mail', 'Notes'
			        foreach ($coustomers as $coustomer){
            $this->table->add_row(++$i,$coustomer->CoustomerName,$coustomer->ContractName,$coustomer->BillingAddresss,$coustomer->City,$coustomer->StateForProvince,$coustomer->PostalCode,$coustomer->active,
                anchor('userpanel/view/'.$coustomer->CoustomerId,'View',array('class'=>'btn btn-small btn-info')),
                anchor('userpanel/update/'.$coustomer->CoustomerId,'Update',array('class'=>'btn btn-small btn-warning'))
            );
        }
        $data['table'] = $this->table->generate();
        $this->template->write_view('content','coustomerlist',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
        
    }

   public function add()
    {
       $data['message'] ='';
	   $this->set_fields();
       $data['action'] = site_url('userpanel/adddata');
	   $data['name'] = '';
	   $error = null;
	   $title = 'Coustomer Information';
       $data['link_back'] = anchor('userpanel/index/','Back to coustomers',array('class'=>'back'));
       $this->template->write_view('content','CoustomerAdd',array('data'=>$data,'error'=>$error,'title'=>$title));
       $this->template->render();
      
	}
	
    function set_fields(){
       $this->form_validation->CoustomerId='';
       $this->form_validation->CoustomerName = '';
	   $this->form_validation->ContractName = '';
	   $this->form_validation->BillingAddresss = '';
	   $this->form_validation->City ='';
	   $this->form_validation->StateForProvince = '';
	   $this->form_validation->PostalCode = '';
	   $this->form_validation->CountryRegion = '';
	   $this->form_validation->ContractTitle = '';
	   $this->form_validation->PhoneNum = '';
	   $this->form_validation->FaxNum = '';
	   $this->form_validation->Notes = '';
       $this->form_validation->active = '';
	   $this->form_validation->EMail = '';

    }

    public function adddata()
    {
        $this->form_validation->set_rules('CoustomerName', 'CoustomerName', 'required');
        $Coustomer = array('CoustomerName' => $this->input->post('CoustomerName'),
            'ContractName' => $this->input->post('Contract'),
            'BillingAddresss' => $this->input->post('billing'),
            'City' => $this->input->post('City'),
            'StateForProvince' => $this->input->post('State'),
            'PostalCode' => $this->input->post('Postal'),
            'CountryRegion' => $this->input->post('Country'),
            'ContractTitle' => $this->input->post('Title'),
            'PhoneNum' => $this->input->post('Phone'),
            'FaxNum' => $this->input->post('Fax'),
            'EMail' => $this->input->post('Email'),
            'Notes' => $this->input->post('Notes'),
			'active' => $this->input->post('Status')
        );


        if ($this->form_validation->run() == FALSE) {

            $data['name'] = 'error';
         
        } else {
            $id = $this->coustomer_model->save($Coustomer);
            $data['message'] = '<div class="success">Add Coustomer Information success</div>';
             $data['name'] = '';
        }

        $this->set_fields();
        $data['action'] = site_url('userpanel/adddata');
     
        $error = null;
        $title = 'Coustomer Information';
        $data['link_back'] = anchor('userpanel/index/', 'Back to coustomers', array('class' => 'back'));
        $this->template->write_view('content', 'CoustomerAdd', array('data' => $data, 'error' => $error, 'title' => $title));
        $this->template->render();

    }

    public function update()
    {

	   $id = $this->uri->segment(3);
       $data['message'] ='';
       $error = null;
	   $title = 'Coustomer Information';
	   $data['name'] = '';
	   $data['action'] = site_url('userpanel/updatedata');
	   $data['link_back'] = anchor('userpanel/index/','Back to coustomers',array('class'=>'back'));


	   $this->upadtedataload($id);
	   $this->template->write_view('content','CoustomerAdd',array('data'=>$data,'error'=>$error,'title'=>$title));
       $this->template->render();

	}
	
	function upadtedataload($id)
	{
	   $coustomer = $this->coustomer_model->get_by_id($id)->row();
	
	   
	   $this->form_validation->CoustomerId =$id;
	   $this->form_validation->CoustomerName = $coustomer->CoustomerName;
	   $this->form_validation->ContractName = $coustomer->ContractName;
	   $this->form_validation->BillingAddresss = $coustomer->BillingAddresss;
	   $this->form_validation->City = $coustomer->City;
	   $this->form_validation->StateForProvince = $coustomer->StateForProvince;
	   $this->form_validation->PostalCode = $coustomer->PostalCode;
	   $this->form_validation->CountryRegion = $coustomer->CountryRegion;
	   $this->form_validation->ContractTitle = $coustomer->ContractTitle;
	   $this->form_validation->PhoneNum = $coustomer->PhoneNum;
	   $this->form_validation->FaxNum = $coustomer->FaxNum;
	   $this->form_validation->Notes = $coustomer->Notes;
	   $this->form_validation->active = $coustomer->active;
	   $this->form_validation->EMail = $coustomer->EMail;
	}
    
    public function updatedata()
    {
	   $data['message'] ='';
       $error = null;
	   $title = 'Coustomer Information';

	   $data['name'] = '';
	   $data['action'] = site_url('userpanel/updatedata');

	   $this->form_validation->set_rules('CoustomerName', 'CoustomerName', 'required');
	   $Coustomer = array('CoustomerName' => $this->input->post('CoustomerName'),
            'ContractName' => $this->input->post('Contract'),
            'BillingAddresss' => $this->input->post('billing'),
            'City' => $this->input->post('City'),
            'StateForProvince' => $this->input->post('State'),
            'PostalCode' => $this->input->post('Postal'),
            'CountryRegion' => $this->input->post('Country'),
            'ContractTitle' => $this->input->post('Title'),
            'PhoneNum' => $this->input->post('Phone'),
            'FaxNum' => $this->input->post('Fax'),
            'EMail' => $this->input->post('Email'),
            'Notes' => $this->input->post('Notes'),
			'active' => $this->input->post('Status')
        );

 if ($this->form_validation->run() == FALSE) {

            $data['name'] = 'error';
            $this->load->view('CoustomerAdd', $data);
        } else {
		    $id=$this->input->post('CoustomerId');
            $this->coustomer_model->update($id,$Coustomer);
            $data['message'] = '<div class="success">update Coustomer Information success</div>';

        }
		 $data['link_back'] = anchor('userpanel/index/','Back to coustomers',array('class'=>'back'));
		 $this->upadtedataload($id);
		$this->template->write_view('content','CoustomerAdd',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
    }

   public function view()
    {

	    $id = $this->uri->segment(3);
		 $data['link_back'] = anchor('userpanel/index/','Back',array('class'=>'btn btn-success'));
        $error = null;
	    $title = 'Coustomer Information';

	    $this->upadtedataload($id);
	    $this->template->write_view('content','coustomerview',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
	}

}