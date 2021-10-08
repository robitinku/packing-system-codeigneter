<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Delivery  extends User_Controller {
   public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
     
		$this->load->model('delivery_model');
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


            case 'order':
                $this->order();
                break;
				
			case 'orderdetail':
                $this->orderdetail();
                break;
			case 'save':
                $this->save();
                break;
            
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Delivery Information';
        $data['title']= 'Delivery Information';
       // $config['base_url'] = site_url('attendance/index/');
        $data['coustomer']= $this->delivery_model->coustomer_all()->result();
	    $this->template->write_view('content','deliveryview',array('data'=>$data,'error'=>$error,'title'=>$title));
       $this->template->render();
	   
	  

    }

	public function order()
   {
      $order= $this->input->post('post_data');
	 
	  $data=$this->delivery_model->order($order)->result();
	  
	 
	 
	    echo '<td>Order:</td> <td> <select onchange="orderinfo()"  id="ord">';  
        foreach($data as $ord)
        echo "<option value='". $ord->id ."'>". $ord->order_name ."</option>";
        echo '</select> </td>'; 
		
	

   }
   
   public function save()
   {
      $order= $this->input->post('data');
	  $status= $this->input->post('status');
	  
      foreach($order as $ord)
	  
	  {
	  $offset=6*60*60; //converting 5 hours to seconds.
	  $dateFormat="y-m-d";
	  $timeNdate=gmdate($dateFormat, time()+$offset);
	  $temptime=strtotime($timeNdate);
	  $newdate=date("y-m-d",$temptime);
	  
	  $ord['delivery_date']=$newdate;
	 // $checkdata=$this->delivery_model->checkbill($ord)->row();
      $this->delivery_model->save($ord);
       $this->delivery_model->update_product($ord,$status);
	   echo "save successfully";
	  
	  }

   }
public function orderdetail()
   {
      $ord= $this->input->post('post_data');
	  $orderdetails=$this->delivery_model->orderinfo($ord)->result();
	 
	    $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table id="tableupdate" class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Material','Challan No','Vat No','Description','Delivery Date' ,'Quantity',"Balance","Status","Delivery","");
        $i = 0 ;
       
        foreach ($orderdetails as $orderdetail){
		     $remains=$this->delivery_model->remain($orderdetail->detail_id)->result();
			  $product=$this->delivery_model->product($orderdetail)->row();
			  if($product==null)
			  $product_stock=0;
			  else
			  $product_stock=$product->carton;
			 if($remains==null)
			    $remaindata=$orderdetail->quantity;
		    else
			{
			  $remaindata=0;
			 foreach($remains as $remain)
			 
			   $remaindata=$remaindata+$remain->delivery;
			  $remaindata=$orderdetail->quantity-$remaindata;
			}
				
			 
			 
            $this->table->add_row(++$i,$orderdetail->name,
			'<input name="challan_no" type="text"  style="width:70px;"/>',
			'<input name="vat_no" type="text"  style="width:70px;"/>',
			$orderdetail->description,$orderdetail->ddate,$orderdetail->quantity,
               // '<input class="date" type="text" name="date"  size="40"  readonly="readonly"/>',
				'<input name="remain" type="text"   size="40" value="'.$remaindata.'" readonly="readonly" style="width:35px;"/>',
				'<input name="status" type="text" readonly="readonly"  size="40" value="'.$product_stock.'" style="width:35px;"/>',
				'<input name="delivery" type="text"   size="40" style="width:35px;"/>',
                 '<input type="hidden" name="id" value="'.$orderdetail->detail_id.'"/> <a class="update" href="#">update </a>');
            
        }
        $data = $this->table->generate();

	  print(json_encode($data));
		
	

   }	 
  
}
	?>
