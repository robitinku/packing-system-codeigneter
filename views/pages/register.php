<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
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

    function writeMobile(id, response) {
        $('#'+ id).val(response);
        //$('#' + id).attr('value',unescape(response));
    }


</script>

<!-- #BeginEditable "content" -->

<div class="registerpage">

    <h1>Register</h1>

    <div>
        <?php
            $message = json_decode($this->session->flashdata('msg'), 1);
            echo '<div class="'.$message['class'].'" > '.$message['msg'].' </div>'
        ?>
        <?php echo validation_errors('<div class="error">', '</div>'); ?>
        <!--<div class="successbox" > This is a success message Box </div>
        <div class="warningbox" > This is a warning message Box </div>
        <div class="errormsgbox" > This is a Error  message Box </div>-->
    </div>

    <div id="newcampform">

        <?php echo form_open(site_url('/register/save'),array('name'=>'signup','id'=>'signup', 'class'=>'signup'));?>

        <!--<form id="signup" name="signup" method="post">-->
            <div>
                <label>Email Address</label>
                <input type="text" name="email" id="email">
                <label>Referel Email Address</label>
                <input type="text" name="parent_email" id="parent_email" value="<?php if(!empty($_GET['ref'])) echo $_GET['ref']; ?>">
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="passwd" id="passwd">
                <label>Confirm Password</label>
                <input type="password" name="cnf_password" id="cnf_password">
            </div>
            <div>
                <label>First Name</label>
                <input type="text" name="fname" id="fname">
                <label>Last Name</label>
                <input type="text" name="lname" id="lname">
                <label>Address</label>
                <input type="text" name="address" id="address">
                <label>City</label>
                <input type="text" name="city" id="city">
                <br>
            </div>

            <div>
                <label>Select Country</label>
                <select name="country" id="country">
                    <option value="">--Select Country--</option>
                    <?php
                        foreach($data['country_list'] as $country)
                            echo "<option value=".$country['country_name'].">".$country['country_name']."</option>"
                    ?>
                </select>
            </div>

            <div>
                <label>Mobile Number</label>
                <input type="text" name="mobile" id="mobile">
            </div>


            <a href="javascript:void(0)" id="regbtn" class="registerbtn">Register</a>
            <!--<input type="submit" class="registerbtn" value="Register">-->

        <?php echo form_close();?>
    </div>

</div><!-- content div ends -->

<!-- #EndEditable -->