<!---------------Page Heading--------------->

<style type="text/css">
    th{
        white-space: nowrap;
    }
    #edit-delete {
        width: 170px;
    }
    #quiz {
        width: 140px;
    }
    #ref {
        width: 140px;
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
                    <th>Lecture Date</th>
                    <th>Start-Time</th>
                    <th>End-Time</th>
                    <th>Quiz</th>
                    <th>Reference</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($lectures as $lecture){?>
                    <tr>
                        <td><?php echo $lecture->lecture_name;?></td>
                        <td><?php echo $lecture->course_name;?></td>
                        <td><?php echo $lecture->lecture_date;?></td>
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
                                Add
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

                                            <div class="form-group">
                                                <label for="quiz_title">Quiz Title:</label>
                                                <input class="form-control" type="text" name="quiz_title" id="quiz_title"  value="" />
                                            </div>

                                            <!---------- QUIZ TIME ---------------->
                                            <div class="form-group">
                                                <label for="quiz_time">Quiz Date and Time:</label>
                                            </div>
                                            <div class="form-group">
                                                <div class='input-group date' id='datetimepicker1'>
                                                    <input type='text' name='quiz_time' id="quiz_time" class="form-control" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>

                                        <script type="text/javascript">
                                            $(function () {
                                                $('#datetimepicker1').datetimepicker();
                                            });
                                        </script>

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
                               href="<?php echo base_url();?>quiz?lecture=<?php echo $lecture->lecture_id;?>">
                                View
                            </a>
                        </td>
                        <!-------------------------------- QUIZ end-------------------------------->

                        <!---------------------REFERENCE START---------------------->
                        <td id="ref">
                            <!---- ADD REFERENCE--->
                            <a class="addReference-link btn btn-info"
                               data-id="<?php echo $lecture->lecture_id;?>"
                               data-toggle="modal" data-remote="true"  href="#addReferenceModal">
                                Add
                            </a>

                            <!------ ADD REFERENCE MODAL ----->
                            <div class="modal fade" id="addReferenceModal" tabindex="-1" role="dialog" aria-labelledby="addReferenceModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="addReferenceModalLabel">Add Reference</h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php echo form_open_multipart('Lecture_Reference/addReference','class="form" id="myform"');?>

                                            <div class="form-group">
                                                <label for="lectureID">Lecture ID:</label>
                                                <input class="form-control" type="text" name="lectureID" id="lectureID" required readonly value="" />
                                            </div>

                                            <div class="form-group">
                                                <label for="type">Reference Type:</label>
                                                <select class="form-control" required id="type" name="type"><option value="">Please select type:</option>
                                                    <option value="lecture">Previous Lecture</option>
                                                    <option value="video">Video</option>
                                                    <option value="simulation">Simulation</option>
                                                </select>
                                            </div>

                                            <!------- REFERENCE DATE and TIME---------->
                                            <div class="form-group">
                                                <label for="lecture_date">Reference Date and Time</label>
                                                <div class='input-group date' id='datetimepicker5'>
                                                    <input type='text' name='time' id="time" required class="form-control" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>

                                                <script type="text/javascript">
                                                    $(function () {
                                                        $('#datetimepicker5').datetimepicker();
                                                    });
                                                </script>
                                            </div>
                                            <!------- REFERENCE DATE and TIME---------->

                                            <div class="form-group">
                                                <label for="prev_lectureID">Previous Lecture:</label>
                                                <select class="form-control"  id="prev_lectureID" name="prev_lectureID"><option value="">Please select</option>
                                                    <?php foreach($lectures_reference as $lecture_reference){?>
                                                        <option value="<?php echo $lecture_reference->lecture_id;?>"><?php echo $lecture_reference->lecture_name;?></option>
                                                    <?php }?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="link">Link (Video/Simulation):</label>
                                                    <textarea class="form-control" type="text" name="link" id="link" rows="2"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="fileToUpload">Select image to upload (Video/Simulation):</label>
                                                <input type="file"  name="image_Path" id="image_Path" />
                                            </div>

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
                                //Setting LECTURE ID in form
                                $(document).on("click", ".addReference-link", function () {
                                    var lectureID = $(this).data('id');
                                    $("#lectureID").val(lectureID);
                                });
                            </script>


                            <a class="btn btn-primary"
                               href="<?php echo base_url();?>lecture/edit?q=<?php echo $lecture->lecture_id;?>">
                                View
                            </a>
                        </td>
                        <!---------------------REFERENCE END---------------------->

                        <!---------------------EDIT/DELETE---------------------->
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
                        <!---------------------EDIT/DELETE---------------------->
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