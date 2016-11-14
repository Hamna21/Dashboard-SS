<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
            <small> <?php echo $subtitle; ?> </small>
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

<div class="row">
    <div class="col-lg-12">
        <h2>Question</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Question ID</th>
                    <th>View Question</th>
                    <th>Delete Question</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($questions as $question){?>
                    <tr>
                        <td><?php echo $question->question_id;?></td>
                        <!--- View Question - setting attributes -->
                        <td>
                            <a class="view-question btn btn-info"
                               data-toggle="modal" data-remote="true"
                               data-text="<?php echo $question->question_text;?>"
                               data-option1 ="<?php echo $question->option_one;?>"
                               data-option2 ="<?php echo $question->option_two?>"
                               data-option3 ="<?php echo $question->option_three?>"
                               data-option4 ="<?php echo $question->option_four?>"
                               data-correct ="<?php echo $question->correct_option?>"
                               href="#viewQuestionModal">
                                View Question
                            </a>

                            <!--------------------- View Question Modal ----------------->
                            <div class="modal fade" id="viewQuestionModal" tabindex="-1" role="dialog" aria-labelledby="viewQuestionModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="viewQuestionModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            <strong><p id="text"></p></strong>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p id ="option1"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p id ="option2"></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p id ="option3"></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p id ="option4"></p>
                                                </div>
                                            </div>

                                            <strong>Correct Option:</strong><p id="correct"></p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).on("click", ".view-question", function () {
                                    var questionText = $(this).data('text');
                                    var option1 = $(this).data('option1');
                                    var option2 = $(this).data('option2');
                                    var option3 = $(this).data('option3');
                                    var option4 = $(this).data('option4');
                                    var correct = $(this).data('correct');
                                    document.getElementById("text").innerHTML = questionText;
                                    document.getElementById("option1").innerHTML = option1;
                                    document.getElementById("option2").innerHTML = option2;
                                    document.getElementById("option3").innerHTML = option3;
                                    document.getElementById("option4").innerHTML = option4;
                                    document.getElementById("correct").innerHTML = correct;
                                });
                            </script>
                            <!--------------------- View Question Modal ----------------->
                        </td>

                        <td>
                            <a class="delete-question btn btn-danger"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $question->question_id;?>" href="#deleteQuestionModal">
                                Delete Question
                            </a>
                            <!--------------------- Delete Quiz Modal ----------------->
                            <div class="modal fade" id="deleteQuestionModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="deleteQuestionModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure want to delete the question?
                                        </div>
                                        <div class="modal-footer">
                                            <a id = "delete-link" class="btn btn-danger" href="">Yes </a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).on("click", ".delete-question", function () {
                                    var questionID = $(this).data('id');
                                    var link = document.getElementById("delete-link");
                                    link.setAttribute('href', "<?php echo base_url();?>question/delete?q=" + questionID);
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

