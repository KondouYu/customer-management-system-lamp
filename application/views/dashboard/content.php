<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Panel kontrolny</small>
          </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Root</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <?php $this->load->view('dashboard/stats_info_1'); ?>
            <?php $this->load->view('dashboard/stats_info_2'); ?>
              
               <div class="row">
                  <div class="chart">
                   <?php $this->load->view('dashboard/new_chart'); ?>
                   </div>
                    <?php $this->load->view('dashboard/today'); ?>
                    <?php $this->load->view('dashboard/search'); ?>
                </div>

                    <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->