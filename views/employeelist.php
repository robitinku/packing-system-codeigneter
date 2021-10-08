
<link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
  .paging li
 {
 display:block ;
 float:left;
 padding-left:5px;

 }
 .paging
 {
  margin:5px 0px 0px 10px;
 }
 </style>

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
        <p class="title" style="font-size: 26px;font-weight: bold;">Employee Information</p>

        <p class="title"><?php echo anchor('employee/add/','Add New Employee',array('class'=>'btn btn-success')); ?></p>
   
        <div class="data" style="width: 98%;"><?php echo $data['table']; ?></div>
		<div style="margin-left: 10px;" class="pagination"><?php echo $data['pagination']; ?></div>
        

    </div>