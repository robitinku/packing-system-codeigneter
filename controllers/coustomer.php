<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coustomer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        
        $this->load->database();
        $this->load->model('coustomer_model');
        $this->load->library('form_validation');

    }

    public function index($offset = 0)
    {
 // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
         $this->limit=2;
        // load data
        $coustomers = $this->coustomer_model->get_paged_list($this->limit, $offset)->result();
      
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('coustomer/index/');
        $config['total_rows'] = $this->coustomer_model->count_all();
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
         
       // generate table data
        $this->load->library('table');

        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Coustomer Name', 'Contract Name', 'Billing Addresss', 'City','StateForProvince', 'Postal Code', 'Country Region', 'Contract Title','Phone Number', 'Fax Number', 'E-Mail', 'Notes');
        $i = 0 + $offset;
        foreach ($coustomers as $coustomer){
            $this->table->add_row(++$i,$coustomer->CoustomerName,$coustomer->ContractName,$coustomer->BillingAddresss,$coustomer->City,$coustomer->StateForProvince,$coustomer->PostalCode,$coustomer->CountryRegion,$coustomer->ContractTitle,$coustomer->PhoneNum,$coustomer->FaxNum,
			$coustomer->EMail,$coustomer->Notes,
                anchor('coustomer/view/'.$coustomer->CoustomerId,'view',array('class'=>'view')).' '.
                anchor('coustomer/update/'.$coustomer->CoustomerId,'update',array('class'=>'update')).' '.
                anchor('coustomer/delete/'.$coustomer->CoustomerId,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure want to delete this person?')"))
            );
        }
        $data['table'] = $this->table->generate();
         
        // load view
        $this->load->view('coustomerlist', $data);
    }

	
	
    public function add()
    {
	   $this->set_fields();
       $data['action'] = site_url('coustomer/adddata');
	   $data['name'] = '';
       $this->load->view('CoustomerAdd', $data);

      
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
            'Notes' => $this->input->post('Notes')
        );


        if ($this->form_validation->run() == FALSE) {

            $data['name'] = 'error';
            $this->load->view('CoustomerAdd', $data);
        } else {
            $id = $this->coustomer_model->save($Coustomer);
            echo "success";

        }

}		
		 public function update($id)
    {

    	$coustomer = $this->coustomer_model->get_by_id($id)->row();
	   $data['name'] = '';
	   $data['action'] = site_url('coustomer/updatedata');
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
	   $this->load->view('CoustomerAdd', $data);
	 
	}
	 public function updatedata()
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
            'Notes' => $this->input->post('Notes')
        );

 if ($this->form_validation->run() == FALSE) {

            $data['name'] = 'error';
            $this->load->view('CoustomerAdd', $data);
        } else {
		    $id=$this->input->post('CoustomerId');
            $this->coustomer_model->update($id,$Coustomer);
            echo "success";

        }
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
         
        //$this->validation->set_fields($fields);
    }
    


}

?>