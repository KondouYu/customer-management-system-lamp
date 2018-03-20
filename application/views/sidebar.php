<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
            <?php 
            $avatar_path = base_url().'assets/img/avatar/'.$_SESSION['login'].'.jpg';
            if(is_file('assets/img/avatar/'.$_SESSION['login'].'.jpg')) { ?>
			<img class="img-circle" src="<?php echo $avatar_path; ?>" alt="<?php echo $_SESSION['login']; ?>" />
			<?php } else { ?>
			<img class="img-circle" src="<?php echo base_url(); ?>assets/img/avatar/thumb.jpg" alt="<?php echo $_SESSION['login']; ?>" />
			<?php } ?>
            </div>
            <div class="pull-left info">
                <p>
                    <?=$_SESSION['login'];?>
                </p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <div class="sidebar-form">
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Szukaj...">
                <div class="input-group-btn">
                <button id="search-toggle" class="btn" onclick="$('#search_type').slideToggle('fast');$('#search-toggle i').toggleClass('fa-caret-down fa-caret-up');"><i class="fa fa-caret-down"></i></button>
                </div>
                
            </div>
            <ul id="search_type" class="sidebar-menu">
                <li value="1" onclick="search();" class="active"><a href="#" onclick="search_type(1);"><i class="fa fa-circle-o text-yellow"></i> <span>Nazwisko</span></a></li>
                <li value="2" onclick="search();"><a href="#" onclick="search_type(2);"><i class="fa fa-circle-o text-orange"></i> <span>Telefon</span></a></li>
                <li value="3" onclick="search();"><a href="#" onclick="search_type(3);"><i class="fa fa-circle-o text-red"></i> <span>Pesel</span></a></li>
            </ul>
        </li>
        </div>
    
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="/dashboard"><i class="fa fa-home"></i> <span>Strona główna</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-user"></i> <span>Klienci</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#" onclick="new_customer();"><i class="fa fa-circle-o"></i> Nowy klient</a></li>
                    <li><a href="#" onclick="showAll();"><i class="fa fa-circle-o"></i> Lista wszystkich klientów</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> <span>Klienci po flagach</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                           <?php
                            $query = $this->db->query("SELECT * FROM flagi");
                            foreach ($query->result() as $row)
                            {
                                echo '<li><a href="#" onclick="showFlag('.$row->id.');"><i class="fa fa-circle-o" style="color: '.$row->kolor.';"></i>'.$row->nazwa.'</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> <span>Klienci po agentach</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <?php
                            $query = $this->db->query("SELECT * FROM agenci");
                            foreach ($query->result() as $row)
                            {
                                echo '<li><a href="#" onclick="showAgent('.$row->id.');"><i class="fa fa-circle-o"></i>'.$row->nazwa.'</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                    <li><a href="#" onclick="Windykacja();"><i class="fa fa-circle-o"></i> Windykacja</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-users"></i> <span>Spółki</span></a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> <span>Konfiguracja</span></a></li>
            <li><a href="#"><i class="fa fa-server"></i> <span>Konta</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
    
    <div id="search_result"></div>
</aside>