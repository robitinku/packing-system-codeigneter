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
     
        if( $('#supplier_name').val().trim()=='')
		{
		    $('#message').html(" supplier name require");
				
		}
	else	if( $('#phone').val().trim()=='')
		{
		    $('#message').html(" phone number require");
				
		}
	
	else if( $('#supplier_address').val().trim()=='')
		{
		    $('#message').html(" supplier  name require");
				
		}
	
	else {
    
  if( $("#id").val()=="")
  {       
              	
				var params= { Supplier_name: $("#supplier_name").val(),
				 Supplier_address: $("#supplier_address").val(),
				 phone: $("#phone").val(),
				 status:$("input[name='status']:checked").val()
				};
      
	           
				 
     
	 $.ajax({url:'<?php echo base_url().'index.php/supplier/adddata';?>',
				type:'POST',
				data: {Supplier: params},
				success:function(result){
				$("#message").html("");
				$("#message").append(result);
				
				 $("#inactive").prop("checked", false);
				 location.reload();
			  
				}}); 
			
				
	}
else
     {
	 	var params= { Supplier_name: $("#supplier_name").val(),
				 Supplier_address: $("#supplier_address").val(),
				 phone: $("#phone").val(),
				 id: $("#id").val(),
				 status:$("input[name='status']:checked").val(),
				};
     $.ajax({url:'<?php echo base_url().'index.php/supplier/updatedata';?>',
				type:'POST',
				data: {Supplier:params},
				success:function(result){
			        $("#message").html("");
				    $("#message").append(result);
					$("#supplier_name").val("");
				    $("#supplier_address").val("");
					$("#phone").val("");
					 $("#id").val("");
					 $("#active").prop("checked", true);
				 $("#inactive").prop("checked", false);
				 	location.reload();
				}}); 
					 


    }	 
	 
	} 
   });
        $("#datatable table tr td:nth-child(6)").click(function(){
	       
	       $.ajax({url:'<?php echo base_url().'index.php/supplier/update';?>',
					 type:'POST',
					 data: {id: $(this).find("input[name='id']").val()},
					 success:function(supplier){
					 supplier = JSON.parse(supplier);
				    
				     $("#supplier_name").val(supplier.supplier_name);
				     $("#supplier_address").val(supplier.supplier_address);
					 $("#phone").val(supplier.phone);
					 $("#id").val(supplier.id); 
					 if(supplier.status=="Active")
					 $("#active").prop("checked", true)
					 else
			           $("#inactive").prop("checked", true)
				
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
   
     
           
		  <div style="width: 98%;margin: 20px auto;">
            <ul class="nav nav-pills">
                <li><a href="/meal_schedule/index/1" class="btn btn-actions">Meal Infomation</a></li>
                <!--<li><a href="/meal_schedule/index/2" class="btn btn-actions">Shift</a></li>-->
                <li><a href="/meal_schedule/index/3" class="btn btn-actions">Cost</a></li>
                <li><a href="/department/index" class="btn btn-actions">Department</a></li>
				<li><a href="/supplier/index" class="btn btn-actions">Supplier</a></li>
				<li><a href="/product/index" class="btn btn-actions">Product</a></li>
            </ul>

        </div>
		<div class="content" style="float:left">
		       <p class="title" style="font-size: 26px;font-weight: bold;">Supplier Information</p>
        
              <div class="data" id="datatable" style="width:500px;overflow-x:scroll;"><?php echo $data['table']; ?></div>
		      <div class="pagination" style="margin-left: 10px;" ><?php echo $data['pagination']; ?></div>
        

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
				 <input type="text"  name="Supplier" id="supplier_name" size="40" value="" />
             		
				<td>
			</tr>
			 <tr>
                <td width="30%">Address:</td>
				<td>
                 		
				 <textarea  name="address"  id="supplier_address" rows="6" cols="30"></textarea>
             		
				<td>
			</tr>
			 <tr>
                <td width="30%">Phone:</td>
				<td>
                 		
				 <input type="text"  name="phone" id="phone" size="40" value="" />
             		
				<td>
			</tr>
			<tr>
                <td >Status:</td>
				<td>
                <input type="radio" id="active" name="status" value="Active" checked="checked">Active
                <input type="radio" name="status" id="inactive" value="Inactive">Inactive
             		
				</td>
				
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