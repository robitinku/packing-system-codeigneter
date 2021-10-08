<link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />

<div class="content">
<div style="width: 98%;margin: 20px auto;">
        <ul class="nav nav-pills">
            <li><a href="/stock/index" class="btn btn-actions">Stock</a></li>
            
            <li><a href="/assembly/index" class="btn btn-actions">Assembly</a></li>
             <li><a href="/total_stock/index" class="btn btn-actions">Total Stock</a></li>
        </ul>
    </div>
   <p class="title" style="font-size: 26px;font-weight: bold;">Stock Information</p>
    <p class="title"> <?php echo anchor('stock/add/','Add New Data',array('class'=>'btn btn-success')); ?></p>
    <div class="data" style="width: 98%"><?php echo $data['table']; ?></div>
    <div class="pagination" style="margin-left: 10px;"><?php echo $data['pagination']; ?></div>
    <br />
</div>