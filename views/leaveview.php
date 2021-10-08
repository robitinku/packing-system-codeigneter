

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<script>
$(document).ready(function(){


  $("#department").change(function(){
    post_data=$("#department option:selected").val();
    $.ajax({url:'<?php echo base_url().'leave/employee';?>',
	type:'POST',
	data: {post_data: post_data},
	success:function(result){
      $("#Employee").html(result);
	  empinfo();
	  //alert(result);
    }});
  }).change();

 
  
});

function numbervalid(event)
{

if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
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
function empinfo()
{
  
    post_data=$("#Emp option:selected").val();
    $.ajax({url:'<?php echo base_url().'leave/empinfo';?>',

	type:'POST',
	data: {post_data: post_data},
	success:function(result){
      $("#empdes").html(result);
      time();
    }});

}
function valid(){


if( $('#fromdate').val().trim()=='')
{
 $('#message').html("fromdate  require");
return false;
}

else if( $('#todate').val().trim()=='')
{
 $('#message').html("todate require");
return false;
}
else if( $('#days').val().trim()=='')
{
 $('#message').html("day require");
return false;
}
else
return true;
}

function time()
{
$("#fromdate" ).datepicker({ changeYear: true,
changeMonth: true
 });
 
 $("#todate" ).datepicker({ changeYear: true,
changeMonth: true
 });
 $("#days").keydown(function(event) {
numbervalid(event);
});
}
function intime()
{  var res=valid();
    if(res==true)
	{
		   $.ajax({url:'<?php echo base_url().'leave/leaveadd';?>',
		   
			type:'POST',
			data: {empid:$("#Emp option:selected").val(),
				   fromdate:$("#fromdate").val(),
				   todate:$("#todate").val(),
				   day:$("#days").val(),
				   note:$("#note").val()
				   },
			success:function(result1){
			$("#message").html(result1);
			  $("#in").attr("disabled", "disabled");
			 

			}});
	}
}


</script>

<style>

table {
    margin: 0 15px;
}
table td, table th {
    font-size: 1.2em;
    padding: 3px 7px 2px;
}
 </style>


    <div class="content" style="">
      
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

        <div class="data">
		<p class="title" style="font-size: 26px;font-weight: bold;"> Leave Information </p>
		<div style="width: 80%;margin: 10px auto;">
            
            <div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp</span>
                
            </div>
            
		</div>
		 <table>



          <tr>
                <td >Department:</td>
				<td style="padding-left:20px;">
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
