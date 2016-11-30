<!---------------Styling of Table--------------->
<style type="text/css">
    /*table {
        white-space: nowrap;
        overflow: hidden;
        width: 10px;
        height: 25px;
    }*/
    th{
        white-space: nowrap;
    }
    #course_desc {
        width: 500px;
    }
    #edit-delete {
        width: 170px;
    }
    #course_teach {
        width: 150px;
    }
    #course_thumb {
        width: 75px;
    }
</style>


<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>dashboard">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> <?php echo $title; ?>
            </li>
        </ol>
    </div>
</div>

<div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url();?>course/add">New Course</a></div>

<div class="row">
    <div class="col-lg-12">
        <h2>Courses</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Course Description</th>
                    <th>Category</th>
                    <th>Teacher</th>
                    <th>Course Image</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($courses as $course){?>
                    <tr>
                        <td id="course_name"><?php echo $course->course_name;?></td>
                        <td id="course_desc"><?php echo $course->course_description;?></td>
                        <td><?php echo $course->category_name;?></td>

                        <td id ="course_teach">
                            <a class="viewTeacher" data-toggle="modal"
                               data-designation="<?php echo $course->teacher_designation?>"
                               data-name="<?php echo $course->teacher_name?>"
                               data-domain="<?php echo $course->teacher_domain?>"
                               data-remote="true" href="#teacherModal">
                                <?php echo $course->teacher_name;?>
                            </a>


                            <!--- TEACHER MODAL -->
                            <div class="modal fade" id="teacherModal" tabindex="-1" role="dialog" aria-labelledby="teacherModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="teacherModalLabel">Teacher</h4>
                                        </div>
                                        <div class="modal-body">
                                            <strong>Teacher Name:</strong><p id="teacher_name"></p>
                                            <strong>Designation:</strong><p id="teacher_designation"></p>
                                            <strong>Domain:</strong><p id="teacher_domain"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).on("click", ".viewTeacher", function () {
                                    var teacher_name = $(this).data('name');
                                    var teacher_designation = $(this).data('designation');
                                    var teacher_domain = $(this).data('domain');
                                    document.getElementById("teacher_name").innerHTML = teacher_name;
                                    document.getElementById("teacher_designation").innerHTML = teacher_designation;
                                    document.getElementById("teacher_domain").innerHTML = teacher_domain;
                                });
                            </script>
                            <!--- TEACHER MODAL -->

                        </td>
                        <td id="course_thumb">
                            <img src="http://cte.itu.edu.pk/second_screen_api/uploads/<?php echo $course->course_thumbimage;?>">
                        </td>
                        <td id="edit-delete">
                            <a class="btn btn-warning"
                               href="<?php echo base_url();?>Course/edit?q=<?php echo $course->course_id;?>">
                               Edit
                            </a>

                            <a class="delete-link btn btn-danger"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $course->course_id;?>" href="#deleteCourseModal">
                                Delete
                            </a>
                                <!--------------------- Delete Course Modal ----------------->
                                <div class="modal fade" id="deleteCourseModal" tabindex="-1" role="dialog" aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="deleteCourseModalLabel">Confirm Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure want to delete the course?
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
                                    var courseID = $(this).data('id');
                                    var link = document.getElementById("mylink");
                                    link.setAttribute('href', "<?php echo base_url()?>course/delete?q=" + courseID);
                                });
                            </script>
                                <!--------------------- Delete Course Modal ----------------->
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