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
    $.ajax({url:'<?php echo base_url().'/bill_report/order';?>',
	type:'POST',
	data: {post_data: post_data},
	//dataType: 'json',
	success:function(result){
     $("#order").html(result);
	 orderinfo();
	 
    }});
  }).change();
  

  
  $("#save").click(function(){

if($("#invoicedata").val()==null)
{ 
alert("No Invoice Number");
}
 else 
{       
         var params= {
	             bill:'submit',
                 order:$("#ord option:selected").val(),
				 invoiceselect:$("#invoicedata option:selected").val()

				};
      
	   //data.push(params);
             
			  $.ajax({url:'<?php echo base_url().'/bill_report/save';?>',
					 type:'POST',
					data: {data:params},
	
					success:function(result){
							report(result);
	  
						}});
						
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
//alert(result);
newWindow.document.getElementById('datatable').innerHTML=result;
}
}
function orderinfo()
{

 tableload();//need change
 
}


function tableload()
{
  post_data="submit";
    
$.ajax({url:'<?php echo base_url().'/bill_report/invoiceselect';?>',

	type:'POST',
	data: {  bill: post_data,
             order:$("#ord option:selected").val()},
	async: false,
	success:function(result){
	
	  
   $("#invoiceselect").html("");
    $("#invoiceselect").append(result); 

    }});
   

 tableview();
}
function tableview(){
invoiceCheck=$("#invoicedata option:selected").val();
 post_data=$("#ord option:selected").val();
 status="submit";
    $.ajax({url:'<?php echo base_url().'/bill_report/orderdetail';?>',

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
                <li><a href="/attendance_report/index" class="btn btn-actions">Attendance</a></li>
				<li><a href="/attendance_report/revenue" class="btn btn-actions">Revenue</a></li>
                <li><a href="/attendance_report/expense" class="btn btn-actions">Expense</a></li>
				<li><a href="/raw_material/index" class="btn btn-actions">Raw Material</a></li>
				<li><a href="/bill_report/index" class="btn btn-actions">Bill</a></li>
                <li><a href="/income_report/index" class="btn btn-actions">Income</a></li>

            </ul>

        </div>

      
      <p class="title" style="font-size: 26px;font-weight: bold;">Bill Report</p>
    
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

			
			<tr >
               <td width="40%">Invoice Number:</td>
				
				<td id="invoiceselect">
			     
				</td>
			</tr>
		
			
	</table>
  <div class="data" id="table" style="width: 98%;"></div>

		
		
</div>
      <p style="margin-left:350px;"><input type="submit" value="Report" class="btn btn-primary" id="save"/></p>
</div>
