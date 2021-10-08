<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');
class Stock extends User_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        
        $this->load->database();
        $this->load->model('stock_model');
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
        $offset = 0;

        $error = null;
        $title = 'Stock Information';
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
         $this->limit=10;
        // load data
        $stocks = $this->stock_model->get_paged_list($this->limit, $offset)->result();
      
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('stock/index/');
        $config['total_rows'] = $this->stock_model->count_all();
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
        $this->table->set_heading('No','Catarory', 'Paper Size', 'Paper Type', 'Date', 'Supplier Name', 'Quantity');
        $i = 0 + $offset;
        foreach ($stocks as $stock){
            $this->table->add_row(++$i,$stock->catagory,$stock->paper_size,$stock->paper_type,$stock->date,$stock->supplier_name,$stock->amount
                //anchor('stock/view/'.$stock->stockId,'view',array('class'=>'view')).' '.
               // anchor('stock/update/'.$stock->id,'update',array('class'=>'update'))
                //anchor('stock/delete/'.$stock->stockId,'delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure want to delete this person?')"))
            );
        }
        $data['table'] = $this->table->generate();

        $this->template->write_view('content','stocklist',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

    }

    public function add()
    {
        $error = null;
        $title = 'Stock Information';
	    $this->set_fields();
        $data['action'] = site_url('stock/adddata');
	    $data['name'] = '';
		$data['message']="";
        $data['link_back'] = anchor('stock/index/','Back to Stock',array('class'=>'back'));
		$data['supplier']= $this->stock_model->supplier_all()->result();
        $this->template->write_view('content','stockadd',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();


      
	}
		
	function set_fields(){
       $this->form_validation->stockId='';
       $this->form_validation->stockName = '';
	   
        //$this->validation->set_fields($fields);
    }

public function adddata()
{

        $data['action'] = site_url('stock/adddata');
		$date=strtotime($this->input->post('date'));
		$newdate= date('y-m-d',$date);
        $stock = array('catagory' => $this->input->post('catagory'),
            'paper_size' => $this->input->post('size'),
            'paper_type' => $this->input->post('type'),
            'amount' => $this->input->post('amount'),
            'date' => $newdate,
            'supplier' => $this->input->post('suppliername'),
            //'address' => $this->input->post('address'),
            //'phonenum' => $this->input->post('Phone'),
			'unit_price' => $this->input->post('price')
        );
		
	
         $total = $this->stock_model->catagory_by_stock($stock)->row();
		 
		 $total->amount=$total->amount+$stock['amount'];
        $this->form_validation->set_rules('amount', 'amount', 'required');
        if ($this->form_validation->run() == FALSE) {

            $data['name'] = 'error';



        } else {
		
            $id = $this->stock_model->save($stock);
			$this->stock_model->total_update($total);
            $data['message'] = '<div class="success">Add Stock Information success</div>';

        }
$data['supplier']= $this->stock_model->supplier_all()->result();
		$this->set_fields();

        $data['name'] = '';
        $error = null;
        $title = 'Stock Information';
        $data['link_back'] = anchor('stock/index/','Back to Stock',array('class'=>'back'));
        $this->template->write_view('content','stockadd',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();


}

		 public function update($id)
    {

    	$stock = $this->stock_model->get_by_id($id)->row();
	   $data['name'] = '';
	   $data['action'] = site_url('stock/updatedata');
	   $this->form_validation->stockId =$id;
	   $this->form_validation->stockName = $stock->paper_size;
	   $this->form_validation->ContractName = $stock->date;
	   $this->form_validation->BillingAddresss = $stock->supplier_name;
	   $this->form_validation->City = $stock->address;
	   $this->form_validation->StateForProvince = $stock->phonenum;
	   $this->form_validation->PostalCode = $stock->unit_price;

	   $this->load->view('stockAdd', $data);

	}

	 public function updatedata()
    {
	   $this->form_validation->set_rules('stockName', 'stockName', 'required');
	   $stock = array('stockName' => $this->input->post('stockName'),
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
            $this->load->view('stockAdd', $data);
        } else {
		    $id=$this->input->post('stockId');
            $this->stock_model->update($id,$stock);
            echo "success";

        }
    }
    


}

?>