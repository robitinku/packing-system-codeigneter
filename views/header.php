
 <style type="text/css">
  #headername
 {
 padding-top:20px;
font-size:24px;
float:left;
width:680px;
 }
 #loginfo
 {
 display:block;
  padding:20px 0 0 0px;
  
 }
 </style>

<div id="header">
    <p id="headername"><a href="#">NEXUS PRINTING AND PACKAGING PVT LTD</a></p>

    <ul id="loginfo">

        <li><a>Welcome <?php echo $data['user_info']['fname'].' '.$data['user_info']['lname']; ?></a></li>
        
        <li><a href="/login/logout" class="logout">Logout</a></li>
    </ul>

</div>

<div id="headnavcontainer">

    <ul id="headnav">
	<li><a href="/userpanel/index">CRM</a></li>
  <li><a href="/stock/index">Inventory </a></li>
         <li><a href="/employee/index">HR</a></li>
		
		 
               
        
         <li><a href="/revenue/index/">Account</a>

        <li><a href="/meal_schedule/index/1">Maintenance</a>
            
        </li>
		 <li><a href="/attendance_report/index/">Report</a>
		
    </ul>

</div>