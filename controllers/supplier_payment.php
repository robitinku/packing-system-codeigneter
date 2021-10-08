<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class supplier_payment  extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('database_model');
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
        $title = 'Supplier PaymentInformation';
        $data="";
          
         
        /* $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $this->limit=10; */
        // load data
        
		 $data['supplier'] = $this->database_model->supplier()->result();
		
         /*
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('revenue/index/');
        $config['total_rows'] = $this->database_model->count_all('revenue');
		 
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
        $data['pagination'] = $this->pagination->create_links(); */

        // generate table data
      
        
	    $offset=6*60*60; //converting 5 hours to seconds.
		$dateFormat="y-m-d";
		$date=gmdate($dateFormat, time()+$offset);
	   $data['table'] =$this->tableganarate($date);
		
		$this->template->write_view('content','supplier_payment_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render(); 

    }

 function tableganarate($date)
 {       
        $suppliers = $this->database_model->get_paged_list_supplier($date)->result();
        $this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Supplier Name','Amount','Date',"");
        $i = 0;
      
        foreach ($suppliers as $supplier ){
		
            $this->table->add_row(++$i,$supplier ->supplier_name,$supplier ->amount,$supplier ->date,
             '<input type="hidden" value="'.$supplier ->id.'" name="id"/> <a href="#" class="btn btn-small btn-warning"> update</a>'
                

            );
        }
        return $this->table->generate();
 
 }

 

    public function adddata()
    {
	
    	    $supplier =  $this->input->post('supplier');
			$offset=6*60*60; //converting 5 hours to seconds.
			$dateFormat="y-m-d";
			$timeNdate=gmdate($dateFormat, time()+$offset);
	  
            $supplier['date']=$timeNdate;
			$account = $this->database_model->accountbalance()->row();
		    $amount=$account->amount-$supplier['amount']; 
			$account = array(
		        'date' =>$supplier['date'],
		        'amount' =>$amount
		        );
			if($amount>=0)
		   {
		    $this->database_model->accountupdte($account);
            $id = $this->database_model->save($supplier,'supplier_payment');
           echo "Add Successfully"; 
            }
		  else echo "Balance not sufficient";
      

    }

    public function update()
    {
        $id=$this->input->post('id');
        $supplier = $this->database_model->get_by_id($id,'supplier_payment')->row();
		
         $supplier = array('id' =>$supplier->id,
		   'supplier_id' =>$supplier->supplier_id,
		   'amount' =>$supplier->amount,
		   'date'=>$supplier->date
		   );
  	    print(json_encode($supplier)) ; 
       

    }



    public function updatedata()
    {
	          $supplier =  $this->input->post('supplier');
			/*  $offset=6*60*60; //converting 5 hours to seconds.
			 $dateFormat="y-m-d";
			 $timeNdate=gmdate($dateFormat, time()+$offset);
	  
             $revenue['date']=$timeNdate; */
			 $accup = $this->database_model->get_by_id($supplier['id'],'supplier_payment')->row();
			 $account = $this->database_model->accountbalance()->row();
		     $amount=$account->amount-($supplier['amount']-$accup->amount);
			 $account = array(
		        'date' =>$supplier['date'],
		        'amount' =>$amount
		        );
			 if($amount>=0)
		   {
		     $this->database_model->accountupdte($account);
             $this->database_model->updatedata($supplier,'supplier_payment');
			 echo "Update Successfully";
			}
		    else  echo "Balance not sufficient";
    }

    public function table()
	{
	 $date =  $this->input->post('date');

	 $data['table'] =$this->tableganarate($date);
	 print(json_encode($data)) ;
      
	}

	


}