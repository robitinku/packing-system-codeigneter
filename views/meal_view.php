<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="/resources/demos/external/jquery.mousewheel.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style type="text/css">
table td, table th,p {
    font-size: 1em;
   
}
span {
width:52px;
height:30px;
}
 </style>

<script>
    $(function() {
		$("table tr td:nth-child(3)").keydown(function(event) {
numbervalidpoint(event);

});
        $( ".spinnermin" ).spinner({ max: 59,min:0});
        $( ".spinnerhour" ).spinner({ max: 23,min:0});
        $("table tr td:nth-child(6)").click(function(){

if( $(this).closest('tr').find("input[name='value']").val()=='')
		{
		    msg = '<div class="alert alert-success fade in"><button class="close" data-dismiss="alert" type="button">×</button> value require </div>';
                    $("#message").html(msg);
   
				
		}
	else {
    
            $.ajax({url:'/meal_schedule/update',
                type:'POST',
                data: {value:$(this).closest('tr').find("input[name='value']").val(),
                    inhour:$(this).closest('tr').find("input[name='inhour']").val(),
                    inmin:$(this).closest('tr').find("input[name='inmin']").val(),
                    outhour:$(this).closest('tr').find("input[name='outhour']").val(),
                    outmin:$(this).closest('tr').find("input[name='outmin']").val(),

                    id:$(this).closest('tr').find("input[name='id']").val()
                },
                success:function(result){
                    msg = '<div class="alert alert-success fade in">'
                        + '<button class="close" data-dismiss="alert" type="button">×</button>'
                        + result + '</div>';
                    $("#message").html(msg);
                }});
				
				}
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


</script>
<div class="content">
      <div style="width: 98%;margin: 20px auto;">
            <ul class="nav nav-pills">
                <li><a href="/meal_schedule/index/1" class="btn btn-actions">Meal Infomation</a></li>
                <!--<li><a href="/meal_schedule/index/2" class="btn btn-actions">Shift</a></li>-->
                <li><a href="/meal_schedule/index/3" class="btn btn-actions">Cost</a></li>
                <li><a href="/department/index" class="btn btn-actions">Department</a></li>
				<li><a href="/supplier/index" class="btn btn-actions">Supplier</a></li>
				<li><a href="/product/index" class="btn btn-actions">Product</a></li>
            </ul>

        </div>
<p class="title" style="font-size: 26px;font-weight: bold;">Meal Information</p>
    
    <div id="message" style="width: 90%;margin: 10px auto;"></div>
    <div class="data" style="width: 98%"><?php echo $data['table']; ?></div>

</div>