<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
  .content
 {
 margin: 20px 0px 0 100px;

 }

 }
 </style>
 
</head>
<body>
 <div style="width: 98%;margin: 20px auto;">
        <ul class="nav nav-pills">
            <li><a href="/userpanel/index" class="btn btn-actions">Customer Manager</a></li>
			 <li><a href="/costing/index" class="btn btn-actions">Cost Management</a></li>
            <li><a href="/order_manage/index" class="btn btn-actions">Order Management</a></li>
            <li><a href="/delivery/index" class="btn btn-actions">Delivery Management</a></li>
            <li><a href="/bill/index" class="btn btn-actions">Bill Management</a></li>
        </ul>
    </div>
    <div class="content">
      
     
<p class="title" style="font-size: 26px;font-weight: bold;">Customer Information</p>

        <div class="data">
		
        <table>
          <tr>
                <td width="40%">Coustomer Name:</td>
				<td>
			          <input type="text"  disabled="disabled" name="CoustomerName"  size="40" value="<?php echo $this->form_validation->CoustomerName; ?>"/>
           
             							
				<td>
			</tr>
         <tr>
                <td width="40%">Contract Name:</td>
				<td>
			          <input type="text" disabled="disabled" name="Contract"  size="40" value="<?php echo $this->form_validation->ContractName; ?>"/>
             		
				<td>
			</tr>
			
			 <tr>
                <td width="40%">Billing Address:</td>
				<td>
			          <textarea   name="billing"   rows="6" cols="30" readonly="readonly"><?php echo $this->form_validation->BillingAddresss; ?></textarea>
             		
				<td>
			</tr>
		  <tr>
                <td width="40%">City</td>
				<td>
			          <input type="text" disabled="disabled" name="City"  size="40" value="<?php echo $this->form_validation->City; ?>" />
             	
				<td>
			</tr>
               <tr>
                <td width="40%">State</td>
				<td>
			          <input type="text" disabled="disabled" name="State"  size="40" value="<?php echo $this->form_validation->StateForProvince; ?>"/>
             		
				<td>
			</tr>
			 <tr>
                <td width="40%">Postal Code</td>
				<td>
			          <input type="text" disabled="disabled" name="Postal"  size="40" value="<?php echo $this->form_validation->PostalCode; ?>"/>
             		
				<td>
			</tr>
			 <tr>
                <td width="40%">Country Region</td>
				<td>
			          <input type="text"  disabled="disabled" name="Country"  size="40" value="<?php echo $this->form_validation->CountryRegion; ?>"/>
             		
				<td>
			</tr>
			 <tr>
                <td width="40%">Contract Title</td>
				<td>
			          <input type="text" disabled="disabled" name="Title"  size="40" value="<?php echo $this->form_validation->ContractTitle; ?>"/>
             		
				<td>
			</tr>
			 <tr>
                <td width="40%">Phone Number</td>
				<td>
			          <input type="text" disabled="disabled" name="Phone"  size="40" value="<?php echo $this->form_validation->PhoneNum; ?>"/>
             		
				<td>
			</tr>
			 <tr>
                <td width="40%">Fax</td>
				<td>
			          <input type="text" name="Fax" disabled="disabled"  size="40" value="<?php echo $this->form_validation->FaxNum; ?>"/>
             	
				<td>
			</tr>
			 <tr>
                <td width="40%">E-mail</td>
				<td>
			          <input type="text" name="Email" disabled="disabled"  size="40" value="<?php echo $this->form_validation->Notes; ?>" />
             		
				<td>
			</tr>
			 <tr>
                <td width="40%">Notes:</td>
				<td>
			          <textarea  name="Notes"   rows="6" cols="30" readonly="readonly"><?php echo $this->form_validation->ContractName; ?></textarea>
             		
				<td>
			</tr>
            <tr>
				<td> <?php echo $data['link_back']; ?><td>
            </tr>
            <tr>
                <td> <td>
            </tr>
        </table>
        </div>
      
    </div>
</body>
</html>