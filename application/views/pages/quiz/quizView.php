<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
            <small> <?php echo $subtitle; ?> </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>lectures">Lectures</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> <?php echo $title; ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <h1>Lecture: <?php echo $lecture->lecture_name?></h1>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Quiz Title</th>
                    <th>Quiz Time</th>
                    <th>Questions</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($quizzes as $quiz){?>
                    <tr>
                        <td><?php echo $quiz->quiz_title;?></td>
                        <td><?php echo $quiz->quiz_time;?></td>

                        <!--------------------------- QUESTIONS start----------------------->
                        <td>
                            <!--- View Question --->
                            <a class="btn btn-info"
                               href="<?php echo base_url();?>questions?quiz=<?php echo $quiz->quiz_id;?>">
                                View Questions
                            </a>

                            <!--- ADD question -->
                            <a class="addQuestion-link btn btn-primary"
                               data-id="<?php echo $quiz->quiz_id;?>"
                               data-toggle="modal" data-remote="true"  href="#addQuestionModal">
                                Add Question
                            </a>

                            <!---- ADD QUESTION MODAL----->
                            <div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="addQuestionModalLabel">Add Question</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open_multipart('Question/addQuestion','class="form" id="myform"');?>

                                            <input type="hidden" name="quiz_id" id="quiz_id" value="">

                                            <div class="form-group">
                                                <label for="question_text">Question:</label>
                                                <textarea class="form-control" type="text" name="question_text" id="question_text" maxlength="200" rows="3" required></textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="option_one">Option 1:</label>
                                                        <input class="form-control" type="text" name="option_one" id="option_one" required  value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="option_two">Option 2:</label>
                                                        <input class="form-control" type="text" name="option_two" id="option_two" required  value="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="option_three">Option 3:</label>
                                                        <input class="form-control" type="text" name="option_three" id="option_three" required  value="" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="option_four">Option 4:</label>
                                                        <input class="form-control" type="text" name="option_four" id="option_four" required  value="" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="correct_option">Select correct option:</label>
                                                <select class="form-control" name ="correct_option" id="correct_option">
                                                    <option value="option_one">Option One</option>
                                                    <option value="option_two">Option Two</option>
                                                    <option value="option_three">Option Three</option>
                                                    <option value="option_four">Option Four</option>
                                                </select>
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
                                $(document).on("click", ".addQuestion-link", function () {
                                    var quizID = $(this).data('id');
                                    $("#quiz_id").val(quizID);
                                });
                            </script>
                        </td>
                        <!----------------- QUESTIONS end----------------->

                        <td>
                            <!--------------------- EDIT---------------->
                            <!-- Setting quiz information to be displayed in edit form-->

                            <a class="edit-link btn btn-warning"
                               data-toggle="modal" data-remote="true"
                               data-id="<?php echo $quiz->quiz_id;?>"
                               data-title="<?php echo $quiz->quiz_title;?>"
                               data-time="<?php echo $quiz->quiz_time;?>"
                               data-duration="<?php echo $quiz->quiz_duration;?>"
                               href="#editQuizModal">
                                Edit
                            </a>

                            <!---------EDIT MODAL------------->
                            <div class="modal fade" id="editQuizModal" tabindex="-1" role="dialog" aria-labelledby="editQuizLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="editQuizLabel">Edit Quiz</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open_multipart('Quiz/editQuiz','class="form" id="myform"');?>

                                            <input type="hidden" name="quiz_ID" id="quiz_ID" value="">

                                            <input type="hidden" name="lecture_id" id="lecture_id" value="<?php echo $lecture->lecture_id?>">

                                            <div class="form-group">
                                                <label for="quiz_title">Quiz Title:</label>
                                                <input class="form-control" type="text" name="quiz_title" id="quiz_title"  value="" />
                                            </div>

                                            <!---------- QUIZ TIME ---------------->
                                            <div class="form-group">
                                                <label for="quiz_time">Quiz Time and Date:</label>
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
                                                <input class="form-control" type="text" name="quiz_duration" id="quiz_duration" required value="" />
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

                            <!-- Setting quiz information in edit form-->

                            <script>
                                $(document).on("click", ".edit-link", function () {
                                    var quiz_ID = $(this).data('id');
                                    var quiz_title = $(this).data('title');
                                    var quiz_time = $(this).data('time');
                                    var quiz_duration = $(this).data('duration');
                                    $("#quiz_ID").val(quiz_ID);
                                    $("#quiz_title").val(quiz_title);
                                    $("#quiz_time").val(quiz_time);
                                    $("#quiz_duration").val(quiz_duration);
                                });
                            </script>
                            <!---------EDIT MODAL------------->

                            <!--------------------- DELETE----------------->
                            <a class="delete-link btn btn-danger"
                               data-toggle="modal" data-remote="true"
                               data-id="<?php echo $quiz->quiz_id;?>"
                               data-lecture="<?php echo $lecture->lecture_id;?>"
                               href="#deleteQuizModal">
                                Delete
                            </a>
                            <!--------------------- Delete Quiz Modal ----------------->
                            <div class="modal fade" id="deleteQuizModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuizModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="deleteQuizModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure want to delete the quiz?
                                        </div>
                                        <div class="modal-footer">
                                            <a id = "inner-deleteLink" class="btn btn-danger" href="">Yes </a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).on("click", ".delete-link", function () {
                                    var quiz_id = $(this).data('id');
                                    var lecture_id = $(this).data('lecture');
                                    var link = document.getElementById("inner-deleteLink");
                                    link.setAttribute('href', "<?php echo base_url();?>quiz/delete?quiz_id=" + quiz_id + '&lecture_id=' +lecture_id);
                                });
                            </script>
                            <!--------------------- Delete Quiz Modal ----------------->
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

