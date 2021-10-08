<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
 

<script>
$(document).ready(function(){
$("#amount").keydown(function(event) {
numbervalidpoint(event);
});

   $( "#date" ).datepicker({ changeYear: true,
changeMonth: true,
dateFormat:"yy-mm-dd"
 });
$('#date').change(function() { 

        
    	  $.ajax({url:'<?php echo base_url().'index.php/supplier_payment/table';?>',
				type:'POST',
				data:{date:$("#date").val()}, 
				success:function(data){
				data = JSON.parse(data);
				 $("#datatable").html("");
				$("#datatable").append(data.table);
				
			  
				}}); 
});


   $("#save").click(function(){
     if( $('#amount').val().trim()=='')
		{
		    $('#message').html(" Amount require");
				
		}
	else {

  if( $("#id").val()=="")
  {       
              	
				var params= {supplier_id: $("#supplier option:selected").val(),
				 amount: $("#amount").val()
				 
				};
      
	           
				
     
	 $.ajax({url:'<?php echo base_url().'index.php/supplier_payment/adddata';?>',
				type:'POST',
				data: {supplier: params},
				success:function(result){
				 $("#message").html("");
				$("#message").append(result);
				
				 location.reload(); 
				
			  
				}}); 
				
	}
else
     {
	    
	  
	 	 var params= { supplier_id: $("#supplier option:selected").val(),
				 amount: $("#amount").val(),
				 id: $("#id").val(),
				 date:  $("#supplierdate").val()
				};
     $.ajax({url:'<?php echo base_url().'index.php/supplier_payment/updatedata';?>',
				type:'POST',
				data: {supplier:params},
				success:function(result){
				
			         $("#message").html("");
				    $("#message").append(result);
					$("#amount").val("");
				    
					 $("#id").val(""); 
				 	location.reload();
				}});   
					 
      

    }	
	 
	 }
   });
        $("#datatable").on('click','table tr td:nth-child(5)',function(){
	         
	         $.ajax({url:'<?php echo base_url().'index.php/supplier_payment/update';?>',
					 type:'POST',
					 data: {id: $(this).find("input[name='id']").val()},
					 success:function(supplier){
					 
					 supplier = JSON.parse(supplier);
				    
					  $("#supplier").val(supplier.supplier_id);
				     $("#amount").val(supplier.amount);
					 
					 $("#id").val(supplier.id); 
				     $("#supplierdate").val(supplier.date); 
					 }}); 
	   

        });
   

 });
  
 function numbervalidpoint(event)
{

if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39 ||event.keyCode==110 )) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
}
 </script>
  <style type="text/css">
table td, table th {
    font-size: 1.2em;
   
}
 </style>
</head>
<body>
   
   <div style="width: 100%;margin: 20px auto;">
            <ul class="nav nav-pills">
                <li><a href="/cash_in_hand/index" class="btn btn-actions">Treasure </a></li>
                <li><a href="/bank/index" class="btn btn-actions">Bank Information</a></li>
                <li><a href="/revenue/index/" class="btn btn-actions">Revenue</a></li>
                <li><a href="/expense/index" class="btn btn-actions">Expense</a></li>
				<li><a href="/supplier_payment/index" class="btn btn-actions">Supplier Payment</a></li>
				<li><a href="/salary/index" class="btn btn-actions">Salary Register</a></li>
            </ul>

        </div>
        <div class="content" style="float:left">
		   
		       <p class="title" style="font-size: 26px;font-weight: bold;">Supplier Payment Information</p>
               <p style="margin-left:10px;">Date: <input id="date" type="text" name="date"  size="40"  readonly="readonly"/></p>
              <div class="data" id="datatable" style="width:500px"><?php echo $data['table']; ?></div>
		      
        

            </div>
        <div class="data" style="padding:60px 0 0 520px;" >
		<div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp</span>
                
            </div>
        <table id="table">
             <tr>
                <td width="30%">Supplier:</td>
				<td>
                 <input type="hidden"   id="id" size="40" value="" />				
				  <select  id="supplier" >
						   <?php
							foreach($data['supplier'] as $sup)	   
						   
							echo "<option value='". $sup->id ."'>". $sup->supplier_name ."</option>";
							?>
				   </select>
             		
				<td>
			</tr>
			 
			 <tr>
                <td width="30%">Amount:</td>
				<td>
                 		
				 <input type="text"  name="amount" id="amount" size="40" value="" />
             	<input type="hidden"   id="supplierdate" size="40" value="" />
				<td>
			</tr>
			<tr>
			<td width="30%"></td>
			<td>
			  <input type="button"  name="Save"  id="save"  value="save" class="btn btn-primary" />
			  </td>
			<tr/>
			
        </table>
        
    </div>

</body>

</html>