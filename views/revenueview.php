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

        
    	  $.ajax({url:'<?php echo base_url().'index.php/revenue/table';?>',
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
              	
				var params= { coustomer_id: $("#coustomer option:selected").val(),
				 amount: $("#amount").val()
				 
				 };
      
	           
				
     
				 $.ajax({url:'<?php echo base_url().'index.php/revenue/adddata';?>',
							type:'POST',
							data: {revenue: params},
							success:function(result){
							 $("#message").html("");
							$("#message").append(result);
							
							 location.reload(); 
							
						  
							}}); 
				
	            }
           else
                {
	  
							 var params= { coustomer_id: $("#coustomer option:selected").val(),
									 amount: $("#amount").val(),
									 id: $("#id").val(),
									 date:  $("#revenuedate").val()
									};
								 $.ajax({url:'<?php echo base_url().'index.php/revenue/updatedata';?>',
											type:'POST',
											data: {revenue:params},
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
	       
	        $.ajax({url:'<?php echo base_url().'index.php/revenue/update';?>',
					 type:'POST',
					 data: {id: $(this).find("input[name='id']").val()},
					 success:function(Revenue){
					 Revenue = JSON.parse(Revenue);
				    
					 $("#coustomer ").val(Revenue.coustomer_id);
				     $("#amount").val(Revenue.amount);
					 
					 $("#id").val(Revenue.id); 
				     $("#revenuedate").val(Revenue.date); 
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
		
		       <p class="title" style="font-size: 26px;font-weight: bold;">Revenue Information</p>
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
                <td width="30%">Coustomer:</td>
				<td>
                 <input type="hidden"   id="id" size="40" value="" />				
				  <select  id="coustomer" >
						   <?php
							foreach($data['coustomer'] as $cus)	   
						   
							echo "<option value='". $cus->CoustomerId ."'>". $cus->CoustomerName ."</option>";
							?>
				   </select>
             		
				<td>
			</tr>
			 
			 <tr>
                <td width="30%">Amount:</td>
				<td>
                 		
				 <input type="text"  name="amount" id="amount" size="40" value="" />
             	<input type="hidden"   id="revenuedate" size="40" value="" />
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