<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
            <small> <?php echo $subtitle; ?> </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>dashboard">Lectures</a>
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
                    <th>Quiz ID</th>
                    <th>Quiz Time</th>
                    <th>Questions</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($quizzes as $quiz){?>
                    <tr>
                        <td><?php echo $quiz->quiz_id;?></td>
                        <td><?php echo $quiz->quiz_time;?></td>
                        <!--------------------------- QUESTIONS start----------------------->
                        <td>
                            <!--- View Question --->
                            <a class="btn btn-info"
                               href="<?php echo base_url();?>Question/view?quiz=<?php echo $quiz->quiz_id;?>">
                                View Questions
                            </a>

                            <!--- ADD question -->
                            <a class="addQuestion-link btn btn-primary" data-id="<?php echo $quiz->quiz_id;?>"
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
                                                <input class="form-control" type="text" name="question_text" id="question_text" required  value="" />
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
                            <a class="btn btn-warning"
                               href="<?php echo base_url();?>Quiz/edit?q=<?php echo $quiz->quiz_id;?>">
                                Edit
                            </a>

                            <a class="delete-link btn btn-danger"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $quiz->quiz_id;?>" href="#deleteQuizModal">
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
                                            <a id = "mylink" class="btn btn-danger" href="">Yes </a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).on("click", ".delete-link", function () {
                                    var quizID = $(this).data('id');
                                    var link = document.getElementById("mylink");
                                    link.setAttribute('href', "<?php echo base_url();?>quiz/delete?q=" + quizID);
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

