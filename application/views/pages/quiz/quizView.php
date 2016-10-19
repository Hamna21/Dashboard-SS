<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
            <small> <?php echo $subtitle; ?> </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>index.php/dashboard">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> <?php echo $title; ?>
            </li>
        </ol>
    </div>
</div>
