 <link href="/style/style.css" rel="stylesheet" type="text/css" />
 <script>
$(function() {

 
 $( "#CoustomerName" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $( "#Contract" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
$( "#billing" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $( "#City" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
 $( "#Email" ).blur(function() {
 $(this).closest('tr').find('span').html("");
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

function valid(){

   var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

if( $('#CoustomerName').val().trim()=='')
{
 $('#CoustomerName').closest('tr').find('span').html("Coustomer Name require");
return false;
}

else if( $('#Contract').val().trim()=='')
{
 $('#Contract').closest('tr').find('span').html("Contract require");
return false;
}
else if( $('#billing').val().trim()=='')
{
 $('#billing').closest('tr').find('span').html("Billing Address require");
return false;
}
else if( $('#City').val().trim()=='')
{
 $('#City').closest('tr').find('span').html("City require");
return false;
}
else if( $('#Email').val().trim()!='')
{
if( !regex.test($('#Email').val().trim()))
{
 $('#Email').closest('tr').find('span').html("Enter a valid email");
return false;
}
}

else
return true;
}
</script>
 <style type="text/css">
  .content
 {
 }
 #message
 {
 padding-left:150px;
 color:#00FF00;
 padding-bottom:10px;
 
 }
 </style>

    <div class="content">
	<div style="width: 98%;margin: 20px auto;">
        <ul class="nav nav-pills">
            <li><a href="/userpanel/index" class="btn btn-actions">Customer Manager</a></li>
			 <li><a href="/costing/index" class="btn btn-actions">Cost Management</a></li>
            <li><a href="/order_manage/index" class="btn btn-actions">Order Management</a></li>
            <li><a href="/delivery/index" class="btn btn-actions">Delivery Management</a></li>
            <li><a href="/bill/index" class="btn btn-actions">Bill Management</a></li>
        </ul>
    </div>

        <div style="width: 80%;margin: 10px auto;">
		<p class="title" style="font-size: 26px;font-weight: bold;">Coustomer Information</p>
            <?php if(!empty($data['message'])) : ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $data['message']; ?>
            </div>
            <?php endif; ?>
            <form method="post" action="<?php echo $data['action']; ?>" onSubmit="return  valid()">
                <div class="data">
                    <input type="hidden" name="CoustomerId" value="<?php echo $this->form_validation->CoustomerId;?>"/>
                    <table>
                        <tr>
                            <td width="40%">Coustomer Name:</td>
                            <td>
                                <input type="text" name="CoustomerName" id="CoustomerName" size="40" value="<?php echo $this->form_validation->CoustomerName; ?>"/>

                                <br/>
                                <span class="error"></span>
                            <td>
                        </tr>
                        <tr>
                            <td width="40%">Contract Name:</td>
                            <td>
                                <input type="text" name="Contract" id="Contract"  size="40" value="<?php echo $this->form_validation->ContractName; ?>"/>
                                <br/>
                                <span class="error"></span>
                            <td>
                        </tr>

                        <tr>
                            <td width="40%">Billing Address:</td>
                            <td>
                                <textarea  name="billing" id="billing"  rows="6" cols="30"><?php echo $this->form_validation->BillingAddresss; ?></textarea>
                                <br/>
                                <span class="error"></span>
                            <td>
                        </tr>
                        <tr>
                            <td width="40%">City</td>
                            <td>
                                <input type="text" name="City" id="City" size="40" value="<?php echo $this->form_validation->City; ?>" />
                                <br/>
                                <span class="error"></span>
                            <td>
                        </tr>
                        <tr>
                            <td width="40%">State</td>
                            <td>
                                <input type="text" name="State"  size="40" value="<?php echo $this->form_validation->StateForProvince; ?>"/>
                                
                               
                            <td>
                        </tr>
                        <tr>
                            <td width="40%">Postal Code</td>
                            <td>
                                <input type="text" name="Postal"  size="40" value="<?php echo $this->form_validation->PostalCode; ?>"/>
                                
                            <td>
                        </tr>
                        <tr>
                            <td width="40%">Country Region</td>
                            <td>
                                <input type="text" name="Country"  size="40" value="<?php echo $this->form_validation->CountryRegion; ?>"/>
                                
                                
                            <td>
                        </tr>
                        <tr>
                            <td width="40%">Contract Title</td>
                            <td>
                                <input type="text" name="Title"  size="40" value="<?php echo $this->form_validation->ContractTitle; ?>"/>
                                
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
                            <td width="40%">Fax</td>
                            <td>
                                <input type="text" name="Fax"  size="40" value="<?php echo $this->form_validation->FaxNum; ?>"/>
                                
                            <td>
                        </tr>
                        <tr>
                            <td width="40%">E-mail</td>
                            <td>
                                <input type="text" name="Email" id="Email"  size="40" value="<?php echo $this->form_validation->EMail; ?>" />
                                <br/>
                                <span class="error"></span>
                            <td>
                        </tr>
                        <tr>
                            <td width="40%">Notes:</td>
                            <td>
                                <textarea  name="Notes"   rows="6" cols="30"><?php echo $this->form_validation->ContractName; ?></textarea>
                                
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
				  <input type="radio" name="Status" value="Active" checked="checked" /> Active
                <input type="radio" name="Status" value="Inactive" /> Inactive<br/>
				<?php }?>
				<td>
			</tr>

                        <td align="center" ><input type="submit" value="Save" class="btn  btn-success" /></td>
                        <td><?php echo $data['link_back']; ?></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>