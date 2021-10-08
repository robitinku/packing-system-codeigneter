

<link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
<style>
table td, table th,p {
			font-size: 1.2em;
			
		}
table td{
padding-left:10px;
}
</style>

<script>
$(document).ready(function(){
$("#coustomer").change(function(){
  
    post_data=$("#coustomer option:selected").val();
    $.ajax({url:'<?php echo base_url().'assembly/order';?>',
	type:'POST',
	data: {post_data: post_data},
	//dataType: 'json',
	success:function(result){
     $("#order").html(result);
	 orderinfo();
	 
    }});
  }).change();
  
  $("#size").change(function(){
  
    post_data=$("#size option:selected").val();
    $.ajax({url:'<?php echo base_url().'assembly/orderstock';?>',
	type:'POST',
	data: {post_data: post_data},
	//dataType: 'json',
	success:function(result){
     $("#total").html(result);
	 
	 
    }});
  });
$("#carton").keydown(function(event) {
numbervalid(event);
});
$("#number").keydown(function(event) {
numbervalid(event);
});
 $("#length").keydown(function(event) {
numbervalidpoint(event);
});
$("#height").keydown(function(event) {
numbervalidpoint(event);
});
  $("#width ").keydown(function(event) {
numbervalidpoint(event);
});
$("#silicategum").keydown(function(event) {
numbervalidpoint(event);
});
  $("#Aicagum ").keydown(function(event) {
numbervalidpoint(event);
});
  $("#JuteTwine ").keydown(function(event) {
numbervalidpoint(event);
});
  $("#ink ").keydown(function(event) {
numbervalidpoint(event);
});
  $("#floor ").keydown(function(event) {
numbervalidpoint(event);
});
  $("#starchpowder ").keydown(function(event) {
numbervalidpoint(event);
});
  $("#Custic ").keydown(function(event) {
numbervalidpoint(event);
});
 $("#borak ").keydown(function(event) {
numbervalidpoint(event);
});
 $("#StitchingWire").keydown(function(event) {
numbervalidpoint(event);
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
 function orderinfo()
{
 
    post_data=$("#ord option:selected").val();
    $.ajax({url:'<?php echo base_url().'assembly/orderdetail';?>',

	type:'POST',
	data: {post_data: post_data},
	//dataType: 'json',
	success:function(result){
	
	
	   $("#productname").html(result);
      
    }});

}
function valid(){


if( $('#carton').val().trim()=='')
{
 $('#message').html("carton amount require");
return false;
}
else if( $('#number').val().trim()=='')
{
 $('#message').html("number require");
return false;
}
else if( $('#length').val().trim()=='')
{
 $('#message').html("length require");
return false;
}
else if( $('#height').val().trim()=='')
{
 $('#message').html("height require");
return false;
}
else if( $('#width').val().trim()=='')
{
 $('#message').html("Width amount require");
return false;
}

 else if( $('#ord  option:selected').val()==null)
{
 $('#message').html("No order ");
return false;
}

else
return true;
}


</script>



 

<body>
    <div class="content" >
	<div style="width: 98%;margin: 20px auto;">
        <ul class="nav nav-pills">
            <li><a href="/stock/index" class="btn btn-actions">Stock</a></li>
            
            <li><a href="/assembly/index" class="btn btn-actions">Assembly</a></li>
             <li><a href="/total_stock/index" class="btn btn-actions">Total Stock</a></li>
        </ul>
    </div>

      <div style="width: 80%;margin: 10px auto;">
            
            <div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
				<?php if($data['message']==null)
						echo '<span id="message">&nbsp</span>';
				else
                echo '<span id="message">'.$data['message'].'</span>';
				?>
            </div>
            
		</div>
      
        <div class="data">
		<form method="post" action="<?php echo $data['action']; ?>" onSubmit="return  valid()">
		 <!--  <p style="margin-left:10px;" id="total">Total:
				<span style="margin-left:20px;"></span>
			          
						 
				  
				
			</p>
			 -->
		
            <p style="margin-left:15px;">Coustomer:
				<span style="margin-left:15px;"></span>
			          <select  id="coustomer" name="coustomer" >
						   <?php
							foreach($data['coustomer'] as $cous)	   
						   
							echo "<option value='". $cous->CoustomerId."'>". $cous->CoustomerName ."</option>";
							?>
				   </select>
				
			</p>
			
			
				<p id="order" style="margin-left:15px;">
			        
				</p>
				
		        <div id="productname"style="margin-left:15px;">
			        
				</div>

		 
         </div>
		 <div id="productname"style="margin-left:15px;">
		 
			      <p>Roll Size: <span style="padding-left:30px;"> <select name="rollsize"  id="rollsize">
                     
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
			     </select></span> </p>
				</div>
				 <div id="productname"style="margin-left:15px;">
		 
			      <p>Number:<span style="padding-left:40px;"> <input id="number" type="text" name="number"></span> </p>
				</div>
		 <table >
              <tr>
                <td width="20%">Carton Quantity :
                </td>
                 <td><input id="carton" type="text" name="carton"  style="width:50px;"/>
                 </td>
            
             <td width="20%">Length:</td>
	     <td><input id="length" type="text" name="length"  size="5" value="" style="width:50px;" />
           
	     </td>
             <td width="20%">Width</td>
             <td><input id="width" type="text" name="width"  size="5" value="" style="width:50px;"/>
  
                </td>
              <td width="20%">Height:</td>
	      <td>		
			          <input id="height" type="text" name="height"  size="5" value="" style="width:50px;"/>
           
				</td>
             </tr>
             <tr>
                <td width="20%">PLY:</td>
		<td>	
		<select name="ply" id="ply" style="width:55px;"> 
					 <option value="3">3 </option>
					 <option value="4">4 </option>
					 <option value="5"> 5</option>
					 <option value="6"> 6</option>
				         <option value="7">7 </option>
		 </select>
           
		</td>
               <td width="20%" >LIN:</td>
	       <td>		
			         <select name="lin" id="lin" style="width:55px;"> 
					 <option value="1">1 </option>
					 <option value="2">2 </option>
					
				
					 </select>
           
				</td>

<td width="20%">Jute Twine:</td><td>
			          <input id="JuteTwine" type="text" name="JuteTwine"  size="5" value="" style="width:50px;"/>
           
				</td>
<td width="20%">Ink:</td><td>
				
			          <input id="ink" type="text" name="ink"  size="5" value="" style="width:50px;" />
           
				</td>

                </tr>
                <tr>

				<td width="20%">Stitching Wire(inch):</td><td>
				
			          <select id="StitchingWire" type="text" name="StitchingWire" style="width:50px;">
					  <option value="1">1</option>
					  <option value="1.5">1.5</option>
					  </select>
           
				</td>
				<td>
				  <input type="checkbox" id="silicateGum" name="silicateGum" value="Yes" />&nbsp&nbspSilicate
				</td>
				<td>
				  <input type="checkbox" id="aicaGum" name="aicaGum" value="Yes" />&nbsp&nbspAica
				</td>
				<td>
				  <input type="checkbox" id="board" name="board" value="Yes" />&nbsp&nbspBoard
				</td>
                </tr>

<tr><td width="20%"></td>
                 <td align="center" ><input type="submit" value="Save" class="btn btn-primary" /></td>
                 
  </tr>
				
</table>		
		
		 </form>
		 
      
    </div>
</body>