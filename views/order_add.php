 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />





<script>
$(document).ready(function(){

$( "#date" ).datepicker({ changeYear: true,
changeMonth: true,
dateFormat:"yy-mm-dd"

 });
 $( ".ddate" ).datepicker({ changeYear: true,
changeMonth:true,
dateFormat:"yy-mm-dd"
 });

 var i=1;
   $("#rowadd").click(function(){
   i++;
  $( "#order" ).append('<tr><td>'+i +'</td><td><select  name="metarial" style="width:110px;"> <?php foreach($data['product'] as $pro)  echo '<option value='. $pro->id .'>'. $pro->name .'</option>';?></select> </td><td><input type="text" class="ddate" name="ddate" style="width:80px;" readonly="readonly"/> </td></td><td><input type="text"  name="quantity" style="width:50px;" /></td><td><input type="text"  name="unit_price" style="width:50px;" /> </td><td><input type="text"  name="total_price" readonly="readonly" style="width:55px;"/> </td> </tr>'
                       );
	$( ".ddate" ).datepicker({ changeYear: true,
                               changeMonth: true,
							   dateFormat:"yy-mm-dd"
                            });				   
					   
   });
   var total=0;
   
   
      $("table ").on( "change","tr td:nth-child(4)",function(){
         if($(this).closest('tr').find("input[name='unit_price']").val()!="")
	      {
	     total=$(this).closest('tr').find("input[name='quantity']").val()*$(this).closest('tr').find("input[name='unit_price']").val();
         $(this).closest('tr').find("input[name='total_price']").val(total);
	        var totalamount=0;
		   $("table tr").each(function(){
							if($(this).find('td').find("input[name='total_price']").val()!=null)
							   {
							      var amount=Number($(this).find('td').find("input[name='total_price']").val());
								 totalamount=totalamount + amount;
								
							   }
				       });
					 
				    $("#total_amount").val(totalamount);
				  
		    }
        });

       $("table").on( "keydown","tr td:nth-child(4)",function(event) {
                 numbervalid(event);

        });
       $("table").on( "keydown","tr td:nth-child(5)",function(event) {
         numbervalid(event);

        });

  
      $("table ").on( "change","tr td:nth-child(5)",function(){
         if($(this).closest('tr').find("input[name='quantity']").val()!="")
	      {
	     total=$(this).closest('tr').find("input[name='quantity']").val()*$(this).closest('tr').find("input[name='unit_price']").val();
         $(this).closest('tr').find("input[name='total_price']").val(total);
		   var totalamount=0;
		     $("table tr").each(function(){
							if($(this).find('td').find("input[name='total_price']").val()!=null)
							   {
							      var amount=Number($(this).find('td').find("input[name='total_price']").val());
								 totalamount=totalamount + amount;
								
							   }
				       });
				
				    $("#total_amount").val(totalamount);
		 
	      }
	
        });
   
  
   
   $("#save").click(function(){
            var data=[];
			 var j=0;
			 var check=0;
  $("#order tr").each(function(){
    if(j>0)
	{
	if( $("#date").val().trim()=='')
        {
          $("#message").html("");
          $("#message").append("Order Date Require");
		  check=1;
        }
	else	if( $("#order_name").val().trim()=='')
        {
          $("#message").html("");
          $("#message").append("Order Name Require");
		  check=1;
        }
	else if( $(this).find('td').find("input[name='quantity']").val().trim()=='')
        {
          $("#message").html("");
          $("#message").append("Quantity Require");
		  check=1;
        }
	
	
	else if( $(this).find('td').find("input[name='unit_price']").val().trim()=='')
        {
          $("#message").html("");
          $("#message").append("Unit Price Require");
		  check=1;
        }
 

	var params= {
	             material: $(this).find('td').find("select[name='metarial' ] option:selected").val(),
				 description: "",
				 quantity: $(this).find('td').find("input[name='quantity']").val(),
				 
				 unit_price: $(this).find('td').find("input[name='unit_price']").val(),
				 total_price:  $(this).find('td').find("input[name='total_price']").val(),
                 ddate:  $(this).find('td').find("input[name='ddate']").val()
				 
				};
      
	   data.push(params); 
	  	
    }
	  j++;
	  
	});  
  
	if(check==0)
	{
	  
			$.ajax({url:'<?php echo base_url().'order_manage/update';?>',
			type:'POST',
			data: {post_data: data,
				   date:$("#date").val(),
				   CoustomerId: $("#coustomer option:selected").val(),
				   order_name:$("#order_name").val()
			},
			success:function(result){
			 location.reload();
			 $("#message").html("");
          $("#message").append(result);
		   
			}}); 
	
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
 
</script>



 
</head>
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
    
      <div style="width: 80%;margin: 10px auto;">
            
            <div class="alert alert-success" >
	
                <button type="button" class="close" data-dismiss="alert">&times;</button>
						<span id="message">&nbsp</span>
                
            </div>
            
		</div>
      
        <div class="data" >
		<p class="title" style="font-size: 26px;font-weight: bold;">Order Management</p>
		<p style="margin-left:10px;">Date:<span style="margin-left:60px;"></span><input id="date" type="text" name="date"  size="40" value="" readonly="readonly"/>  </p>
        <p style="margin-left:10px;">Coustomer:
				<span style="margin-left:20px;"></span>
			          <select  id="coustomer" >
						   <?php
							foreach($data['coustomer'] as $cous)	   
						   
							echo "<option value='". $cous->CoustomerId."'>". $cous->CoustomerName ."</option>";
							?>
				   </select>
				
	    </p>
		 <p style="margin-left:10px;">Order Name:
				<span style="margin-left:12px;"></span>
			          <input id="order_name" type="text" name="order_name"  size="40" value=""/>
				   </select>
				
	    </p>
		 <table id="order" class="table table-bordered" style="width: 98%;">
           <tr>
               <th>Serial</th>
               <th>Material</th>
			
			   <th>Delivery Date</th>
               <th>Quantity</th>
			   
               <th>Unit Price</th>
			   <th>Total Price</th>
          </tr>

          <tr>
            <td>1 </td>
            <td> <select  name="metarial" style="width:110px;">
						   <?php
							foreach($data['product'] as $pro)	   
						   
							echo "<option value='". $pro->id ."'>". $pro->name ."</option>";
							?>
				   </select> </td> 
			
			<td><input type="text" class="ddate" name="ddate" style="width:80px;" readonly="readonly"/> </td>
            <td><input type="text"  name="quantity" class="cal" style="width:50px;"/> </td> 
			
			<td><input type="text"  name="unit_price" style="width:50px;" /> </td>
            <td><input type="text"  name="total_price" readonly="readonly" style="width:55px;" /> </td> 
		</tr>

			
			
	</table>
	
 <p style="margin-left:730px;">Total <input type="text" id ="total_amount"readonly="readonly" value="0" style="width:55px;"/></p>
	<p style="margin-left:10px;"><input type="button" value="Add row" id="rowadd" class="btn  btn-success" />
    <input type="button" value="save" id="save" class="btn  btn-success" /></p>
		
</div>
      
</div>
</body>
</html>