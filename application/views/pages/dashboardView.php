<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
            <small> <?php echo $subtitle; ?> </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>dashboard">Dashboard</a>
            </li>
        </ol>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Course</th>
                    <th>Category</th>
                    <th>Teacher</th>
                    <th>Lecture</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $courseTotal; ?></td>
                        <td><?php echo $categoryTotal; ?></td>
                        <td><?php echo $teacherTotal; ?></td>
                        <td><?php echo $lectureTotal; ?></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <div><a class="btn btn-default btn-success" href="<?php echo base_url();?>course/add">New Course</a></div>
    </div>
    <div class="col-lg-3">
        <div><a class="btn btn-default btn-success" href="<?php echo base_url();?>category/add">New Category</a></div>
    </div>
    <div class="col-lg-3">
        <div><a class="btn btn-default btn-success" href="<?php echo base_url();?>teacher/add">New Teacher</a></div>
    </div>
    <div class="col-lg-3">
        <div><a class="btn btn-default btn-success" href="<?php echo base_url();?>lecture/add">New Lecture</a></div>
    </div>
</div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->