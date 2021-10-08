<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Bill_report  extends User_Controller {
   public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
     
		$this->load->model('delivery_model');
       
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


				case 'invoiceselect':
                $this->invoiceselect();
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
        $title = 'Bill Report';
        
       // $config['base_url'] = site_url('attendance/index/');
        $data['coustomer']= $this->delivery_model->coustomer_all()->result();
	   $this->template->write_view('content','report/bill_report_view',array('data'=>$data,'error'=>$error,'title'=>$title));
       $this->template->render();
	  
	  

    }

	public function order()
   {
      $order= $this->input->post('post_data');
	 
	  $data=$this->delivery_model->order($order)->result();
	  print_r($data);
	 
	 
	    echo '<td width="40%">Order:</td> <td> <select onchange="orderinfo()"  id="ord">';  
        foreach($data as $ord)
        echo "<option value='". $ord->id ."'>". $ord->order_name ."</option>";
        echo '</select> </td>'; 
		
	

   }
   
   public function save()
   {
      $order= $this->input->post('data');
     
       $data1=$this->delivery_model->Bill_report_print($order['order'],$order['invoiceselect'])->result(); 
     
              
	    $j=0;
	 
	   for($k=0;$k<ceil (count($data1)/25);$k++)
	   {
	   echo  $data["div"]=  '<div style="margin-top:150px;" >';
	   echo  $data["div"]=  '<div style="width:500px;float:left;">';
	   echo $data["message"]= '<p>To,</p>';
	   echo $data["message"]= '<p><span style="padding-left:50px;">' .$data1[0]->CoustomerName.'</span></p>';
	   echo $data["message"]= '<p><span style="padding-left:50px;">'.$data1[0]->BillingAddresss.'</span></p>';
	   
	   echo  $data["div"]=  '</div >';
	   
	   echo '<div style="height:80px;padding-left:700px;">';
	   echo '<p <span style="font-size:26px;">INVOICE</span></p>';
	   
	   echo $data["message"]= '<p <span>Date:&nbsp'.$data1[$j]->submit_date.'</span></p>';
	    echo $data["message"]= '<p <span>Invoice No:&nbsp'.$data1[$j]->invoice.'</span></p></div>';
		
		echo  $data["message"]='<div style="margin-top:50px;"/> <div>';
	   
	   $this->load->library('table');
       $tmpl = array ( 'table_open'  => '<table class="bordered" style="margin-left:10px;width:800px;text-align:center;">' );
       $this->table->set_template($tmpl);
       $this->table->set_empty("&nbsp;");

	   
       $this->table->set_heading('QTY', 'DESCRIPTION','UNIT PRICE', 'VAT','AMOUNT');
       
        $temdate=null;
       for (;$j<count($data1);){
	       if($data1[$j]->vat_no==null)
		   $this->table->add_row($data1[$j]->delivery,$data1[$j]->name,$data1[$j]->unit_price,0,number_format($data1[$j]->unit_price*$data1[$j]->delivery,2));
		   else
           $this->table->add_row($data1[$j]->delivery,$data1[$j]->name,$data1[$j]->unit_price,number_format($data1[$j]->unit_price*0.15,2),number_format($data1[$j]->unit_price*$data1[$j]->delivery,2));
		   
		 
		   ++$j;
		   if($j%25==0)
             {
			   
                break;
       		
             }
			
       }
	   echo $data["table"]=  $this->table->generate(); 
       echo $data["div"]= '</div>';
	   $total=0;$Subtotal=0;$vat=0;$totalamount=0;
	   for($r=0;$r<count($data1);$r++)
	   {
	   $total=$total+$data1[$r]->delivery;
	   $Subtotal=$Subtotal+$data1[$r]->delivery*$data1[$r]->unit_price;
	   if($data1[$r]->vat_no==null)
	   $vat=0;
	   else
	   $vat=$vat+$data1[$r]->delivery*0.15*$data1[$r]->unit_price;
	   $totalamount=$vat+$Subtotal;
	   }
	   
	   $totalletter=explode(".",number_format($totalamount,2,'.', ''));
	  
	   $taka="";
	   for($r=0;$r<count($totalletter);$r++)
	   {
	    if($r>0)
	   {
	   $taka .=" & pasia ";
	   
	   }
	   if($totalletter[$r]>0)
	   $taka .= $this->convert_number_to_words($totalletter[$r]);

	   }
	
       echo $data["message"]= '<p style="margin-left:20px;width:150px;">Qty:&nbsp'.$total.'<span style="padding-left:600px;">Subtotal:&nbspBDT&nbsp</span>'.number_format($Subtotal,2).'</p>';
	   
	   $result=$this->delivery_model->order_print($order['order'],$order['invoiceselect'])->result();
	 
	   echo "<p style='margin-left:20px;'>Order No:&nbsp".$result[0]->order_name.'<span style="padding-left:480px;">Vat:&nbsp&nbsp&nbsp&nbsp&nbspBDT&nbsp'.number_format($vat,2)."</span><p>";
	  
	  
	 echo $data["message"]= '<div style="width:900px;"> <div style="margin-left:20px;width:660px;float:left;">In word:&nbsp&nbsp'.$taka.'</div><div style="">Total:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspBDT&nbsp'.number_format($totalamount,2).'</div></div>';
	 
	  }
	  echo "<p style='margin-left:20px;'>Challan No:&nbsp";
	  for($i=0;$i<count($result);$i++){
	   echo $result[$i]->challan_no .',';
	    }
		echo '</p>';
		echo "<p style='margin-left:20px;'>Vat No:&nbsp";
	  for($i=0;$i<count($result);$i++){
	   echo $result[$i]->vat_no .',';
	    }
		echo '</p>';
   }
   
   
   
   function convert_number_to_words($number) {
   
     $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . $this->convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . $this->convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= $this->convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;   
 
}
   public function invoiceselect()
   {
    $bill= $this->input->post('bill');
   $order= $this->input->post('order');
	 
	  $data=$this->delivery_model->invoiceselect_report($order,$bill)->result(); 
	
	 
	 
	     echo '<select id="invoicedata" onchange="tableview()"> ';
        foreach($data as $ord)
        echo "<option value='". $ord->invoice ."'>". $ord->invoice ."</option>";
        echo '</select> ';  
   
   }
public function orderdetail()
   {
       $ord= $this->input->post('post_data');
	   $sta= $this->input->post('status');
	   $invoiceCheck= $this->input->post('invoiceCheck');
	   
	   $orderdetails=$this->delivery_model->Bill_report($ord,$sta,$invoiceCheck)->result();
	 
	 
	      $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table id="tableupdate" class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Material', 'Description', 'Unit Price','delivery','Amount');
        $i = 0 ; 
      
        foreach ($orderdetails as $orderdetail){
		  
		   
            $this->table->add_row(++$i,$orderdetail->name,$orderdetail->description,$orderdetail->unit_price,$orderdetail->delivery,$orderdetail->unit_price*$orderdetail->delivery
                   
				 );
            
        }
        $data = $this->table->generate();
 
	  print(json_encode($data)) ; 
	
   }	 
  
}
	?>
