<link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />

<div class="content">
<div style="width: 98%;margin: 20px auto;">
        <ul class="nav nav-pills">
            <li><a href="/stock/index" class="btn btn-actions">Stock</a></li>
            
            <li><a href="/assembly/index" class="btn btn-actions">Assembly</a></li>
            <li><a href="/total_stock/index" class="btn btn-actions">Total Stock</a></li>
        </ul>
    </div>
   <p class="title" style="font-size: 26px;font-weight: bold;">Total Stock Information</p>
    
    <div class="data" style="width: 98%"><?php echo $data['table']; ?></div>
    
    <br />
</div>