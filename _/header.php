	<header class="site-header">
	    <div class="container-fluid">
	        <a href="home.php" class="site-logo">
	            <img class="hidden-md-down" style='height:50px' src="<?PHP echo $assets_url; ?>/img/logo/logo-hitam.png" alt="">
	            <img class="hidden-lg-down" src="<?PHP echo $assets_url; ?>/favicon/v2/black/android-icon-72x72.png" alt="">
	        </a>
	
	        <button style='padding-left:30px' id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button>
	
	        <button class="hamburger hamburger--htla">
	            <span>toggle menu</span>
	        </button>
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">
	                    
	
	
	                    
	
	                    <div class="dropdown user-menu">
	                        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                            <?PHP echo $admin_name; ?> <img src="<?PHP echo $admin_image; ?>" height='64px' alt="">
	                        </button>
	                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
								<a class="dropdown-item" href="$">Level : <span style='font-size:11px'><?PHP echo $admin_level_name; ?></span></a>
	                            <a class="dropdown-item" href="setting.php"><span class="font-icon glyphicon glyphicon-cog"></span>Settings</a>
	                            <a class="dropdown-item" href="logout.php"><span class="font-icon glyphicon glyphicon-log-out"></span>Logout</a>
	                        </div>
	                    </div>
	
	                    <button type="button" class="burger-right">
	                        <i class="font-icon-menu-addl"></i>
	                    </button>
	                </div><!--.site-header-shown-->
	
	                <div class="mobile-menu-right-overlay"></div>
	                <div class="site-header-collapsed">
	                    <div class="site-header-collapsed-in">
	                        
	
	                        
	                        <!--.help-dropdown-->
	                      
	                    </div><!--.site-header-collapsed-in-->
	                </div><!--.site-header-collapsed-->
	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->