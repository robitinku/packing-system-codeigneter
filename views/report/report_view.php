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
$( "#from" ).datepicker({
 
dateFormat:"yy-mm-dd",
changeYear: true,
changeMonth: true,
numberOfMonths: 1,
onClose: function( selectedDate ) {
$( "#to" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#to" ).datepicker({
 
  dateFormat:"yy-mm-dd",
changeYear: true,
changeMonth: true,
numberOfMonths: 1,
onClose: function( selectedDate ) {
$( "#from" ).datepicker( "option", "maxDate", selectedDate );
}
});

});
  

function clik(reportname){
var reportname='<?php echo base_url().'attendance_report/';?>'+reportname;
     month=$("#from").val();
    year=$("#to").val();
	
    $.ajax({url:reportname,
	type:'POST',
	async: false,
	data: {month: month,
	       year: year
	},
	success:function(result){
     
     report(result);


    }});  
	
  }
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

//});

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
		From:&nbsp;&nbsp;&nbsp;<input id="from" type="text" name="from"  size="40"  readonly="readonly"/> 
       
		&nbsp;&nbsp;&nbsp;To:&nbsp;&nbsp;&nbsp;<input id="to" type="text" name="to"  size="40"  readonly="readonly"/>  </div>
		<div style="margin-left:150px;"><input type="button" value="Report" id="report" class="btn btn-primary" onclick="clik('<?php echo $data['report_name']?>')"/></div>

        
		

    </div>