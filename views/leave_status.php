<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
  .content
 {
 margin: 20px 0px 0 10px;

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
    $.ajax({url:'<?php echo base_url().'index.php/leave_view/employee';?>',
	type:'POST',
	data: {post_data: post_data},
	success:function(result){
      $("#Employee").html(result);
	  empinfo();
	  //alert(result);
    }});
  }).change();
 
  
  
});


function empinfo()
{
  
    post_data=$("#Emp option:selected").val();
    $.ajax({url:'<?php echo base_url().'index.php/leave_view/empinfo';?>',

	type:'POST',
	data: {post_data: post_data},
	success:function(result){
	 var tem=jQuery.parseJSON(result);
	   $("#table").html("");
      $("#table").append(tem);
     
    
    }});

}

</script>
 
</head>
<body>
    <div class="content" >
       <div style="width: 98%;margin: 20px auto;">
            <ul class="nav nav-pills">
                <li><a href="/employee/index" class="btn btn-actions">Employee Manager</a></li>
                <li><a href="/attendance/index" class="btn btn-actions">Attendance</a></li>
                <li><a href="/attendanceedit/index" class="btn btn-actions">Attendance Update</a></li>
				<li><a href="/attendance_timecard/index" class="btn btn-actions">Attendance Timecard</a></li>
                <li><a href="/leave/index" class="btn btn-actions">Leave</a></li>
				<li><a href="/leave_view/index" class="btn btn-actions">Leave View</a></li>
            </ul>

        </div>

      
        <div >
		 <p class="title" style="font-size: 26px;font-weight: bold;">Leave Status </p>
		 <table >

           
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
	</div>
	  <div class="data" id="table" style="width: 98%;"></div>
		
		

      
</div>
</body>
</html>