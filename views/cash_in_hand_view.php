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

   $("#save").click(function(){
     
         if( $('#amount').val().trim()=='')
		{
		    $('#message').html(" Amount require");
				
		}
		else if( $('#date').val().trim()=='')
		{
		    $('#message').html(" Date require");
				
		}
	else {

  if( $("#id").val()=="")
  {       
              	
				var params= { date: $("#date").val(),
				 amount: $("#amount").val(),
				 remark: $("#remark").val()
				};
                
	           
				 
     
	 $.ajax({url:'<?php echo base_url().'index.php/cash_in_hand/adddata';?>',
				type:'POST',
				data: {cih: params},
				success:function(result){
				$("#message").html("");
				$("#message").append(result);
				
				 location.reload();
			  
				}}); 
				
	}
else
     {
	 	var params= { date: $("#date").val(),
				 amount: $("#amount").val(),
				 remark: $("#remark").val(),
				 id: $("#id").val()
				};
     $.ajax({url:'<?php echo base_url().'index.php/cash_in_hand/updatedata';?>',
				type:'POST',
				data: {cih:params},
				success:function(result){
			        $("#message").html("");
				    $("#message").append(result);
					$("#date").val("");
				    $("#amount").val("");
					$("#remark").val("");
					 $("#id").val("");
				 	location.reload();
				}}); 
					 


    }	 
	 }
	 
   });
        $("#datatable table tr td:nth-child(4)").click(function(){
	  
	       $.ajax({url:'<?php echo base_url().'index.php/cash_in_hand/update';?>',
					 type:'POST',
					 data: {id: $(this).find("input[name='id']").val()},
					 success:function(chi){
					 chi = JSON.parse(chi);
				     $("#remark").val(chi.remark);
				     $("#date").val(chi.date);
				     $("#amount").val(chi.amount);
					 
					 $("#id").val(chi.id); 
				
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
		 
		       <p class="title" style="font-size: 26px;font-weight: bold;">Cash In Hand Information</p>
               <p class="title" style="font-size: 20px;font-weight: bold;color:black;">Cash:<?php echo $data['account']; ?></p>
              <div class="data" id="datatable"><?php echo $data['table']; ?></div>
		      <div class="pagination" style="margin-left: 10px;" ><?php echo $data['pagination']; ?></div>
        

            </div>
        <div class="data" style="padding:60px 0 0 520px;" >
		<div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp</span>
                
            </div>
        <table id="table">
             <tr>
                <td width="30%">Date:</td>
				<td>
                 <input type="hidden"   id="id" size="40" value="" />				
				 <input type="text"  name="date" id="date" size="40" value="" readonly="readonly"/>
             		
				<td>
			</tr>
		 
			 <tr>
                <td width="30%">Amount:</td>
				<td>
                 		
				 <input type="text"  name="amount" id="amount" size="40" value="" />
             		
				<td>
			</tr>
			  <tr>
                <td width="30%">Remarks:</td>
				<td>
                 		
				 <input type="text"  name="remark" id="remark" size="40" value="" />
             		
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