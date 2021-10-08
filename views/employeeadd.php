 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script>
$(function() {
$( "#date" ).datepicker({ changeYear: true,
changeMonth: true,

 });
 
 $( "#EmployeeName" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $( "#address" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
$( "#date" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $( "#Designation" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});

$( "#Salary" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $( "#personalid" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});

$( "#leave" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $( "#age" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});

$("#Salary").keydown(function(event) {
numbervalid(event);
});
 $("#age").keydown(function(event) {
numbervalid(event);
});
$("#leave").keydown(function(event) {
numbervalid(event);
});
$("#phone").keydown(function(event) {
phonevalid(event);
});
});

function phonevalid(event)
{

if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39 ||event.keyCode ==107 ||event.keyCode ==109 )) {
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
function valid(){


if( $('#EmployeeName').val().trim()=='')
{
 $('#EmployeeName').closest('tr').find('span').html("Name require");
return false;
}

else if( $('#address').val().trim()=='')
{
 $('#address').closest('tr').find('span').html("Address require");
return false;
}
else if( $('#date').val().trim()=='')
{
 $('#date').closest('tr').find('span').html("Date require");
return false;
}
else if( $('#Designation').val().trim()=='')
{
 $('#Designation').closest('tr').find('span').html("Designation require");
return false;
}
else if( $('#Salary').val().trim()=='')
{
 $('#Salary').closest('tr').find('span').html("Salary require");
return false;
}
else if( $('#personalid').val().trim()=='')
{
 $('#personalid').closest('tr').find('span').html("Personal id require");
return false;
}
else if( $('#leave').val().trim()=='')
{
 $('#leave').closest('tr').find('span').html("Leave require");
return false;
}
else if( $('#age').val().trim()=='')
{
 $('#age').closest('tr').find('span').html("Age require");
return false;
}
else
return true;
}
</script>


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
<?php if(!empty($data['message'])) : ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $data['message']; ?>
            </div>
            <?php endif; ?>
        
        <form method="post" action="<?php echo $data['action']; ?>" enctype="multipart/form-data" onSubmit="return  valid()">
        <div class="data">
		<input type="hidden" name="EmployeeId" value="<?php echo $this->form_validation->EmployeeId;?>"/>
        <table id="table">
          <tr>
                <td width="40%">Employee Name:</td>
				<td>
			          <input type="text" name="EmployeeName" id="EmployeeName"  size="40" value="<?php echo $this->form_validation->Name; ?>"/>
           
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
         <tr>
                <td width="40%">Department:</td>
				<td>
                     <select  id="Department" name="Department">
						   <?php
							foreach($data['department'] as $dep)	   
						   {
							echo "<option value='" .$dep->id."'" ;
							if($this->form_validation->Department ==$dep->id ) echo "selected='selected'"; 
							echo ">" .$dep->department ."</option>";
							}
							?>
				   </select>
				<td>
			</tr>
			
			 <tr>
                <td width="40%">Designation:</td>
				<td>
			          <input type="text"  name="Designation" id="Designation"  value="<?php echo $this->form_validation->Designation; ?>"/>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
		  <tr>
                <td width="40%">Joining Date</td>
				<td>
			    <input id="date" type="text" name="date"  size="40" value="<?php echo $this->form_validation->joiningdatedate; ?>" readonly="readonly"/>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
               <tr>
                <td width="40%">Salary</td>
				<td>
			          <input type="text" name="salary" id="Salary" size="40" value="<?php echo $this->form_validation->Salary; ?>"/>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
			 <tr>
                <td width="40%">Address</td>
				<td>
			       <textarea  name="address" id="address"  rows="6" cols="30"><?php echo $this->form_validation->Address; ?></textarea>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
			 <tr>
                 <td width="40%">Phone Number</td>
				<td>
			          <input type="text" name="Phone" id="phone" size="40" value="<?php echo $this->form_validation->PhoneNum; ?>"/>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
			 <tr>
                <td width="40%">Age</td>
				<td>
			          <input type="text" name="age" id="age" size="40" value="<?php echo $this->form_validation->age; ?>"/>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
			
			 <tr>
                <td width="40%">Personal Id</td>
				<td>
			          <input type="text" name="personalid" id="personalid"  size="40" value="<?php echo $this->form_validation->personalId; ?>"/>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
			<tr>
                <td width="40%">Leave</td>
				<td>
			          <input type="text" name="leave" id="leave" size="40" value="<?php echo $this->form_validation->leave; ?>"/>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
			 <tr>
                <td width="40%">Status</td>
				<td style="height:20px;">
				<?php if( $this->form_validation->active=='Active'){?>
			    <input type="radio" name="Status" value="Active"  checked="checked"/> Active
                <input type="radio" name="Status" value="Inactive"/> Inactive<br/>
				<?php } else if( $this->form_validation->active=='Inactive'){?>
                 <input type="radio" name="Status" value="Active"  /> Active
                <input type="radio" name="Status" value="Inactive" checked="checked"/> Inactive<br/>
				<?php }else {?>
				  <input type="radio" name="Status" value="Active" checked="checked"  /> Active
                <input type="radio" name="Status" value="Inactive" /> Inactive<br/>
				<?php }?>
				<td>
			</tr>
						 <tr>
                <td width="40%">Notes:</td>
				<td>
			          <textarea  name="Notes"   rows="6" cols="30"><?php echo $this->form_validation->Note; ?></textarea>
             		<br/>
					<span class="error"></span>
				<td>
			</tr>
            <tr>
                <td align="center" ><input type="submit" value="Save" class="btn btn-primary" /></td>
				<td> <?php echo $data['link_back']; ?><td>
            </tr>
        </table><br />
        </div>
		
		<div id="imageshow">
	
			<img  id="image" src="<?php echo $this->form_validation->image; ?>" alt=""  width="250" height="200"/>
		
        </div>
		<div id="imagebutton">
		<input type="file"  id="myfile" name="myfile" accept="image/*" >
		</div>
        </form>
       
     
        
    </div>
<script >
	function handleFileSelect(evt) {

    var files = evt.target.files; // FileList object, files[0] is your file
    var f = files[0];
    var reader = new FileReader();

    reader.onload = (function(theFile) {
       return function(e) {
	   document.getElementById("image").src= e.target.result;
           //document.getElementById('list').innerHTML = ['<img src="', e.target.result,'" title="', theFile.name, '" />'].join('');
       };
    })(f);

    reader.readAsDataURL(f);
    }

    document.getElementById('myfile').addEventListener('change', handleFileSelect, false);
</script>
