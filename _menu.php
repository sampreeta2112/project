<?php
if($popup!="Y")
{
	?>
	  <title><?php echo $SITE_TITLE?></title>
</head>
 
<body onLoad="noBack();">

	 
	<nav class="navbar navbar-inverse">
	          		     <div class="logo_holder"><a class="navbar-brand" ><br><img src="../img/project.png" width="140" height="30" alt="logo" style=
						 
						 "margin-top:-20px;""></a></div>

  <div class="container-fluid toggled">

 <div class="navbar-header">

</div>
  
    
	<div class="col-lg-9 col-md-1 col-sm-1 col-xs-12">

                                <div class="header-top-menu tabl-d-n">
								 <ul class="nav navbar-nav mai-top-nav">
                                        <li class="nav-item"><a href="region_report.php" class="nav-link">HOME</a>
                                        </li>
                                   
                                         
                                   
                                                
                                      						
                                        
										<li class="nav-item"><a href="region.php" class="nav-link">ADD SHIP</a>
                                        </li>
										      
										
									
                                        <li class="nav-item"><a href="#" class="nav-link">HELP</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
							
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#" title="Change Password" data-toggle="modal" data-target="#configModal"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
	  <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
    </ul>
  </div>
  </div>
</nav>

	<div class="col-sm-10" id="div-2">
	
  <?php
}
?>
	