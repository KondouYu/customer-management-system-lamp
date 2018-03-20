<!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <?php 
    if(isset($_COOKIE['sidebar'])){
        if($_COOKIE['sidebar'] == 0) echo '<body class="hold-transition skin-green sidebar-mini sidebar-collapse fixed">';
        if($_COOKIE['sidebar'] == 1) echo '<body class="hold-transition skin-green sidebar-mini fixed">';
    } else 
       echo '<body class="hold-transition skin-yellow sidebar-mini fixed">';
    ?>
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="/dashboard" class="logo">
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="glyphicon glyphicon-envelope"></i>
                </a>
                <ul class="dropdown-menu" id="smsStats" onclick="event.stopPropagation();">
                  <li class="header">Statystyki i smsy grupowe</li>
                  <li>
                    <!-- Inner menu: contains the tasks -->
                    <ul class="menu">
                     
                      <li><!-- Task item -->
                        <div id="saldo">999 PLN</div>
                      </li><!-- end task item -->
                      <li><!-- Task item -->
                        <hr>
                      </li><!-- end task item -->

                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">...</a>
                  </li>
                </ul>
              </li>
              
              <!-- SMS menu -->
              <li id="customSMS" class="dropdown tasks-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="glyphicon glyphicon-send"></i>
                </a>
                <ul class="dropdown-menu" onclick="event.stopPropagation();">
                  <li class="header">Wyślij wiadomość SMS</li>
                  <li>
                    <!-- Inner menu: contains the tasks -->
                    <ul class="menu">
                       <div class="form-group" style="margin-top: 10px;">
                           <div class="col-xs-2 col-sm-2 col-md-2 text-center"><label>+48</label></div>
                           <div class="col-xs-10 col-sm-10 col-md-10"><input type="text" class="form-control text-center" id="custom_numer" /></div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12"><textarea class="form-control" id="custom_wiadomosc"></textarea></div>
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#"><span id="custom_submit" class="btn btn-warning btn-xs" onclick="customSMS();">WYŚLIJ</span></a>
                  </li>
                </ul>
              </li>
              
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
                  <?php 
                    $avatar_path = base_url().'assets/img/avatar/'.$_SESSION['login'].'.jpg';
                    if(is_file('assets/img/avatar/'.$_SESSION['login'].'.jpg')) { ?>
			        <img class="user-image" src="<?php echo $avatar_path; ?>" alt="<?php echo $_SESSION['login']; ?>" />
			        <?php } else { ?>
			        <img class="user-image" src="<?php echo base_url(); ?>assets/img/avatar/thumb.jpg" alt="<?php echo $_SESSION['login']; ?>" />
			        <?php } ?>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?=$_SESSION['login'];?></span>
                </a>
                <ul class="dropdown-menu" onclick="event.stopPropagation();">
                  <!-- The user image in the menu -->
                  <li class="user-header">
                    <?php 
                    $avatar_path = base_url().'assets/img/avatar/'.$_SESSION['login'].'.jpg';
                    if(is_file('assets/img/avatar/'.$_SESSION['login'].'.jpg')) { ?>
			        <img class="img-circle" src="<?php echo $avatar_path; ?>" alt="<?php echo $_SESSION['login']; ?>" />
			        <?php } else { ?>
			        <img class="img-circle" src="<?php echo base_url(); ?>assets/img/avatar/thumb.jpg" alt="<?php echo $_SESSION['login']; ?>" />
			        <?php } ?>
                    <p>
                      <?=$_SESSION['login'];?>
                      <small></small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profil</a>
                    </div>
                    <div class="pull-right">
                      <a href="login/logout" class="btn btn-default btn-flat">Wyloguj</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-bars"></i></a>
              </li>
            </ul>
          </div>
        </nav>
      </header>