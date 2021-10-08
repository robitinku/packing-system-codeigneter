<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
   
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->

<link rel="stylesheet" href="/resources/demos/style.css" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="/resources/demos/external/jquery.mousewheel.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


    <style type="text/css">
        
    
        .spninerwidth
        {
            width: 25px;
        }
		table {
			margin: 0 15px;
		}
		table td, table th {
			font-size: 1.2em;
			padding: 3px 7px 2px;
		}

        </style>
<script>
$(function() {
$( "#spinnerh" ).spinner({ max: 23,min:0});
$( "#spinnerm" ).spinner({ max: 59,min:0});
$( "#spinneroh" ).spinner({ max: 23,min:0});
$( "#spinnerom" ).spinner({ max: 59,min:0});
});

</script>

</head>
<body>
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

	 <p class="title" style="font-size: 26px;font-weight: bold;">Daily Attendance </p>
       <?php if(!empty($data['message'])) : ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $data['message']; ?>
            </div>
            <?php endif; ?>
        <form method="post" action="<?php echo $data['action']; ?>" >
        <div class="data">
		<input type="hidden" name="id" value="<?php echo $this->form_validation->Id;?>"/>
        <table id="table">
          <tr>
                <td width="40%">Employee Name:</td>
				<td>
			          <input type="text" disabled="disabled" name="EmployeeName"  size="40" value="<?php echo $this->form_validation->Name; ?>"/>
           

				
				<td>
			</tr>
         <tr>
                <td width="40%">Department:</td>
				<td>
			          <input type="text" disabled="disabled" name="Department"  size="40" value="<?php echo $this->form_validation->Department; ?>"/>

					
				<td>
			</tr>
			
			 <tr>
                <td width="40%">Designation:</td>
				<td>
                    <input type="text"  disabled="disabled" name="Designation"  size="40" value="<?php echo $this->form_validation->Designation; ?>"/>

				
				<td>
			</tr>
		
             
			 <tr>
                <td width="40%">Personal Id</td>
				<td>
			          <input type="text" disabled="disabled" name="personalid"  size="40" value="<?php echo $this->form_validation->personalId; ?>"/>

					
				<td>
			</tr>
			<tr><td>Shift:</td><td><select id="shift" style="Width:60px;" name="shift" > <option <?php if($this->form_validation->shift == "A" ){ echo "selected='selected' " ;} ?> value="A">A</option>
			<option value="B" <?php if($this->form_validation->shift == "B" ){ echo "selected='selected' "; } ?>>B</option>
			<option value="C" <?php if($this->form_validation->shift == "C" ){ echo "selected='selected' "; } ?>>C</option></select></td></tr>
				 <tr>
                <td width="40%">In Time:</td>
				<td>
			          <input  readonly="readonly" class="spninerwidth" id="spinnerh" name="inhour"  value="<?php echo $this->form_validation->inhour; ?>"/>:
                      <input  readonly="readonly" class="spninerwidth" id="spinnerm" name="inmin"  value="<?php echo $this->form_validation->inmin; ?>"/>
				<td>
			</tr>
            <tr>
                <td width="40%">Out Time:</td>
                <td>
                    <input  readonly="readonly" class="spninerwidth" id="spinneroh" name="outhour"  value="<?php echo $this->form_validation->outhour; ?>"/>:
                    <input  readonly="readonly" class="spninerwidth" id="spinnerom" name="outmin"  value="<?php echo $this->form_validation->outmin; ?>"/>
                <td>
            </tr>
			<tr>
			
                <td align="center" ><input type="submit" value="Save" class= "btn btn-primary"/></td>
				<td> <?php echo $data['link_back']; ?><td>
            </tr>
        </table>
        </div>
		
		
        </form>
       
     
        
    </div>

</body>

</html>