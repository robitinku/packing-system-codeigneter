 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>



<script>
$(document).ready(function(){
   $("#date" ).datepicker({ changeYear: true,
changeMonth: true,
dateFormat:"yy-mm-dd"
 });

  $("#coustomer").change(function(){
  
    post_data=$("#coustomer option:selected").val();
    $.ajax({url:'<?php echo base_url().'/bill/order';?>',
	type:'POST',
	data: {post_data: post_data},
	//dataType: 'json',
	success:function(result){
     $("#order").html(result);
	 orderinfo();
	 
    }});
  }).change();
  

  
  $("#save").click(function(){
  check="valid";
  if($("#sta option:selected").val()=="bill")
  {
    if($("#invoicetext").val().trim()=='')
	{
	alert("Give Invoice Number");
	check="Invalid";
	}
	else if ($("#date").val().trim()=='')
	{
	alert("Give Submit Date");
	check="Invalid";
	}
  }
  else if($("#sta option:selected").val()=="submit")
  {
  if ($("#date").val().trim()=='')
  {
	alert("Give Bill Paid Date");
	check="Invalid";
  }
  else if($("#invoicedata").val()==null)
  {
    alert("No Invoice Number");
	check="Invalid";
  }
  }
  else if($("#sta option:selected").val()=="paid")
  {
  check="Invalid";
  }
   if(check=="valid"){        
	     var data=[];
       
         var params= {
	             bill:$("#sta option:selected").val(),
                 order:$("#ord option:selected").val(),
				 invoicetext:$("#invoicetext").val(),
				 date:$("#date").val(),
				 invoiceselect:$("#invoicedata option:selected").val()
				 
				 
				};
      
	   //data.push(params);
             
			  $.ajax({url:'<?php echo base_url().'/bill/save';?>',
					 type:'POST',
					data: {data:params},
	                async: false,
					success:function(result){
							alert(result);
	  
						}});
					 if($("#sta option:selected").val()=="bill")
                     {	
					 var params= {
	             bill:'submit',
                 order:$("#ord option:selected").val(),
				 invoiceselect:$("#invoicetext").val()

				};
				var res="no";
					$.ajax({url:'<?php echo base_url().'/bill/checkbill';?>',
					 type:'POST',
					data: {data:params},
	                async: false,
					success:function(result){
							
	                    res=result;
						}});
						if(res=="yes")
						{
						$.ajax({url:'<?php echo base_url().'/bill_report/save';?>',
					 type:'POST',
					data: {data:params},
	                async: false,
					success:function(result){
							report(result);
	  
						}});
						}
					}
						
						
				}		
					
	}); 
  
			 
		 

});
var newWindow=null;
function report(result){

	if (newWindow==null || newWindow.closed)
{
	 newWindow = open("","_blank");
	 
	
newWindow.document.write('<style type="text/css">table{border-collapse:collapse;}#datatable{ font-family:tahoma;padding:0px;} table, th,td{margin-top:20px;border:1px solid black;}#print{width:30px;height:10px;} @media print {.headertitle, .hide { visibility: hidden }}</style>');
newWindow.document.write('<div id="print" ><input type="button" class="headertitle"  onClick="window.print()" value="Print"/> </div></br>');


newWindow.document.write('<div id="datatable"  class="data" style="width: 98%;"></div>');

newWindow.document.getElementById('datatable').innerHTML=result;
}
}
function orderinfo()
{
  $('#status').html('<td>Status:</td> <td><select onchange="tableload()"  id="sta"><option value="bill"> bill</option> <option value="submit">submit</option><option value="paid">paid</option></select></td>');
 tableload();//need change
 
}


function tableload()
{
  post_data=$("#sta option:selected").val();
        if(post_data=="bill")
        {
		  $("#invoice").show();
          $("#invoiceselect").html("");
          $("#invoiceselect").hide();
		  invoiceCheck=0;
		  
        }
        else{
             
			$("#invoiceselect").show();
			
		    $("#invoicetext").val("");
			
            $("#invoice").hide();
          
	
	
              		$.ajax({url:'<?php echo base_url().'/bill/invoiceselect';?>',

	type:'POST',
	data: {  bill:$("#sta option:selected").val(),
             order:$("#ord option:selected").val()},
	async: false,
	success:function(result){
	
	  
   $("#invoiceselect").html("");
    $("#invoiceselect").append(result); 

    }});

   
              
        }  

 tableview();
}
function tableview(){

if($("#invoicedata").val()==null)
{
invoiceCheck=0;
}
else
 invoiceCheck=$("#invoicedata option:selected").val();
 post_data=$("#ord option:selected").val();
 status=$("#sta option:selected").val();
    $.ajax({url:'<?php echo base_url().'/bill/orderdetail';?>',

	type:'POST',
	data: {post_data: post_data,status:status,invoiceCheck:invoiceCheck},
	
	success:function(result){
	
	  var tem=jQuery.parseJSON(result);
	$("#table").html("");
    $("#table").append(tem); 
	  
   

    }});

}
</script>
 
<style>

table {
    margin: 0 15px;
}
table td, table th {
    font-size: 1.2em;
    padding: 3px 7px 2px;
}
 </style>
<body>
    <div class="content" >
	<div style="width: 98%;margin: 20px auto;">
        <ul class="nav nav-pills">
            <li><a href="/userpanel/index" class="btn btn-actions">Customer Manager</a></li>
			 <li><a href="/costing/index" class="btn btn-actions">Cost Management</a></li>
            <li><a href="/order_manage/index" class="btn btn-actions">Order Management</a></li>
            <li><a href="/delivery/index" class="btn btn-actions">Delivery Management</a></li>
            <li><a href="/bill/index" class="btn btn-actions">Bill Management</a></li>
        </ul>
    </div>

      
      <p class="title" style="font-size: 26px;font-weight: bold;">Bill Management</p>
    
        <div class="data">
		 <table>



          <tr>
                <td width="40%">Coustomer Name:</td>
				<td>
			          <select  id="coustomer" >
						   <?php
							foreach($data['coustomer'] as $cus)	   
						   
							echo "<option value='". $cus->CoustomerId."'>". $cus->CoustomerName ."</option>";
							?>
				   </select>
				</td>
			</tr>
         <tr id="order">
              
			</tr>

			<tr id="status">
              
			</tr>
			<tr >
               <td width="40%">Invoice Number:</td>
				<td id="invoice">
			       <input id="invoicetext" type="text"   value="" style="width:200px;" />
				</td>
				<td id="invoiceselect">
			     
				</td>
			</tr>
			<tr >
              <td width="40%">Date:</td>
			  <td id="datetime">
			       <input id="date" type="text"   readonly="readonly" style="width:200px;" />
				</td>
				
			</tr>
			
	</table>
  <div class="data" id="table" style="width: 98%;"></div>

		
		
</div>
      <p style="margin-left:350px;"><input type="submit" value="Save" class="btn btn-primary" id="save"/></p>
</div>
