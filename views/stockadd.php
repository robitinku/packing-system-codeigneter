
 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<style>
table td, table th {
			font-size: 1.2em;
			padding: 3px 7px 2px;
		}

</style>

<script>
$(document).ready(function(){
  
$("#date" ).datepicker({ changeYear: true,
changeMonth: true
//dateFormat:'d-m-y'
 });
 $("#price").keydown(function(event) {
numbervalidpoint(event);
});
$("#amount").keydown(function(event) {
numbervalid(event);
});

$( "#amount" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
  $( "#price" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});

$( "#date" ).blur(function() {
 $(this).closest('tr').find('span').html("");
});
    $("#catagory").change(function(){
        post_data=$("#catagory option:selected").text();
        if(post_data=="Paper")
        {
            $("#size").show();
            $("#type").show();
        }
        else{
            $("#size").hide();
            $("#type").hide();
            $("#size option:selected").val("");
            $("#type option:selected").val("");
        }


    });


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
function numbervalidpoint(event)
{

if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39 ||event.keyCode==110 )) {
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


if( $('#amount').val().trim()=='')
{
 $('#amount').closest('tr').find('span').html("Amount require");
return false;
}
else if( $('#price').val().trim()=='')
{
 $('#price').closest('tr').find('span').html("Price require");
return false;
}
else if( $('#date').val().trim()=='')
{
 $('#date').closest('tr').find('span').html("Date require");
return false;
}
else
return true;
}
</script>
    <div class="content">
	
	<div style="width: 98%;margin: 20px auto;">
      <ul class="nav nav-pills">
            <li><a href="/stock/index" class="btn btn-actions">Stock</a></li>
            
            <li><a href="/assembly/index" class="btn btn-actions">Assembly</a></li>
             <li><a href="/total_stock/index" class="btn btn-actions">Total Stock</a></li>
        </ul>
    </div>

        <div style="width: 80%;margin: 10px auto;">
       <p class="title" style="font-size: 26px;font-weight: bold;">Stock Information </p>
       <?php if(!empty($data['message'])) : ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $data['message']; ?>
            </div>
            <?php endif; ?>
        <form method="post" action="<?php echo $data['action']; ?>" onSubmit="return  valid()">
        <div class="data">
		<input type="hidden" name="CoustomerId" value=""/>
        <table>
          <tr>
                <td width="40%">Catagory:</td>
				<td>
                    <select name="catagory" id="catagory">
                        <option value='Paper'>Paper</option>
                        <option value='Silicate Gum'>Silicate Gum</option>
                        <option value='Aica Gum'>Aica Gum</option>
						<option value='Stitching Wire'>Stitching Wire</option>
						<option value='Jute Twine'>Jute Twine</option>
						<option value='Ink'>Ink</option>
						<option value='Flour'>Flour</option>
						<option value='Starch Powder'>Starch Powder</option>
						<option value='Custic'>Custic</option>
						<option value='Borax'>Borax</option>
						<option value='Board'>Board</option>
                    </select>


              </td>
			</tr>
         <tr id="size">
                <td width="40%">Paper Size:</td>
				<td>
			      <select name="size">
        
					<option value='24'>24</option>
					<option value='25'>25</option>
                    <option value='26'>26</option>
                    <option value='27'>27</option>
                    <option value='28'>28</option>
                    <option value='30'>30</option>
                    <option value='32'>32</option>
                    <option value='34'>34</option>
                    <option value='36'>36</option>
                    <option value='38'>38</option>
                    <option value='40'>40</option>
                    <option value='42'>42</option>
                    <option value='44'>44</option>
                    <option value='46'>46</option>
                    <option value='48'>48</option>
                    <option value='50'>50</option>
			     </select>
                </td>
				
			</tr>

            <tr id="type">
                <td width="40%">Paper Type:</td>
                <td>
                    <select name="type">

                        <option value='Liner'>Liner</option>
                        <option value='Medium'>Medium</option>


                    </select>

                </td>
            </tr>

            <tr>
                <td width="40%">Quantity</td>
                <td>
                    <input type="text" name="amount" id="amount" size="40" value=""/>
					<br/>
					<span class="error"></span>
                </td>
            </tr>

            <tr>
                <td width="40%">Unit Price(Per Kg)</td>
                <td>
                    <input type="text" name="price" id="price"  size="40" value=""/>
					<br/>
					<span class="error"></span>
                </td>
            </tr>
			 <tr>
                <td width="40%">Date</td>
				<td>
			          <input id="date" type="text" name="date"  size="40"  readonly="readonly"/> 
             		<br/>
					<span class="error"></span>
					
				</td>
			</tr>
			<tr>
                <td width="40%">Supplier Name:</td>
				<td>
			       <select  id="supplier" name="suppliername">
						   <?php
							foreach($data['supplier'] as $sup)	   
						   
							echo "<option value='". $sup->id ."'>". $sup->supplier_name ."</option>";
							?>
				   </select>				
				</td>
			</tr>
			
			 
		
		     <tr>
                 <td align="center" ><input type="submit" value="Save" class="btn btn-primary" /></td>
                 <td><?php echo $data['link_back']; ?></td>
            </tr>
        </table>
        </div>
        </form>
        <br/>
      </div>
    </div>