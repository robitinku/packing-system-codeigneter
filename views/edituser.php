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
  if( $('#curPassword').val().trim()=='')
{
 $('#curPassword').closest('tr').find('span').html("Give Current Password");

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
	             curPassword: $("#curPassword").val(),
				 passwd: $("#password").val(),
				 status:$('input[name=Status]:checked').val(),
				 user_id:$("#user_id").val()
				 
				};
      $.ajax({url:'<?php echo base_url().'usermanagement/updatedata';?>',

	type:'POST',
	data: {params: params},
	success:function(result){
	   if(result!="Current Password Not Correct")
	   {
	   $("#curPassword").val("");
		$("#password").val("");
		$("#repassword").val("");
	   }
      $("#message").html(result);
	  
      
    }});


}

});
});


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
		<p class="title" style="font-size: 26px;font-weight: bold;">Edit User</p>
		<div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp</span>
                
            </div>
			<input type="text" id="user_id" style="display:none;" value="<?php echo $data['user_id']; ?>"/>
					<table >
<tr><td>Current Password:</td><td>
	 <input type="password" id="curPassword"/><br/>
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
<?php  if( $data['user']=='Active'){?>
			    <input type="radio" name="Status" value="Active"  checked="checked"/> Active
                <input type="radio" name="Status" value="Inactive"/> Inactive<br/>
				<?php } else if( $data['user']=='Inactive'){?>
                 <input type="radio" name="Status" value="Active"  /> Active
                <input type="radio" name="Status" value="Inactive" checked="checked"/> Inactive<br/>
				<?php }?>
				
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