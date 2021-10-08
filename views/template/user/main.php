<!DOCTYPE html>
<html dir="ltr">

<!-- #BeginTemplate "user_panel.dwt" -->

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <!-- #BeginEditable "doctitle" -->
    <title>User Panel : <?php echo $title; ?></title>
    <!-- #EndEditable -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <link href="<?php echo base_url()."assets/userpanel.css"; ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url()."assets/css/bootstrap.css"; ?>" rel="stylesheet" type="text/css">
</head>

<body>
<?php echo $header; ?>
<div id="wrapper">
    <?php echo $content; ?>
</div><!-- wrapper ends -->
<?php echo $footer; ?>
</body>

<!-- #EndTemplate -->

</html>
