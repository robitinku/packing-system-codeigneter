<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<style>
table td, table th,p {
			font-size: 1.2em;
			
		}
</style>
<script>

$(document).ready(function(){
  
/* $("#date" ).datepicker({ changeYear: true,
changeMonth: true
 }); */
 $("#report").click(function(){
  
   // $.ajax({url:'<?php echo base_url().'attendanceedit/attendancelist';?>',
   $.ajax({url:'<?php echo base_url().'index.php/costing/update';?>',
	type:'POST',
	data: {carton:$("#carton").val(),
	       length:$("#length").val(),
		   width:$("#width").val(),
		   height:$("#height").val(),
		   ply:$("#ply option:selected").text(),
		   lin:$("#lin option:selected").text(),
		   sales:$("#sales").val(),
		   number:$("#number").val(),
		   Size:$("#Size option:selected").val(),
		   rollsize:$("#rollsize option:selected").val(),
		   board:$("#board").is(':checked')
	},
	success:function(result){
      
	$("#costing").html(result);
    }});
	
  }); 
$("#date" ).datepicker({ changeYear: true,
changeMonth: true
 });
 
 $("#carton").keydown(function(event) {
numbervalid(event);
});
 $("#length").keydown(function(event) {
numbervalidpoint(event);
});
$("#width").keydown(function(event) {
numbervalidpoint(event);
});
$("#height").keydown(function(event) {
numbervalidpoint(event);
});
 $("#sales").keydown(function(event) {
numbervalidpoint(event);
});
 $("#number").keydown(function(event) {
numbervalid(event);
});

});

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
</script>



    <div class="content">
	<div style="width: 98%;margin: 20px auto;">
        <ul class="nav nav-pills">
            <li><a href="/userpanel/index" class="btn btn-actions">Customer Manager</a></li>
			 <li><a href="/costing/index" class="btn btn-actions">Cost Management</a></li>
            <li><a href="/order_manage/index" class="btn btn-actions">Order Manager</a></li>
            <li><a href="/delivery/index" class="btn btn-actions">Delivery Manager</a></li>
            <li><a href="/bill/index" class="btn btn-actions">Bill</a></li>
        </ul>
    </div>
<p class="title" style="font-size: 26px;font-weight: bold;">Costing Information</p>

        
	
    
        <div class="data" >
		<p style="margin-left:20px;">Size:<span style="padding-left:60px;"> <select id="Size" name="Size"></span>  
         <option value='Inch'>Inch</option>
        <option value='CM'>CM</option>
       </select></p> 
	    <p style="margin-left:20px;">
                Roll Size:
				 <span style="padding-left:25px;"> 
			      <select name="rollsize"  id="rollsize">
                  </span>     
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
                
				
			</p>
		 <p style="margin-left:20px;">Number: <span style="padding-left:30px;"> <input id="number" type="text" name="number"></span> </p>
		
        <table id="table">
          <tr>
                <td width="20%">Carton Quantity:</td>
				<td>
			          <input id="carton" type="text" name="carton"  size="5" value="" style="width:35px"/>
           
				</td>
				
				<td width="10%">Length:</td>
				<td>
			          <input id="length" type="text" name="length"  size="5" value="" style="width:35px"/>
           
				</td>
				<td width="10%">Width</td>
				<td>
			          <input id="width" type="text" name="width"  size="5" value="" style="width:35px"/>
           
				</td>
				<td width="10%">Height:</td>
				<td>
			          <input id="height" type="text" name="height"  size="5" value="" style="width:35px"/>
           
				</td>
				
			</tr>
        
              <tr>
                <td width="10%">PLY:</td>
				<td>
			         <select name="ply" id="ply" style="width:50px"> 
					 <option value="3">3 </option>
					 <option value="4">4 </option>
					 <option value="5"> 5</option>
					 <option value="6"> 6</option>
				     <option value="7"> 7</option>
					 </select>
           
				</td>
				   <td width="10%" >LIN:</td>
				<td>
			         <select name="lin" id="lin" style="width:50px"> 
					 <option value="1">1 </option>
					 <option value="2">2 </option>
					
				
					 </select>
           
				</td>
				<td width="10%" >Board</td>
				<td>
			          <input type="checkbox" id="board" name="board" value="Yes" />
           
				</td>
			 	<td width="10%" >Sales Rate</td>
				<td>
			          <input id="sales" type="text" name="sales"  size="5" value="" style="width:35px"/>
           
				</td>
		
			</tr>
			<tr>
                <td align="center" ><input class="btn  btn-success"  id="report" type="button" value="Report"/></td>
			
            </tr>
        </table>
        </div>
		</br>
		<div class="data">
		<table  style="width:250px;margin-left:200px;" id="costing" class="table table-bordered" >  </table>
		</div>
		

    </div>
