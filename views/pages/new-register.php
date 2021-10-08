<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    jQuery.noConflict();
    (function($) {
    $(document).ready(function() {

        jQuery.validator.addMethod("names", function(value, element) {
            //var regval = $(element.outerHTML).attr('regex');
            return this.optional(element) || /^[a-zA-Z]+$/.test(value);
        }, "Please Enter Valid Characters");

        $("#signup").validate({
            rules: {
                email: {required:true, email:true, remote:"/register"},
                parent_email: { email:true, remote:"/register" },
                passwd: "required",
                cnf_password: {
                    equalTo: "#passwd"
                },
                passwd:{ minlength:6 },
                fname: { required:true, maxlength: 32, names:true },
                lname: { required:true, maxlength: 32, names:true }
            },
            messages:{
                email:{ required:"Please Enter Your Email", email:"Invalid Email Address", remote:"Email Already Taken"},
                parent_email:{ remote:"Parent Not Exists"}
            }
        });

        $('#country').change(function () {
            $.get("/register", {
                country:$('#country').val()
            }, function (response) {
                writeMobile('mobile', (response));
            });
            return false;
        });

        $("#regbtn").click(function() {
            $('#signup').submit();
        });

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
    })(jQuery);

    function writeMobile(id, response) {
        $('#'+ id).val(response);
        //$('#' + id).attr('value',unescape(response));
    }


</script>

<!-- #BeginEditable "content" -->

<div class="registerpage">



    <div class="login-box-main">

        <?php echo form_open(site_url('/register/save'),array('name'=>'signup','id'=>'signup', 'class'=>'signup'));?>
            <fieldset>
                <legend><span class="style2">Register</span> Here</legend>

                <div>
                    <?php
                    $message = json_decode($this->session->flashdata('msg'), 1);
                    echo '<div class="'.$message['class'].'" > '.$message['msg'].' </div>'
                    ?>
                    <?php echo validation_errors('<div class="error">', '</div>'); ?>
                </div>

                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">Email Address</label>

                    <div class="controls">
                        <input type="text" name="email" id="email" class="tips" tip="htm/email.htm" alt="Your email">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">Referel Email Address</label>

                    <div class="controls">
                        <input type="text" name="parent_email" id="parent_email" value="<?php if(!empty($_GET['ref'])) echo $_GET['ref']; ?>" class="tips" tip="htm/parent_email.htm" alt="Your parent email">
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">Password</label>

                    <div class="controls">
                        <input type="password" name="passwd" id="passwd" class="keyboardInput">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">Confirm Password</label>

                    <div class="controls">
                        <input type="password" name="cnf_password" id="cnf_password" class="keyboardInput">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">First Name</label>

                    <div class="controls">
                        <input type="text" name="fname" id="fname" class="tips" tip="htm/fname.htm"
                               alt="Your first name">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">Last Name</label>

                    <div class="controls">
                        <input type="text" name="lname" id="lname" class="tips" tip="htm/lname.htm"
                               alt="Your last name">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">Address</label>

                    <div class="controls">
                        <input type="text" name="address" id="address" class="tips" tip="htm/address.htm"
                               alt="Your address">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">City</label>

                    <div class="controls">
                        <input type="text" name="city" id="city" class="tips" tip="htm/city.htm" alt="Your city">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">Select Country</label>

                    <div class="controls">
                        <select name="country" id="country">
                            <option value="">--Select Country--</option>
                            <?php
                            foreach($data['country_list'] as $country)
                                echo "<option value=".$country['country_name'].">".$country['country_name']."</option>"
                            ?>
                        </select>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" style="width:150px;text-align:left;">Mobile Number</label>

                    <div class="controls">
                        <input type="text" name="mobile" id="mobile" class="tips" tip="htm/mobile.htm"
                               alt="Your mobile">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>

                    <div class="controls" style="margin-left:110px;">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </div>
            </fieldset>
        <?php echo form_close();?>


    </div>
</div><!-- content div ends -->

<!-- #EndEditable -->