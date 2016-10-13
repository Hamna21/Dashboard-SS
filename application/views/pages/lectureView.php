<!---------------Page Heading--------------->
<?php
if(isset($_SESSION['lectureRegister']))
{
    echo '<div class="alert alert-danger">';
    echo ' <strong>Failure!</strong> Unable to Register Lecture';
    echo '</div>';
    $this->session->unset_userdata('lectureRegister');
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
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
<div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url();?>index.php/lecture/add">New Lecture</a></div>

<div class="row">
    <div class="col-lg-12">
        <h2>Lectures</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Lecture ID</th>
                    <th>Lecture Name</th>
                    <th>Course</th>
                    <th>Lecture Description</th>
                    <th>Lecture Starting Time</th>

                </tr>
                </thead>

                <tbody>
                <?php foreach($lectures as $lecture){?>
                    <tr>

                        <td><?php echo $lecture['lecture_ID'];?></td>
                        <td><?php echo $lecture['lecture_Name'];?></td>
                        <td><?php echo $lecture['course_Name'];?></td>
                        <td><?php echo $lecture['lecture_Description'];?></td>
                        <td><?php echo $lecture['lecture_Time'];?></td>
                    </tr>
                <?php }?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<!-- /.row -->
<!-- Pagination -->
<div class="row">
    <div class="col-md-12 text-center">
        <?php echo $links ?>
    </div>
</div>


</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!--wrapper -->