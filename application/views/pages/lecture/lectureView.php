<!---------------Page Heading--------------->

<style type="text/css">
    th{
        white-space: nowrap;
    }
    #lec_desc {
        width: 300px;
    }
    #edit-delete {
        width: 170px;
    }
    #quiz {
        width: 250px;
    }

</style>
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
<div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url();?>lecture/add">New Lecture</a></div>

<div class="row">
    <div class="col-lg-12">
        <h2>Lectures</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Lecture Name</th>
                    <th>Course</th>
                    <th>Lecture Description</th>
                    <th>Start-Time</th>
                    <th>End-Time</th>
                    <th>Quiz</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($lectures as $lecture){?>
                    <tr>
                        <td><?php echo $lecture->lecture_name;?></td>
                        <td><?php echo $lecture->course_name;?></td>
                        <td id="lec_desc"><?php echo $lecture->lecture_description;?></td>
                        <td id="time"><?php echo $lecture->lecture_start;?></td>
                        <td id="time"><?php echo $lecture->lecture_end;?></td>

                        <!-------------------------------- QUIZ start-------------------------------->
                        <td id="quiz">
                            <!---- ADD QUIZ--->
                            <a class="addQuiz-link btn btn-primary"
                               data-id="<?php echo $lecture->lecture_id;?>"
                               data-lecture="<?php echo $lecture->lecture_name;?>"
                               data-course ="<?php echo $lecture->course_name;?>"
                               data-toggle="modal" data-remote="true"  href="#addQuizModal">
                                Add Quiz
                            </a>

                            <!------ ADD QUIZ MODAL ----->
                            <div class="modal fade" id="addQuizModal" tabindex="-1" role="dialog" aria-labelledby="addQuizModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="addQuizModalLabel">Add Quiz</h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open_multipart('Quiz/addQuiz','class="form" id="myform"');?>

                                            <input type="hidden" name="lecture_id" id="lecture_id" value="">

                                            <div class="form-group">
                                                <label for="course_name">Course Name:</label>
                                                <input class="form-control" type="text" name="course_name" id="course_name" required readonly value="" />
                                            </div>

                                            <div class="form-group">
                                                <label for="lecture_name">Lecture Name:</label>
                                                <input class="form-control" type="text" name="lecture_name" id="lecture_name" required readonly value="" />
                                            </div>

                                            <!---------- QUIZ TIME ---------------->
                                            <div class="form-group">
                                                <label for="quiz_time">Quiz Time:</label>
                                            </div>
                                            <div class="row">
                                                <div class='col-sm-6'>
                                                    <div class="form-group">
                                                        <div class='input-group date' id='datetimepicker3'>
                                                            <input type='text' class="form-control" />
                                                            <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                         </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script type="text/javascript">
                                                    $(function () {
                                                        $('#datetimepicker3').datetimepicker({
                                                            format: 'LT'
                                                        });
                                                    });
                                                </script>
                                                <div class='col-sm-6'>
                                                    <div class="form-group">
                                                        <div class='input-group date' id='datetimepicker1'>
                                                            <input type='text' name='quiz_time' id="quiz_time" class="form-control" />
                                                            <span class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script type="text/javascript">
                                                    $(function () {
                                                        $('#datetimepicker1').datetimepicker();
                                                    });
                                                </script>
                                            </div>
                                            <!---------- QUIZ TIME ---------------->

                                            <!---------- QUIZ DURATION---------------->
                                            <div class="form-group">
                                                <label for="quiz_duration">Quiz Duration:</label>
                                                <input class="form-control" type="text" name="quiz_duration" id="quiz_duration" required placeholder="00:10:00" value="" />
                                            </div>
                                            <!---------- QUIZ DURATION---------------->





                                            <input type="submit" name="commit" value="Submit" class="btn btn-default btn-success" />
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Discard</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).on("click", ".addQuiz-link", function () {
                                    var lectureID = $(this).data('id');
                                    var lecture_name = $(this).data('lecture');
                                    var course_name = $(this).data('course');
                                    $("#lecture_id").val(lectureID);
                                    $("#lecture_name").val(lecture_name);
                                    $("#course_name").val(course_name);
                                });
                            </script>
                            <!--------------------------->


                            <!---- VIEW QUIZ--->
                            <a class="btn btn-primary"
                               href="<?php echo base_url();?>quiz/view?lecture=<?php echo $lecture->lecture_id;?>">
                                View Quizzes
                            </a>
                        </td>
                        <!-------------------------------- QUIZ end-------------------------------->

                        <td id="edit-delete">
                            <a class="btn btn-warning"
                               href="<?php echo base_url();?>lecture/edit?q=<?php echo $lecture->lecture_id;?>">
                                Edit
                            </a>

                            <a class="delete-link btn btn-danger"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $lecture->lecture_id;?>" href="#deletelectureModal">
                                Delete
                            </a>
                            <!--------------------- Delete Lecture Modal ----------------->
                            <div class="modal fade" id="deletelectureModal" tabindex="-1" role="dialog" aria-labelledby="deletelectureModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="deletelectureModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure want to delete the lecture?
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
                                    var lectureID = $(this).data('id');
                                    var link = document.getElementById("mylink");
                                    link.setAttribute('href', "<?php echo base_url()?>lecture/delete?q=" + lectureID);
                                });
                            </script>
                            <!--------------------- Delete lecture Modal ----------------->
                            
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