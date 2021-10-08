<script>
$(document).ready(function(){


  $("#coustomer").change(function(){
  
    post_data=$("#coustomer option:selected").val();
    $.ajax({url:'<?php echo base_url().'delivery/order';?>',
	type:'POST',
	data: {post_data: post_data},
	//dataType: 'json',
	success:function(result){
     $("#order").html(result);
	 orderinfo();
	 
    }});
  }).change();
  
  
  $("#table").on( "click","table tr td:nth-child(12)",function(){ 
             if($(this).closest('tr').find("td input[name='challan_no']").val().trim()=="")
		   {
		   $("#message").html("");
           $("#message").append("Challan Number require");
		   }
		  
		   else if($(this).closest('tr').find(" td input[name='delivery']").val().trim()=="")
		   {
		   $("#message").html("");
           $("#message").append("Delivery  Number require");
		   }
           else if(Number($(this).closest('tr').find(" td input[name='delivery']").val())>Number($(this).closest('tr').find("td input[name='status']").val()))
		   {
		   $("#message").html("");
           $("#message").append("Delivery Over Status");
                             
		   }
		   else if(Number($(this).closest('tr').find(" td input[name='delivery']").val())>Number($(this).closest('tr').find("td input[name='remain']").val()))
		   {
		   $("#message").html("");
           $("#message").append("Delivery Over Remain");
		   }
		   else {
		 
	    var data=[];
        
         var params= {
	             delivery: $(this).closest('tr').find(" td input[name='delivery']").val(),
				 coustomer_id: $("#coustomer option:selected").val(),
				 order_id: $("#ord option:selected").val(),
				 order_detail_id: $(this).closest('tr').find("td input[name='id']").val(),
		 		 delivery_date: '', //$(this).closest('tr').find("td input[name='date']").val(),
				 bill:'bill' ,
				 invoice:'0',
               	challan_no:$(this).closest('tr').find("td input[name='challan_no']").val(),		 
				 vat_no:$(this).closest('tr').find("td input[name='vat_no']").val()
				 
				};
      
	   data.push(params);
             status=Number($(this).closest('tr').find("td input[name='status']").val())-Number($(this).closest('tr').find(" td input[name='delivery']").val());

			  $.ajax({url:'<?php echo base_url().'delivery/save';?>',
					 type:'POST',
					data: {data:data,
					       status:status
					},
	
					success:function(result){
							 $("#message").html("");
                            $("#message").append(result);
                             location.reload();
	  
						}});
					
					
				}	
			});	
				
		$("#table").on( "keydown","table tr td:nth-child(11)",function(event) {
        // Allow: backspace, delete, tab, escape, enter and .
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
    });

  
			 
		 

});

function orderinfo()
{
  
    post_data=$("#ord option:selected").val();
    $.ajax({url:'<?php echo base_url().'delivery/orderdetail';?>',

	type:'POST',
	data: {post_data: post_data},
	//dataType: 'json',
	success:function(result){
	
	 var tem=jQuery.parseJSON(result);
	   $("#table").html("");
      $("#table").append(tem);
	  /* $(".date" ).datepicker({ changeYear: true,
         changeMonth: true
         });  */


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
<p class="title" style="font-size: 26px;font-weight: bold;">Delivery Management</p>
      <div style="width: 80%;margin: 10px auto;">
            
            <div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp;</span>
                
            </div>
            
		</div>
      
      
        <div class="data">
		 <table>



          <tr>
                <td >Coustomer:</td>
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

			
			
	</table>
  <div class="data" id="table" style="width: 98%;"></div>

		
		
</div>
      
</div>
