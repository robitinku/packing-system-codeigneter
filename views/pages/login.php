<script type="text/javascript">
    $(document).ready(function() {

        /*$("#logbtn").click(function() {
            $('#login').submit();
        });*/

        $('.successbox').hide();//Hide the div
        $('.warningbox').hide();
        $('.errormsgbox').hide();

        $(".successbox").fadeIn(2000); //Add a fade in effect that will last for 2000 millisecond
        $(".warningbox").fadeIn(2000);
        $(".errormsgbox").fadeIn(2000);

        $(".successbox").fadeOut(2000); //Add a fade in effect that will last for 2000 millisecond
        $(".warningbox").fadeOut(2000);
        $(".errormsgbox").fadeOut(2000);
    });


</script>

<!-- #BeginEditable "content" -->

<div class="registerpage">

    <h1>Sign in</h1>

    <div>
        <?php
            $message = json_decode($this->session->flashdata('msg'), 1);
            echo '<div class="'.$message['class'].'" > '.$message['msg'].' </div>'
        ?>
    </div>

    <div id="newcampform">

        <?php echo form_open(site_url('login/login_check'),array('name'=>'signin','id'=>'signin', 'class'=>'signup'));?>

        <div>
            <label>User Name</label>
            <input type="text" name="email" id="email">
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="passwd" id="passwd">
        </div>

            <!--<a href="javascript:void(0)" id="logbtn" class="registerbtn">Sign in</a>-->
            <!--<button class="tablebtn">Sign in</button>-->
            <input type="submit" class="btn btn-primary" value="Sign in">

        <?php echo form_close();?>
    </div>

</div><!-- content div ends -->

<!-- #EndEditable -->