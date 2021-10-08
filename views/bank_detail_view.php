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
 $("#type").change(function(){
 post_data=$("#type option:selected").text();
  if(post_data=="Deposit")
        {
		$("#statustab").hide();
	    $("#status option:selected").val("");
		  
        }
        else{
          if($("#process option:selected").text()!="Cash")
			$("#statustab").show();
           
        }
 });

$("#process").change(function(){
        post_data=$("#process option:selected").text();
        if(post_data=="Cash")
        {
            $("#checktab").hide();
            $("#checkno").val("");
			
			$("#statustab").hide();
			$("#status option:selected").val("");
			
            
        }
        else{
            
            $("#checktab").show();
			if($("#type").val()=="Withdraw")
			$("#statustab").show();
           
           
        }


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
           	
				var params= { type: $("#type option:selected").val(),
				 date: $("#date").val(),
				 amount: $("#amount").val(),
				 bank_id: $("#bank_id").val(),
				 checkno:$("#checkno").val(),
				 process:$("#process option:selected").val(),
				 status:$("#status option:selected").val(),
				 remark: $("#remark").val(),
                                 category:$("#category option:selected").val()
				};
      
	           
				
     
	 $.ajax({url:'<?php echo base_url().'index.php/bank_detail/adddata';?>',
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
	  
	     var params= { type: $("#type option:selected").val(),
				 date: $("#date").val(),
				 amount: $("#amount").val(),
				 bank_id: $("#bank_id").val(),
				 id: $("#id").val(),
				 checkno:$("#checkno").val(),
				 remark: $("#remark").val(),
				 status:$("#status option:selected").val(),
				 process:$("#process option:selected").val(),
                                 category:$("#category option:selected").val()
				};
	 	
     $.ajax({url:'<?php echo base_url().'index.php/bank_detail/updatedata';?>',
				type:'POST',
				data: {bank:params},
				success:function(result){
				
			         $("#message").html("");
				    $("#message").append(result);
					$("#date").val("");
				    $("#amount").val("");
					//$("#bank_id").val("");
					$("#remark").val("");
					 $("#id").val(""); 
					 $("#process").val("Cash");
					$("#status option:selected").val("Release");
				 	location.reload();
				}});  
					 
      

    }	
	} 
	 
   });
        $("#datatable").on('click','table tr td:nth-child(8)',function(){
	        
	        $.ajax({url:'<?php echo base_url().'index.php/bank_detail/update';?>',
					 type:'POST',
					 data: {id: $(this).find("input[name='id']").val()},
					 success:function(bank){
					 bank = JSON.parse(bank);
					 $("#type").val(bank.type);
				     $("#date").val(bank.date);
				     $("#amount").val(bank.amount); 
				     $("#bank_id").val(bank.bank_id); 
					 $("#id").val(bank.id);
					 $("#remark").val(bank.remark);
                     $("#checkno").val(bank.checkno);
                                         $("#category").val(bank.category);
					 $("#process").val(bank.process);
					 $("#status").val(bank.status);
					 if($("#process").val()=="Check")
					 {
				      $("#checktab").show();
					  if($("#type").val()=="Withdraw")
					   $("#statustab").show();
					  }
					 else
					 {
					   $("#checktab").hide();
					     if($("#type").val()=="Withdraw")
					   $("#statustab").hide();
					  }
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
table td, table th,p {
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
           <div class="content" style="float:left;">
		  		       <p class="title" style="font-size: 26px;font-weight: bold;">Bank Information</p>
              <div class="data" id="bankinfo" style="width:750px;margin-left:10px;"><?php echo $data['info']; ?></div>
			  
              <div class="data" id="datatable" style="width:750px;overflow-x:scroll;"><?php echo $data['table']; ?></div>
		      
        

            </div>
        <div class="data" style="padding:60px 0 0 760px;" >
		<div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp</span>
                
            </div>
        <table id="table">
             <tr>
                <td width="30%">Type:</td>
				<td>
                 <input type="hidden"   id="id" size="40" value="" />				
				 <select id="type">
				 <option value="Deposit">Deposit</option>
				 <option value="Withdraw">Withdraw</option>
				 </select>
             		
				</td>
				</tr>
                                <tr>
                <td width="30%">Category:</td>
				<td>
                 <input type="hidden"   id="id" size="40" value="" />				
				 <select id="category">
				 <option value="Revenue">Revenue</option>
				 <option value="Other">Other</option>
				 </select>
             		
				</td>
				</tr>
			<tr>
				<td width="30%">Process:</td>
				<td>
                 			
				 <select id="process">
				 <option value="Cash">Cash</option>
				 <option value="Check">Check</option>
				
				 </select>
             		
				</td>
			</tr>
				<tr id="statustab" style="display:none;">
				<td  width="30%">Status:</td>
				<td>
                 			
				 <select id="status">
				 <option value="Release">Release</option>
				 <option value="Pending">Pending</option>
				<option value="Cancel">Cancel</option>
				 </select>
             		
				</td>
			</tr>
			<tr id="checktab" style="display:none;">
				<td width="30%">Check No:</td>
				<td>
                 			
				 <input type="text"  name="checkno" id="checkno" size="40" />
             		
				</td>
			</tr>
			 <tr>
                <td width="30%">Date:</td>
				<td>
                 			
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