<!---------------Page Heading--------------->
<?php
if(isset($_SESSION['TeacherRegister']))
{
    echo '<div class="alert alert-danger">';
    echo ' <strong>Failure!</strong> Unable to Register Teacher';
    echo '</div>';
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



<div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url();?>index.php/teacher/add">New Teacher</a></div>

<div class="row">
    <div class="col-lg-12">
        <h2>Teachers</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Teacher ID</th>
                    <th>Teacher  Name</th>
                    <th>Teacher Designation</th>
                    <th>Teacher Domain</th>
                    <th>Teacher Image</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($teachers as $teacher){?>
                    <tr>
                        <td><?php echo $teacher['teacher_ID'];?></td>
                        <td><?php echo $teacher['teacher_Name'];?></td>
                        <td><?php echo $teacher['teacher_Designation'];?></td>
                        <td><?php echo $teacher['teacher_Domain'];?></td>
                        <td><?php echo $teacher['teacher_Image'];?></td>

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