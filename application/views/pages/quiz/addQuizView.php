<!---------------Page Heading--------------->
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>index.php/lectures">Lectures</a>
            </li>
            <li class="active">
                <i class="fa fa-plus"></i> <?php echo $subtitle; ?>
            </li>
        </ol>
    </div>
</div>

<?php echo form_open_multipart('Quiz/addQuiz', 'class="form" id="myform"');?>



</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->