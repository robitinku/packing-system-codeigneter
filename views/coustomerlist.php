<div class="content">
    <div style="width: 98%;margin: 20px auto;">
        <ul class="nav nav-pills">
            <li><a href="/userpanel/index" class="btn btn-actions">Customer Manager</a></li>
			 <li><a href="/costing/index" class="btn btn-actions">Cost Management</a></li>
            <li><a href="/order_manage/index" class="btn btn-actions">Order Management</a></li>
            <li><a href="/delivery/index" class="btn btn-actions">Delivery Management</a></li>
            <li><a href="/bill/index" class="btn btn-actions">Bill Management</a></li>
        </ul>
    </div>
    <p class="title" style="font-size: 26px;font-weight: bold;">Customer Information</p>

    <p class="title"><?php echo anchor('userpanel/add/','Add New Customer',array('class'=>'btn btn-success')); ?></p>

    <div class="data" style="width: 98%;"><?php echo $data['table']; ?></div>
    <div style="margin-left: 10px;" class="pagination"><?php echo $data['pagination']; ?></div>
</div>