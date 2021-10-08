<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="/resources/demos/external/jquery.mousewheel.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
<script>
    $(function() {
        $( ".spinnermin" ).spinner({ max: 59,min:0});
        $( ".spinnerhour" ).spinner({ max: 23,min:0});
        $("table tr td:nth-child(5)").click(function(){


            $.ajax({url:'<?php echo base_url().'index.php/meal_schedule/update';?>',
                type:'POST',
                data: {
                    inhour:$(this).closest('tr').find("input[name='inhour']").val(),
                    inmin:$(this).closest('tr').find("input[name='inmin']").val(),
                    outhour:$(this).closest('tr').find("input[name='outhour']").val(),
                    outmin:$(this).closest('tr').find("input[name='outmin']").val(),

                    id:$(this).closest('tr').find("input[name='id']").val()
                },
                success:function(result){

                    $("#message").html(result);
                }});
        });
    });


</script>
<div class="content">
    <p>Shift Information</p>
    <div id="message"></div>
    <div class="data"><?php echo $data['table']; ?></div>

</div>