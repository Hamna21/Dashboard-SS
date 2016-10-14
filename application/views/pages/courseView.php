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
</style>
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

<div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url();?>index.php/course/add">New Course</a></div>

<div class="row">
    <div class="col-lg-12">
        <h2>Courses</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Course ID</th>
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
                        <td><?php echo $course['course_ID'];?></td>
                        <td><?php echo $course['course_Name'];?></td>
                        <td><?php echo $course['course_Description'];?></td>
                        <td>
                            <a href="javascript:void(0);" onClick=window.open("http://localhost:8080/Dashboard-SS/","Ratting","width=550,height=170,0,status=0,");><?php echo $course['category_Name'];?></a>
                        </td>
                        <td>
                            <a data-toggle="modal" data-remote="true" href="#deleteProductModal">
                                <?php echo $course['teacher_Name'];?>
                            </a>
                        </td>
                        <td>
                            <?php
                            $config['source_image']= "localhost:8080/Dashboard-SS/uploads/".$course['course_Image'];
                            $this->image_lib->initialize($config);?>
                            <img src="<?php echo $this->image_lib->resize(); ?>">
                        </td>
                        <td>
                            <a class="btn btn-warning"
                               href="<?php echo base_url();?>index.php/Course/edit?q=<?php echo $course['course_ID'];?>">
                               Edit
                            </a>

                            <a class="delete-link btn btn-danger"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $course['course_ID'];?>" href="#deleteCourseModal">
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
                                    link.setAttribute('href', "http://localhost:8080/Dashboard-SS/index.php/course/delete?q=" + courseID);
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