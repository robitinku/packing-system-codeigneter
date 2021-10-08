 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />




 <style type="text/css">
  .content
 {
 margin: 20px 0px 0 100px;

 }
 #message
 {
 padding-left:150px;
 color:#00FF00;
 padding-bottom:10px;
 
 }
 .data
 {
 float:left;
 }
 #imageshow
 {
 float:left;
 border:1px solid #000000;
 height:188px;
 width:250px;
 margin-left:50px;
 }
 #imagebutton
 {
 float:left;
 margin-left:50px;
 margin-top:5px;
 }
 #table td
 {

 }
 </style>
    
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

       <div class="content">
<p class="title" style="font-size: 26px;font-weight: bold;">Employee Information</p>
        <div class="data">
		
        <table id="table">
          <tr>
                <td width="40%">Employee Name:</td>
				<td>
			          <input type="text" disabled="disabled" name="EmployeeName"  size="40"  value="<?php echo $this->form_validation->Name; ?>"/>
           
             		
				<td>
			</tr>
         <tr>
                <td width="40%">Department:</td>
				<td>			         
				 <input type="text" disabled="disabled"  name="Department"  size="40" value="<?php echo $this->form_validation->department; ?>" />
             		
				<td>
			</tr>
			
			 <tr>
                <td width="40%">Designation:</td>
				<td>
			         <input type="text" disabled="disabled"  name="Designation"  size="40" value="<?php echo $this->form_validation->Designation; ?>" />
             		
				<td>
			</tr>
		  <tr>
                <td width="40%">Joining Date</td>
				<td>
			   <input id="date"  disabled="disabled" type="text" name="date"  size="40" value="<?php echo $this->form_validation->joiningdatedate ; ?>" />
             		
				<td>
			</tr>
               <tr>
                <td width="40%">Salary</td>
				<td>
			          <input type="text" disabled="disabled"  name="salary"  size="40" value="<?php echo $this->form_validation->Salary ; ?>" />
             		
				<td>
			</tr>
			 <tr>
                <td width="40%">Address</td>
				<td>
			       <textarea  name="address"   rows="6" cols="30" readonly="readonly"><?php echo $this->form_validation->Address; ?></textarea>
             	
				<td>
			</tr>
			 <tr>
                 <td width="40%">Phone Number</td>
				<td>
			          <input type="text" disabled="disabled" name="Phone"  size="40" value="<?php echo $this->form_validation->PhoneNum; ?>"/>
             	<td>
			</tr>
			 <tr>
                <td width="40%">Age</td>
				<td>
			          <input type="text" disabled="disabled" name="age"  size="40" value="<?php echo $this->form_validation->age; ?>"/>
             		
				<td>
			</tr>
			
			 <tr>
                <td width="40%">Personal Id</td>
				<td>
			          <input type="text" disabled="disabled"  name="personalid"  size="40" value="<?php echo $this->form_validation->personalId; ?>"/>
             		
				<td>
			</tr
            <tr>
                <td width="40%">Leave</td>
				<td>
			          <input type="text" disabled="disabled"  name="leave"  size="40" value="<?php echo $this->form_validation->leave; ?>"/>
             		
				<td>
			</tr
			
			 <tr>
                <td width="40%">Status</td>
				<td>
			    <input type="text" disabled="disabled"  name="Status" value="<?php echo $this->form_validation->active; ?>" /> 
             

				</td>
			</tr>
		 <tr>
                <td width="40%">Notes:</td>
				<td>
			          <textarea  name="Notes"   rows="6" cols="30" readonly="readonly"><?php echo $this->form_validation->Note; ?></textarea>
             		
				<td>
			</tr>
            <tr>
                <td align="center" ></td>
				<td> <?php echo $data['link_back']; ?><td>
            </tr>
        </table>
        </div>
		
		<div id="imageshow">
	
			<img  id="image" src="<?php echo $this->form_validation->image; ?>" alt=""  width="250" height="200"/>
		
        </div>
		
        
    </div>