<!---------------Styling of Table--------------->
<style type="text/css">
    table {
        white-space: nowrap;
        overflow: hidden;
        width: 10px;
        height: 25px;
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
                    <th id="styling">Course ID</th>
                    <th id="styling">Course Name</th>
                    <th>Course Image</th>
                    <th>Course Description</th>
                    <th>Category</th>
                    <th>Teacher</th>
                    <th id="styling">Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($courses as $course){?>
                    <tr>
                        <td><?php echo $course['course_ID'];?></td>
                        <td><?php echo $course['course_Name'];?></td>
                        <td><?php echo $course['course_Image'];?></td>
                        <td><?php echo $course['course_Description'];?></td>
                        <td id="styling">
                            <a href="javascript:void(0);" onClick=window.open("http://localhost:8080/Dashboard-SS/","Ratting","width=550,height=170,0,status=0,");><?php echo $course['category_Name'];?></a>
                        </td>
                        <td id="styling">
                            <a data-toggle="modal" data-remote="true" href="#deleteProductModal">
                                <?php echo $course['teacher_Name'];?>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-warning"
                               href="<?php echo base_url();?>index.php/Course/edit?q=<?php echo $course['course_ID'];?>">
                               Edit
                            </a>

                            <a class="btn btn-danger"
                               data-toggle="modal" data-remote="true" href="#deleteCourseModal">
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
                                            <p id="checking"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button id ="deleteCourseButton" type="button" class="btn btn-danger">Yes</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--------------------- Delete Course Modal ----------------->

                            <script>
                                $("#deleteCourseButton").click(function(){

                                    var xmlhttp = new XMLHttpRequest();
                                    xmlhttp.onreadystatechange = function() {
                                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                        {
                                            document.getElementById("checking").innerHTML = xmlhttp.responseText;
                                            // $("#deleteCourseModal .close").click();
                                        }
                                    };
                                    xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS/index.php/Course/deleteCourse?q=" + <?php echo $course['course_ID'] ?>, true);
                                    xmlhttp.send();
                                });
                            </script>

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