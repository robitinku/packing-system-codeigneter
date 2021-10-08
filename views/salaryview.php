<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
  .content
 {
 margin: 20px 0px 0 100px;

 }

table
 {
 
margin:0 15px 0 15px;
 
 }
table td, table th {
   
    font-size: 1.2em;
    padding: 3px 7px 2px;
}
 </style>

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
$(document).ready(function(){
  $("#department").change(function(){
    post_data=$("#department option:selected").val();
    $.ajax({url:'<?php echo base_url().'index.php/salary/employee';?>',
	type:'POST',
	data: {post_data: post_data},
	success:function(result){
      $("#Employee").html(result);
	  empinfo();
	  //alert(result);
    }});
  }).change();
 
  
  
});
function save()

{
	
var params= {
	             salary: $("#salary").text(),
				 food_allowance: $("#food").text(),
				 month: $("#month").text(),
				 year: $("#year").text(),
				 overtime: $("#overtime").text(),
				 chour:  $("#chour").text(),
				 employee_id:$("#Emp option:selected").val()
				 
				};
      
	   
 
 
    $.ajax({url:'<?php echo base_url().'index.php/salary/save';?>',
	type:'POST',
	data: {salary: params},
	success:function(result){
    alert(result);
    }});

}
function bonus()
{
alert("RRR");
}
function empinfo()
{
  
    post_data=$("#Emp option:selected").val();
    $.ajax({url:'<?php echo base_url().'index.php/salary/empinfo';?>',

	type:'POST',
	data: {post_data: post_data},
	success:function(result){
      $("#empdes").html(result);

    }});

}

</script>
 
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
    <div class="content" >
      
      <p class="title" style="font-size: 26px;font-weight: bold;">Salary Register</p>
        <div >
		 <table width=55%>

           <tr>
		   <td>Month </td> <td id="month"><?php echo $data['month']; ?> </td> <td >Year </td> <td id="year"><?php echo $data['year']; ?></td> 
		   </tr>

          <tr>
                <td >Department:</td>
				<td>
			          <select  id="department" >
						   <?php
							foreach($data['department'] as $dep)	   
						    
							echo "<option value='". $dep->id ."'>". $dep->department ."</option>";
							?>
				   </select>
				</td>
			</tr>
         <tr id="Employee">
              
			</tr>

			
			
	</table>
		<table id="empdes">

			</table>
		
		
</div>
      
</div>
</body>
</html>