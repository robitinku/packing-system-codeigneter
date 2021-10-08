<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
 <style type="text/css">

table
 {
 
margin:0 15px 0 15px;
 
 }
table td, table th {
   
    font-size: 1.2em;
    padding: 3px 7px 2px;
}
 </style>

<script>
$(document).ready(function(){
  $("#department").change(function(){
   post_data=$("#department option:selected").val();
    $.ajax({url:'<?php echo base_url().'attendance/employee';?>',
	type:'POST',
	data: {post_data: post_data},
	success:function(result){
      $("#Employee").html(result);
	  empinfo();
	  //alert(result);
    }}); 

  }).change();
  $( "#username" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $( "#password" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
$( "#repassword" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $("#save").click(function(){
  if( $('#username').val().trim()=='')
{
 $('#username').closest('tr').find('span').html("User Name require");

}
else if( $('#password').val().trim()=='')
{
 $('#password').closest('tr').find('span').html("Password require");

}
else if( $('#password').val().length <8)
{
 $('#password').closest('tr').find('span').html("Password Must Be 8 Digit");

}
else if( $('#password').val()!=$('#repassword').val())
{
 $('#repassword').closest('tr').find('span').html("Password Not Match");

}
else {
var params= {
	             email: $("#username").val(),
				 passwd: $("#password").val(),
				 status:$('input[name=Status]:checked').val(),
				 emp_id:$("#Emp option:selected").val(),
				 category:$("#category option:selected").val()
				 
				};
				
      $.ajax({url:'<?php echo base_url().'usermanagement/adddata';?>',

	type:'POST',
	data: {params: params},
	success:function(result){
	   if(result!="User Name already exist")
	   {
	   $("#username").val("");
		$("#password").val("");
		$("#repassword").val("");
	   }
      $("#message").html(result);
      
    }});


}

});
});

function empinfo()
{
  
    post_data=$("#Emp option:selected").val();
    $.ajax({url:'<?php echo base_url().'usermanagement/empinfo';?>',

	type:'POST',
	data: {post_data: post_data},
	success:function(result){
      $("#empdes").html(result);
     // alert(result);
    }});

}
</script>
 
</head>
<body>
    <div class="content" >
            <div style="width: 98%;margin: 20px auto;">
            <ul class="nav nav-pills">
                <li><a href="/usermanagement/index" class="btn btn-actions">User Management</a></li>
                
            </ul>

        </div>

      
        <div class="data">
		<p class="title" style="font-size: 26px;font-weight: bold;">Add User</p>
		<div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp</span>
                
            </div>
		 <table>



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
			<table >
			<tr>
                <td >Category:</td>
				<td>
			          <select  id="category" >
						   <option value="super">super</option>
						   <option value="user">user</option>
				   </select>
				</td>
			</tr>

<tr><td>User Name:</td><td>
	 <input type="text" id="username"/><br/>
    <span class="error"></span></td><tr>
    <tr><td>Password:</td><td>
	<input type="password" id="password"/><br/>
	<span class="error"></span></td><tr>
	<tr>
	<tr><td>Re-Password:</td><td>
	<input type="password" id="repassword"/><br/>
	<span class="error"></span></td><tr>
	<tr>
                <td >Status:</td>
				<td>
				  <input type="radio" name="Status" value="Active" checked="checked"  /> Active
                <input type="radio" name="Status" value="Inactive" /> Inactive<br/>
				
				</td>
			</tr>
		<tr>
                <td align="center" ><input type="submit" value="Save" class="btn btn-primary" id="save" /></td>
				<td> <?php echo $data['link_back']; ?><td>
            </tr>
		</table>

		
</div>
      
</div>
</body>
</html>