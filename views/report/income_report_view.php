 <link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />

 <style type="text/css">
 	
		table {
			margin: 0 15px;
		}
		table td, table th {
			font-size: 1.2em;
			padding: 3px 7px 2px;
		}

    </style>
	



<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script>


  $(document).ready(function(){

$("#report").click(function(){

     var month=$("#month option:selected").text();
     var  year=$("#year option:selected").val();
	

    $.ajax({url:'<?php echo base_url().'index.php/income_report/income_statement';?>',
	type:'POST',
	 dataType: "text",
	async: false,
	data: {month: month,
	       year: year
	},
	
	success:function(result){
        
     report(result);


    }
    });  
	
  });
 
});

  var newWindow=null;
function report(result){

	if (newWindow==null || newWindow.closed)
{
	 newWindow = open("","_blank");
	 //'copyhistory=yes,menubar=yes,resizable=no,height=950,width=650,left=300,top=50,scrollbars=1'
	
newWindow.document.write('<style type="text/css">table{border-collapse:collapse;}#datatable{ font-family:tahoma;padding:0px;} table, th,td{margin-top:20px;border:1px solid black;}#print{width:30px;height:10px;} @media print {.headertitle, .hide { visibility: hidden }}</style>');
newWindow.document.write('<div id="print" ><input type="button" class="headertitle"  onClick="window.print()" value="Print"/> </div></br>');


newWindow.document.write('<div id="datatable" align="center" class="data" style="width: 98%;"></div>');

newWindow.document.getElementById('datatable').innerHTML=result;
}
}
</script>

    <div class="content">
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

        <div class="data" style="margin-left:20px;">
		<p class="title" style="font-size: 26px;font-weight: bold;"><?php echo $data['title']; ?></p>
		Month:&nbsp;&nbsp;&nbsp;
		<select id="month" name="month" >
              <option value="1">January</option>
			  <option value="2">February</option>
			  <option value="3">March</option>
			  <option value="4">April</option>
			  <option value="5">May</option>
			  <option value="6">June</option>
			  <option value="7">July</option>
			  <option value="8">August</option>
			  <option value="9">September</option>
			  <option value="10">October</option>
			  <option value="11">November</option>
			  <option value="12">December</option>
			 
	    </select>		  

			  
       
		&nbsp;&nbsp;&nbsp;Year:&nbsp;&nbsp;&nbsp;
		<Select id="year"  name="year">
                 
                <option value="2014">2014</option>
		<option value="2015">2015</option>
		<option value="2016">2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
		<option value="2020">2020</option>
        </select>		
		
		</div>
		<div style="margin-left:150px;"><input type="button" value="Report" id="report" class="btn btn-primary" /></div>

        
		

    </div>