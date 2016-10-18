<!---------------Page Heading--------------->
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
                    <th>Teacher  Name</th>
                    <th>Teacher Designation</th>
                    <th>Teacher Domain</th>
                    <th>Teacher Image</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($teachers as $teacher){?>
                    <tr>
                        <td><?php echo $teacher['teacher_Name'];?></td>
                        <td><?php echo $teacher['teacher_Designation'];?></td>
                        <td><?php echo $teacher['teacher_Domain'];?></td>
                        <td>
                            <img src="http://localhost:8080/Dashboard-SS/uploads/<?php echo $teacher['teacher_ThumbImage'];?>">
                        </td>
                        <td>
                            <a class="btn btn-warning"
                               href="<?php echo base_url();?>index.php/Teacher/edit?q=<?php echo $teacher['teacher_ID'];?>">
                                Edit
                            </a>
                            <a class="delete-link btn btn-danger"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $teacher['teacher_ID'];?>" href="#deleteteacherModal">
                                Delete
                            </a>
                            <!--------------------- Delete Teacher Modal ----------------->
                            <div class="modal fade" id="deleteteacherModal" tabindex="-1" role="dialog" aria-labelledby="deleteteacherModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="deleteteacherModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure want to delete the teacher?
                                        </div>
                                        <div class="modal-footer">
                                            <a id = "mylink" class="btn btn-danger" href="">Yes </a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).on("click", ".delete-link", function () {
                                    var teacherID = $(this).data('id');
                                    var link = document.getElementById("mylink");
                                    link.setAttribute('href', "http://localhost:8080/Dashboard-SS/index.php/teacher/delete?q=" + teacherID);
                                });
                            </script>
                            <!--------------------- Delete teacher Modal ----------------->
                        </td>


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