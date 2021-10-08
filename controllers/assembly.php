<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class Assembly extends  User_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
       
        $this->load->library('form_validation');
        $this->load->model('assembly_model');
		 $this->load->model('maintenance_model');
       $this->message="";
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
			case 'adddata':
                $this->adddata();
                break;
            case 'orderstock':
                $this->orderstock();
                break;
				
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Order Manage';
        $data['action'] = site_url('assembly/adddata');
		//$data['stock'] = $this->assembly_model->catagory_by_stock(24)->result();
        $data['coustomer'] = $this->assembly_model->get_all()->result();
	 
	   $data['message']=null;
	   $this->template->write_view('content','assembly_order',array('data'=>$data,'error'=>$error,'title'=>$title));
       $this->template->render();

    }
	public function order()
   {
      $order= $this->input->post('post_data');
	 
	  $data=$this->assembly_model->order($order)->result();
	  
	    echo '<td>Order:</td> <td style="padding-left:55px;"> <select onchange="orderinfo()"  id="ord" name="order">';  
        foreach($data as $ord)
        echo "<option value='". $ord->id ."'>". $ord->order_name ."</option>";
        echo '</select> </td>'; 
	 }
	 public function orderdetail()
   {
       $ord= $this->input->post('post_data');
	  $orderdetails=$this->assembly_model->orderinfo($ord)->result();
	  
	    echo '<p>Product: <span style="padding-left:35px;"> <select id="product" name="product"></span>';  
        foreach($orderdetails as $orderdetail)
        echo "<option value='". $orderdetail->detail_id ."'>". $orderdetail->name."</option>";
        echo '</select> </p>';
		
		echo '<p>Size:<span style="padding-left:60px;"> <select id="Size" name="Size"></span>';  
         echo "<option value='Inch'>Inch</option>";
        echo "<option value='CM'>CM</option>";
        echo '</select></p> ';
  
  }	 
public function orderstock()
{
  $type = $this->input->post('post_data');
  $data['stock'] = $this->assembly_model->catagory_by_stock($type)->result();

}

