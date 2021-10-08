 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
 	
		table {
			margin: 0 15px;
		}
		table td, table th {
			font-size: 1.2em;
			padding: 3px 7px 2px;
		}

    </style>
	



<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script>

$(document).ready(function(){
  
$("#date" ).datepicker({ changeYear: true,
changeMonth: true
 });
 $("#date").change(function(){
    post_data=$("#date").val();
   // $.ajax({url:'<?php echo base_url().'attendanceedit/attendance_timecard';?>',
   $.ajax({url:'<?php echo base_url().'attendance_timecard/attendancelist';?>',
	type:'POST',
	data: {post_data: post_data},
	success:function(result){
     //alert(result);
	$("#datatable").html(result);
    }});
  });


});

</script>

    <div class="content">
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

        <div class="data" style="margin-left:20px;">
		<p class="title" style="font-size: 26px;font-weight: bold;">Daily Attendance TimeCard </p>
		Date:&nbsp;&nbsp;&nbsp;<input id="date" type="text" name="date"  size="40"  readonly="readonly"/> </div>


        <div id="datatable" class="data" style="width: 98%;"></div>
		

    </div>