<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>NEXUS PRINTING AND PACKAGING PVT LTD</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?php echo base_url(); ?>assets/template/css/main/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/template/css/main/ufredis.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/template/css/main/signup.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/css/keyboard.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/css/tip.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/template/js/jtip.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/template/js/keyboard.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/js/jquery00.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/template/js/jquery01.js"></script>
    <script type="text/javascript">
        jQuery.noConflict();
        (function($) {
            $(function() {
                $('#pin').keypad();
            });
            $(function () {
                $('#retransaction_code').keypad();
            });
        })(jQuery);
    </script>


</head>

<body>

<?php echo $header; ?>

<div class="container main-container" style="">
    <div class="login-box" >
        <form class="form-horizontal" id="registerHere" method='post' action="/login/login_check" style="float:right;margin:0;">
         
              

        </form>

    </div>

    <!--loginbox-->


    <div class="a5-content row">
        <?php echo $content; ?>
    </div>

    <?php echo $footer; ?>
<!-- /container -->


<!-- modals -->



<!-- Javascript -->




<script>

    var sliderStatus = 0;

    var moveContainerDown = function (){
        $(".main-container").fadeIn()
            .css({top:-315,position:'relative'})
            .animate({top:-10}, 800, function() {
                sliderStatus = 1;
                //callback
            });
    }


    var moveContainerUp = function (){
        $(".main-container").fadeIn()
            .css({top:-10,position:'relative'})
            .animate({top:-315}, 800, function() {
                sliderStatus = 0;
            });
    }

    $('.login-slider').on('click', function(){
        if (sliderStatus == 0) {
            $('.login-box-main').fadeOut();
            moveContainerDown();
        }
        else if (sliderStatus == 1) {
            moveContainerUp();
            $('.login-box-main').fadeIn(800);
        }
    });
    $('.register-slider').on('click', function(){


        moveContainerUp();
        $('.login-box-main').fadeIn(800);

    });

    $('.a5-login').on('click', function(){
        $('#register-venue').hide();
        $('#register-member').fadeIn(500);
        $('.middle-divider').text('');
    });

    $('.a5-login-cancel').on('click', function(){
        $('#register-member').hide();
        $('#register-venue').fadeIn(500);
        $('.middle-divider').text('OR');
        return false;
    });

</script>

</body>
</html>