public function totaldata($total)
{
       if( $total==24)
		return true;
		else if( $total==25)
		return true;
		else if( $total==26)
		return true;
		
		else if( $total==27)
		return true;
		else if( $total==28)
		return true;
		else if( $total==30)
		return true;
		else if( $total==32)
		return true;
		else if( $total==34)
		return true;
		else if( $total==36)
		return true;
		else if( $total==38)
		return true;
		else if( $total==40)
		return true;
		else if( $total==42)
		return true;
		else if( $total==44)
		return true;
		else if( $total==46)
		return true;
		else if( $total==48)
		return true;
		else if( $total==50)
		return true;
		else
		return false;


}
public function adddata()
{  
      
	  $offset=6*60*60; //converting 5 hours to seconds.
	  $dateFormat="d-m-y H:i";
	  $timeNdate=gmdate($dateFormat, time()+$offset);
	  $temptime=strtotime($timeNdate);
	  $newdate=date("d-m-y",$temptime);
	  if( $this->input->post('Size')=='CM')
	  {$length= $this->input->post('length')/2.54;
       $width = $this->input->post('width')/2.54;
       $height = $this->input->post('height')/2.54;
	  }
	  else
	  {$length= $this->input->post('length');
       $width = $this->input->post('width');
       $height = $this->input->post('height');
	  }

        $stockmanage =array(
		
            'carton' => $this->input->post('carton'),
            'length' => $length,
            'width' => $width,
            'height' => $height,
            'ply' => $this->input->post('ply'),
			'lin' => $this->input->post('lin'),

			'Jute Twine' => $this->input->post('JuteTwine'),
			'Ink' =>$this->input->post('ink'),
			
			'Stitching Wire' =>$this->input->post('StitchingWire')
        ); 
		if( $this->input->post('Size')=='CM')
	  		$total=$stockmanage['width']+$stockmanage['height']+(3/2.54);
	    else
           $total=$stockmanage['width']+$stockmanage['height']+3;
	   
		//$total=round($total);
		$total=$this->input->post('rollsize');
		/* for($count=1;$count<=5;$count++)
		    {
			   $total=$total*$count;
			   for($x=0;$x<=2;$x=$x+0.5)
			   {
		        $result=$this->totaldata($total+$x);
				if($result==true)
				{
				  $total=$total+$x;
				 
				  
				  $stockcheck=$this->productmake($stockmanage,$total,$newdate);
				  if ($stockcheck==false)
				  {
				  $this->message .= '<p class="success">Stock Over</p>';
				  }
				  else if ($stockcheck==true)
				  {
				   $count=6;
				   break;
				  }
				}
			   }
			  
		    }  */
			 $stockcheck=$this->productmake($stockmanage,$total,$newdate);
			if ($stockcheck==false)
				  {
				  $this->message .= '<p class="success">Stock Over</p>';
				  }
				  
		$data['message']=$this->message ;
		$data['action'] = site_url('assembly/adddata');
        $data['name'] = '';
        $error = null;
        $title = 'Assembly Information';
		
        $data['coustomer'] = $this->assembly_model->get_all()->result();
	 
        $this->template->write_view('content','assembly_order',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
		
     
}		
public function productmake($stockmanage,$total,$newdate)
{
 $silicateGum=$this->input->post('silicateGum');
	   $aicaGum=$this->input->post('aicaGum');
	   $board=$this->input->post('board');
	   $number= $this->input->post('number');
$lineunit = $this->maintenance_model->get_by_Catgoryname("Line unit")->row();
		$crogated = $this->maintenance_model->get_by_Catgoryname("Crogated")->row();
		$straight = $this->maintenance_model->get_by_Catgoryname("Straight")->row();
		$wastagewid = $this->maintenance_model->get_by_Catgoryname("wastage wid")->row();
		$wastagelen = $this->maintenance_model->get_by_Catgoryname("wastage len")->row();
		//$linerprice = $this->maintenance_model->get_by_Catgoryname("liner price")->row();
		//$mideumpric = $this->maintenance_model->get_by_Catgoryname("mideum pric")->row();
		if( $this->input->post('Size')=='CM')
		$Dim = (2*($stockmanage['length']+$stockmanage['width']+$wastagewid->value/2.54));
		else
		$Dim = (2*($stockmanage['length']+$stockmanage['width']+$wastagewid->value));
		$NumberofLiner = $stockmanage['lin'];
		if( ($stockmanage['ply']+$stockmanage['lin'])==4 || ($stockmanage['ply']+$stockmanage['lin'])==5)
		$NoofcorogatedLayer = 1;
		 else if( ($stockmanage['ply']+$stockmanage['lin'])==6 || ($stockmanage['ply']+$stockmanage['lin'])==7)
		$NoofcorogatedLayer = 2;
		else if( ($stockmanage['ply']+$stockmanage['lin'])==8 || ($stockmanage['ply']+$stockmanage['lin'])==9)
		$NoofcorogatedLayer = 3;
		
		
		
		if( ($stockmanage['ply']+$stockmanage['lin'])==4)
		$noofstraightlayer =1; 
		else if( ($stockmanage['ply']+$stockmanage['lin'])==5)
		$noofstraightlayer =0;
		else if( ($stockmanage['ply']+$stockmanage['lin'])==8)
		$noofstraightlayer =3;
		else if( ($stockmanage['ply']+$stockmanage['lin'])==7)
		$noofstraightlayer =1;
		else if( ($stockmanage['ply']+$stockmanage['lin'])==6 || ($stockmanage['ply']+$stockmanage['lin'])==9)
		$noofstraightlayer =2;
		
		
        
		
		
		$usage_of_Lin_per_unit_in_kg= (($Dim*$total*$lineunit->value*$this->input->post('lin'))/1560000)/$number; 
		$usage_of_Linner_per_unit_in_kg=number_format($usage_of_Lin_per_unit_in_kg,2);
		$usage_of_Mideum_per_Unit_in_Kg= (  $NoofcorogatedLayer *$crogated->value)+($noofstraightlayer*$straight->value);
		$usage_of_Mideum_per_Unit_in_Kg=(($usage_of_Mideum_per_Unit_in_Kg*$Dim*$total)/1560000)/$number;
	    $usage_of_Mideum_per_Unit_in_Kg= number_format($usage_of_Mideum_per_Unit_in_Kg,2);
		$total_liner=$usage_of_Linner_per_unit_in_kg*$stockmanage['carton'];
		$total_Medium=$usage_of_Mideum_per_Unit_in_Kg*$stockmanage['carton'];
	   
        $amount= $this->assembly_model->catagory_by_stock($total,"Liner")->row();
		$total_liner_remain=$amount->amount-$total_liner;
		$amount= $this->assembly_model->catagory_by_stock($total,"Medium")->row();
		
		$total_Medium_remain=$amount->amount-$total_Medium;
		$silicagumuse=0;
		if($silicateGum=="Yes")
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"Silicate Gum")->row();
		$SilicateGum = $this->maintenance_model->get_by_Catgoryname("Silicate Gum")->row();
		$silicagumuse=(($total_liner+$total_Medium)*$SilicateGum->value);
		$total_SilicateGum_remain=$amount->amount-$silicagumuse;
		}
		else
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"Silicate Gum")->row();
		$total_SilicateGum_remain=$amount->amount;
		}
		$aicagumuse=0;
		if($aicaGum=="Yes")
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"Aica Gum")->row();
		$AicaGum = $this->maintenance_model->get_by_Catgoryname("Aica Gum")->row();
		$aicagumuse=(($total_liner+$total_Medium)*$AicaGum->value);
		$total_AicaGum_remain=$amount->amount-$aicagumuse;
		}
		else
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"Aica Gum")->row();
		
		$total_AicaGum_remain=$amount->amount;
		}
		$boarduse=0;
		if($board=="Yes")
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"board")->row();
		$Board= $this->maintenance_model->get_by_Catgoryname("board")->row();
		$boarduse= ($Dim*$total*$Board->value)/156000;
		
		$total_Board_remain=$amount->amount-$boarduse;
		}
		else
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"board")->row();
		
		$total_Board_remain=$amount->amount;
		}
		$StitchingWire = $this->maintenance_model->get_by_Catgoryname("Stitching Wire")->row();
		$amount= $this->assembly_model->catagory_by_stock(0,"Stitching Wire")->row();
		$total_StitchingWire_remain=$amount->amount-($stockmanage['Stitching Wire']*$StitchingWire->value*$stockmanage['carton']);
		
		if($stockmanage['Jute Twine']!=null)
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"Jute Twine")->row();
		$total_JuteTwine_remain=$amount->amount-$stockmanage['Jute Twine'];
		}
		else
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"Jute Twine")->row();
		$total_JuteTwine_remain=$amount->amount;
		}
		
		if($stockmanage['Ink']!=null)
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"Ink")->row();
		$total_Ink_remain=$amount->amount-$stockmanage['Ink'];
		}
		else
		{
		$amount= $this->assembly_model->catagory_by_stock(0,"Ink")->row();
		$total_Ink_remain=$amount->amount;
		}
		
		$Flour = $this->maintenance_model->get_by_Catgoryname("Flour")->row();
		$amount= $this->assembly_model->catagory_by_stock(0,"Flour")->row();
		$total_Floor_remain=$amount->amount-((( $Dim *$NoofcorogatedLayer *$crogated->value*$stockmanage['carton'])/1000)*$Flour->value);
		
		$StarchPowder = $this->maintenance_model->get_by_Catgoryname("Starch Powder")->row();
		$amount= $this->assembly_model->catagory_by_stock(0,"Starch Powder")->row();
		$total_StarchPowder_remain=$amount->amount-((( $Dim *$NoofcorogatedLayer *$crogated->value*$stockmanage['carton'])/1000)*$StarchPowder->value);
		
		$Custic = $this->maintenance_model->get_by_Catgoryname("Custic")->row();
		$amount= $this->assembly_model->catagory_by_stock(0,"Custic")->row();
		$total_Custic_remain=$amount->amount-((( $Dim *$NoofcorogatedLayer *$crogated->value*$stockmanage['carton'])/1000)*$Custic->value);
		
		$Borax = $this->maintenance_model->get_by_Catgoryname("Borax")->row();
		$amount= $this->assembly_model->catagory_by_stock(0,"Borax")->row();
		$total_Borak_remain=$amount->amount-((( $Dim *$NoofcorogatedLayer *$crogated->value*$stockmanage['carton'])/1000)*$Borax->value);
		
		$assembly_order=array('coustomer_id' => $this->input->post('coustomer'),
            'product_id' => $this->input->post('product'),
            'order_id' => $this->input->post('order'),
			'date' => $newdate,
			'StitchingWire' =>$this->input->post('StitchingWire'),
			'carton' => $this->input->post('carton'),
			'SilicateGum' => $silicagumuse,
			'board' => $boarduse,
			'AicaGum' =>$aicagumuse,
			'JuteTwine' => $this->input->post('JuteTwine'),
			'Ink' =>$this->input->post('ink'),
			'Flour' => ((( $Dim *$NoofcorogatedLayer *$crogated->value)/1000)*$Flour->value),
			'StarchPowder' =>((( $Dim *$NoofcorogatedLayer *$crogated->value)/1000)*$StarchPowder->value),
			'Custic' => ((( $Dim *$NoofcorogatedLayer *$crogated->value)/1000)*$Custic->value),
			'Borax' =>((( $Dim *$NoofcorogatedLayer *$crogated->value)/1000)*$Borax->value),
			'liner'=>$total_liner,
			'medium'=>$total_Medium);
		 $stockcheck=true;
		  if($total_Board_remain<-0.00000001)
		   {
		   $stockcheck=false;
		   $this->message  .="<p> Board need </p>";
		   }
           if($total_liner_remain<-0.00000001)
		   {
		   $stockcheck=false;
		   $this->message  .="<p> liner need Category=".$total."</p>";
		   }
		   if($total_Medium_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Medium need Category=".$total."</p>";
		   }
		   if($total_SilicateGum_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Silicate Gum need </p>";
		   }
		   if($total_AicaGum_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Aica Gum need </p>";
		   }
		   if($total_JuteTwine_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "Jute Twine need </br>";
		   }
		   if($total_Ink_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Ink need </p>";
		   }
		   if($total_Floor_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Floor need </p>";
		   }
		   if($total_StarchPowder_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Starch Powder need </p>";
		   }
		   if($total_Custic_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Custic need </p>";
		   }
		   if($total_Borak_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Borak need </p>";
		   }
		   if($total_StitchingWire_remain<-0.00000001)
		   {
		   $stockcheck=false;
		    $this->message  .= "<p>Stitching Wire need </p>";
		   }
		   
		   
		  
		     if ($stockcheck==false) {
              
            $data['name'] = 'error';
			
            
        } elseif ($stockcheck==true) {
              $this->message  .= '<p class="success">Add Assembly Information success</p>';
			$this->assembly_model->stockupdate("Liner",$total_liner_remain,$total);
			$this->assembly_model->stockupdate("Medium",$total_Medium_remain,$total);
			$this->assembly_model->stockupdate("Silicate Gum",$total_SilicateGum_remain,0);
			$this->assembly_model->stockupdate("Aica Gum",$total_AicaGum_remain,0);
			$this->assembly_model->stockupdate("board",$total_Board_remain,0);
			$this->assembly_model->stockupdate("Stitching Wire",$total_StitchingWire_remain,0);
			$this->assembly_model->stockupdate("Jute Twine",$total_JuteTwine_remain,0);
			$this->assembly_model->stockupdate("Ink",$total_Ink_remain,0);
			$this->assembly_model->stockupdate("Flour",$total_Floor_remain,0);
			$this->assembly_model->stockupdate("Starch Powder",$total_StarchPowder_remain,0);
			$this->assembly_model->stockupdate("Custic",$total_Custic_remain,0);
			$this->assembly_model->stockupdate("Borax",$total_Borak_remain,0);
		    $this->assembly_model->save($assembly_order);
			$product= $this->assembly_model->product_update($assembly_order)->row();
			 $this->message  .= "<p>Stitching Wire ".number_format($assembly_order['StitchingWire'],8)."</p>";
			 $this->message  .= "<p>Silicate Gum ".number_format($assembly_order['SilicateGum'],8)."</p>";
			 $this->message  .= "<p>Aica Gum ".number_format($assembly_order['AicaGum'],8)."</p>";
			 $this->message  .= "<p>Board ".number_format($assembly_order['board'],8)."</p>";
			if($assembly_order['JuteTwine']!=null)
			 $this->message  .="<p>Jute Twine ".number_format($assembly_order['JuteTwine'],8)."</p>";
			if($assembly_order['Ink']!=null)
			 $this->message  .= "<p>Ink  ".number_format($assembly_order['Ink'],8)."</p>";
			 $this->message  .="<p>Flour ".number_format($assembly_order['Flour'],8)."</p>";
			 $this->message  .= "<p>Starch Powder ".number_format($assembly_order['StarchPowder'],8)."</p>";
			 $this->message  .= "<p>Custic ".number_format($assembly_order['Custic'],8)."</p>";
			 $this->message  .= "<p>Borax ".number_format($assembly_order['Borax'],8)."</p>";
			 $this->message  .= "<p>liner ".number_format($assembly_order['liner'],8)." Category ".$total."</p>";
			 $this->message  .="<p>medium ".number_format($assembly_order['medium'],8)." Category ".$total."</p>";
			
			  if(count($product)==0)
			 {
			 $product_stock=array('coustomer_id' => $this->input->post('coustomer'),
            'product_id' => $this->input->post('product'),
            'order_id' => $this->input->post('order'),
			'carton' => $this->input->post('carton'));
			 $this->assembly_model->product_update_insert($product_stock);
			 }
			 else
			 {
			 $product_stock=array('coustomer_id' => $this->input->post('coustomer'),
            'product_id' => $this->input->post('product'),
            'order_id' => $this->input->post('order'),
			'carton' => $this->input->post('carton')+$product->carton);
			$this->assembly_model->product_update_stock($product_stock);
			 }
           return   $stockcheck;

        }

  
      
		   


}
   
   
   
}
	?>
