
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

        
    	  $.ajax({url:'<?php echo base_url().'index.php/expense/table';?>',
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
              	
				var params= { type: $("#type option:selected").val(),
				 amount: $("#amount").val(),
				 description:$("#description").val()
				};
      
	           
				
     
	 $.ajax({url:'<?php echo base_url().'index.php/expense/adddata';?>',
				type:'POST',
				data: {expense: params},
				success:function(result){
				 $("#message").html("");
				$("#message").append(result);
				
				 location.reload(); 
				
			  
				}}); 
				
	}
else
     {
	  
	 	 var params= { type: $("#type option:selected").val(),
				 amount: $("#amount").val(),
				 id: $("#id").val(),
				 date:  $("#expensedate").val(),
				 description:$("#description").val()
				 
				};
     $.ajax({url:'<?php echo base_url().'index.php/expense/updatedata';?>',
				type:'POST',
				data: {expense:params},
				success:function(result){
				
			        $("#message").html("");
				    $("#message").append(result);
					$("#amount").val("");
				    $("#description").val(""); 
					$("#id").val(""); 
				 	location.reload();
				}});  
					 
      

    }	
	 
	} 
   });
        $("#datatable").on('click','table tr td:nth-child(6)',function(){
	       
	        $.ajax({url:'<?php echo base_url().'index.php/expense/update';?>',
					 type:'POST',
					 data: {id: $(this).find("input[name='id']").val()},
					 success:function(expense){
					 expense = JSON.parse(expense);
				    
					 $("#type ").val(expense.type);
				     $("#amount").val(expense.amount);
					 $("#description").val(expense.description); 
					 $("#id").val(expense.id); 
				     $("#expensedate").val(expense.date); 
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
		
		       <p class="title" style="font-size: 26px;font-weight: bold;">Expense Information</p>
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
                <td width="30%">Type:</td>
				<td>
                 <input type="hidden"   id="id" size="40" value="" />				
				  <select  id="type" >
						<option value='Payment'>Payment</option>  
						<option value='Factory Expense'>Factory Expense</option>
						<option value='Other Payment'>Other Payment</option>
                        <option value='Office Maintenance'>Office Maintenance</option>
					    <option value='Loan Charge Interest'>Loan/Charge/Interest</option>
						<option value='Party Payment'>Party Payment</option>
						<option value='Vehicle Expense'>Vehicle Expense</option>  
						
				   </select>
             		
				<td>
			</tr>
			  <tr>
                <td width="30%">Description:</td>
				<td>
                 		
				
             	<input type="text"   id="description" size="40" value="" />
				<td>
			</tr>
			 <tr>
                <td width="30%">Amount:</td>
				<td>
                 		
				 <input type="text"  name="amount" id="amount" size="40" value="" />
             	<input type="hidden"   id="expensedate" size="40" value="" />
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

