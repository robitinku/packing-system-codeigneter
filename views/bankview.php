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





   $("#save").click(function(){
   
   if( $('#bank_name').val().trim()=='')
		{
		    $('#message').html("bank name require");
				
		}
		else if( $('#branchname').val().trim()=='')
		{
		    $('#message').html(" branch name require");
				
		}
		else if( $('#account_name').val().trim()=='')
		{
		    $('#message').html(" account name require");
				
		}
	else {

     
  if( $("#id").val()=="")
  {       
           	
				var params= { bank_name: $("#bank_name").val(),
				 branchname: $("#branchname").val(),
				 account_name: $("#account_name").val()
				 
				};
      
	           
				
     
	 $.ajax({url:'<?php echo base_url().'index.php/bank/adddata';?>',
				type:'POST',
				data: {bank: params},
				success:function(result){
				  $("#message").html("");
				$("#message").append(result);
				
				location.reload(); 
				
			  
				}}); 
				
	}
else
     {
	  
	 	 var params= { bank_name: $("#bank_name").val(),
				 branchname: $("#branchname").val(),
				 account_name: $("#account_name").val(),
				 id: $("#id").val()
				 
				};
     $.ajax({url:'<?php echo base_url().'index.php/bank/updatedata';?>',
				type:'POST',
				data: {bank:params},
				success:function(result){
				
			         $("#message").html("");
				    $("#message").append(result);
					$("#bank_name").val("");
				    $("#branchname").val("");
					$("#account_name").val("");
					 $("#id").val(""); 
				 	location.reload();
				}});  
					 
      

    }	
	 
	 }
   });
        $("#datatable").on('click','table tr td:nth-child(6)',function(){
	        
	        $.ajax({url:'<?php echo base_url().'index.php/bank/update';?>',
					 type:'POST',
					 data: {id: $(this).find("input[name='id']").val()},
					 success:function(bank){
					 bank = JSON.parse(bank);
					 $("#bank_name").val(bank.bank_name);
				     $("#branchname").val(bank.branchname);
				     $("#account_name").val(bank.account_name); 
				    
					 $("#id").val(bank.id); 
				  
					}}); 
	  

        });
   

 });
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
		   
		       <p class="title" style="font-size: 26px;font-weight: bold;">Bank Information</p>
             
              <div class="data" id="datatable" style="width:800px;overflow-x:scroll;"><?php echo $data['table']; ?></div>
		      
        

            </div>
        <div class="data" style="padding:0px 0 0 800px;" >
		<div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp</span>
                
            </div>
        <table id="table" >
             <tr>
                <td width="30%">Bank Name:</td>
				<td>
                 <input type="hidden"   id="id" size="40" value="" />				
				 <input type="text"  name="bank_name" id="bank_name" size="40" value="" />
             		
				<td>
			</tr>
			 <tr>
                <td width="30%">Branch Name:</td>
				<td>
                 			
				 <input type="text"  name="branchname" id="branchname" size="40" value="" />
             		
				<td>
			</tr>
			<tr>
                <td width="30%">Account No:</td>
				<td>
                 			
				 <input type="text"  name="account_name" id="account_name" size="40" value="" />
             		
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