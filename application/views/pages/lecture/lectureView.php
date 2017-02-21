<!---------------Page Heading--------------->
<style type="text/css">
    th{
        white-space: nowrap;
    }
    #course {
        width: 130px;
    }
    #edit-delete {
        width: 180px;
    }
    #quiz {
        width: 180px;
    }
    #ref {
        width: 160px;
    }
    #date-helper {
        height: 30px;
        position: relative;
        border: 2px solid #cdcdcd;
        border-color: rgba(0,0,0,.14);
        background-color: AliceBlue;
        font-size: 14px;
    }
    #onSubmit{
        background:white;
        width : 80%;
        height : 80%;
        position: absolute;
        z-index: 5;
        opacity: 0.8;
        /*transform: translate(2px, -2px);*/
    }
    #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .closebtn {
        margin-right: 15px;
        color: darkgreen;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }
    .closebtn:hover {
        color: black;
    }
    #myProgress {
        width: 100%;
        background-color: grey;
    }
    #myBar {
        width: 1%;
        height: 30px;
        background-color: green;
        text-align: center;
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


<!--Display loader when video starts uploading-->
<div style="display:none;" id="onSubmit">
    <div id="loader"></div>
</div>


<!------Success Alert message when video upload successfully--->
<div style="display:none;" id="alert-success" class="alert alert-success">
    <span class="closebtn">&times;</span>
    <strong>Success!</strong> Video uploaded successfully.
</div>

<!------Warning when video didn't upload--->
<div style="display:none;" id="alert-warning" class="alert alert-warning">
    <span class="closebtn">&times;</span>
    <strong>Warning!</strong> Error in uploading video.
</div>


<?php if($this->session->user_type == "admin") { ?>
    <div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url(); ?>lecture/add">New Lecture</a></div>
    <?php
}
?>


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
                    <?php if($this->session->user_type == "teacher")
                    {
                        echo '<th>Comments</th>';
                    }
                    else
                    {
                        echo '<th>Quiz</th>';
                        echo '<th>Reference</th>';
                        echo '<th>Lecture Video</th>';
                        echo '<th>Edit/Delete</th> ';
                    }
                    ?>

                </tr>
                </thead>

                <tbody>
                <?php foreach($lectures as $lecture)
                {?>
                    <tr>
                        <td><?php echo $lecture->lecture_name;?></td>
                        <td id="course"><?php echo $lecture->course_name;?></td>
                        <td><?php echo $lecture->lecture_date;?></td>
                        <td><?php echo $lecture->lecture_start;?></td>
                        <td><?php echo $lecture->lecture_end;?></td>

                        <?php if($this->session->user_type == "admin")
                        {
                            ?>
                            <!------------------- QUIZ start-------------->
                            <td id="quiz">
                                <!---- ADD QUIZ--->
                                <a class="addQuiz-link btn btn-primary"
                                   data-id="<?php echo $lecture->lecture_id; ?>"
                                   data-lecture="<?php echo $lecture->lecture_name; ?>"
                                   data-course="<?php echo $lecture->course_name; ?>"
                                   data-toggle="modal" data-remote="true" href="#addQuizModal">
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
                                                <?php echo form_open_multipart('Quiz/addQuiz', 'class="form" id="myform"');?>

                                                <input type="hidden" name="lecture_id" id="lecture_id" value=""/>

                                                <div class="form-group">
                                                    <label for="course_name">Course Name:</label>
                                                    <input class="form-control" type="text" name="course_name" id="course_name" required readonly value=""/>
                                                </div>

                                                <div class="form-group">
                                                    <label for="lecture_name">Lecture Name:</label>
                                                    <input class="form-control" type="text" name="lecture_name" id="lecture_name" required readonly value=""/>
                                                </div>

                                                <div class="form-group">
                                                    <label for="quiz_title">Quiz Title:</label>
                                                    <input class="form-control" type="text" name="quiz_title" id="quiz_title" value=""/>
                                                </div>

                                                <!---------- QUIZ TIME ---------------->
                                                <div class="form-group">
                                                    <label for="quiz_time">Quiz Date and Time:</label>
                                                </div>
                                                <div class="form-group">
                                                    <div class='input-group date' id='datetimepicker1'>
                                                        <input type='text' name='quiz_time' id="quiz_time" class="form-control"/>
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
                                                    <input class="form-control" type="text" name="quiz_duration" id="quiz_duration" required placeholder="00:10:00" value=""/>
                                                </div>
                                                <!---------- QUIZ DURATION---------------->
                                                <input type="submit" name="commit" value="Submit" class="btn btn-default btn-success"/>
                                                </form>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                    Discard
                                                </button>
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
                                   href="<?php echo base_url(); ?>quiz?lecture=<?php echo $lecture->lecture_id; ?>">
                                    View
                                </a>
                            </td>
                            <!------------------- QUIZ end----------------->

                            <!---------------------REFERENCE START---------------------->
                            <td id="ref">
                                <!---- ADD REFERENCE--->
                                <a class="addReference-link btn btn-info"
                                   data-id="<?php echo $lecture->lecture_id; ?>"
                                   data-date="<?php echo $lecture->lecture_date; ?>"
                                   data-start="<?php echo $lecture->lecture_start; ?>"
                                   data-end="<?php echo $lecture->lecture_end; ?>"
                                   data-toggle="modal" data-remote="true" href="#addReferenceModal">
                                    Add
                                </a>

                                <!------ ADD REFERENCE MODAL ----->
                                <div class="modal fade" id="addReferenceModal" tabindex="-1" role="dialog"
                                     aria-labelledby="addReferenceModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="addReferenceModalLabel">Add Reference</h4>
                                            </div>

                                            <div class="modal-body">
                                                <?php echo form_open_multipart('Lecture_Reference/addReference', 'class="form" id="myform"'); ?>

                                                <div class="form-group">
                                                    <label for="lectureID">Lecture ID:</label>
                                                    <input class="form-control" type="text" name="lectureID"
                                                           id="lectureID" required readonly value=""/>
                                                </div>

                                                <input type="hidden" name="date" id="date" required value=""/>
                                                <input type="hidden" name="start_time" id="start_time" required
                                                       value=""/>


                                                <!-----------------------MINUTE AND SECOND CALCULATOR---------------------->
                                                <div class="form-group">
                                                    <label for="lecture_date">Reference Date and Time:</label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <textarea
                                                                id="date-helper"><?php echo $lecture->lecture_date ?></textarea>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-control" required id="minute"
                                                                    name="minute">
                                                                <option value="">Minute:</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-control" required id="second"
                                                                    name="second">
                                                                <option value="">Second:</option>
                                                                <?php for ($sec = 0; $sec <= 60; $sec++) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $sec ?>"><?php echo $sec ?></option>
                                                                    <?php
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-----------------------MINUTE AND SECOND CALCULATOR---------------------->

                                                <!-----REFERENCE TYPE----->
                                                <div class="form-group">
                                                    <label for="type">Reference Type:</label>
                                                    <input type="radio" value="lecture" name="type" id="lectureCheck"/>Lecture
                                                    <input type="radio" value="video" name="type" id="videoCheck"/>Video
                                                    <input type="radio" value="simulation" name="type"
                                                           id="simulationCheck"/>Simulation
                                                </div>

                                                <!--------HIDING/SHOWING DIV BASED ON TYPE SELECTION------------>
                                                <script>
                                                    $(document).ready(function () {
                                                        $("#lectureCheck").click(function () {
                                                            $("#ifLectureReference").fadeIn();
                                                            $("#ifVidSimuReference").fadeOut("fast");
                                                        });
                                                        $("#videoCheck, #simulationCheck").click(function () {
                                                            $("#ifVidSimuReference").fadeIn();
                                                            $("#ifLectureReference").fadeOut("fast");
                                                        });
                                                    });
                                                </script>
                                                <!-----REFERENCE TYPE----->


                                                <div id="ifLectureReference" style="display: none">
                                                    <div class="form-group">
                                                        <label for="prev_lectureID">Previous Lecture:</label>
                                                        <select class="form-control" id="prev_lectureID"
                                                                name="prev_lectureID">
                                                            <option value="">Please select</option>
                                                            <?php foreach ($lectures_reference as $lecture_reference) { ?>
                                                                <option
                                                                    value="<?php echo $lecture_reference->lecture_id; ?>"><?php echo $lecture_reference->lecture_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="ifVidSimuReference" style="display: none">
                                                    <div class="form-group">
                                                        <label for="link">Link (Video/Simulation):</label>
                                                        <textarea class="form-control" type="text" name="link" id="link"
                                                                  rows="2"></textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fileToUpload">Select image to upload
                                                            (Video/Simulation):</label>
                                                        <input type="file" name="image_Path" id="image_Path"/>
                                                    </div>
                                                </div>

                                                <input type="submit" name="commit" value="Submit"
                                                       class="btn btn-default btn-success"/>
                                                </form>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">
                                                    Discard
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    //Setting LECTURE ID in form
                                    $(document).on("click", ".addReference-link", function () {
                                        var lectureID = $(this).data('id');
                                        $("#lectureID").val(lectureID);

                                        //-------------Calculating duration of lecture in minutes - via JAVASCRIPT----------------//
                                        var lecture_date = $(this).data('date');
                                        var lecture_start = $(this).data('start');
                                        var lecture_end = $(this).data('end');

                                        $("#date").val(lecture_date);
                                        $("#start_time").val(lecture_start);

                                        var start = lecture_date + " " + lecture_start;
                                        var end = lecture_date + " " + lecture_end;

                                        start = new Date(start);
                                        end = new Date(end);

                                        var diff = (end.getTime() - start.getTime()) / 1000;
                                        diff /= 60;
                                        var minutes = Math.abs(Math.round(diff));

                                        var min = 0,
                                            max = minutes,
                                            select = document.getElementById('minute');

                                        for (var i = min; i <= max; i++) {
                                            var opt = document.createElement('option');
                                            opt.value = i;
                                            opt.innerHTML = i;
                                            select.appendChild(opt);
                                        }

                                        //-------------Calculating duration of lecture in minutes - via PHP----------------//
                                        /*var xmlhttp = new XMLHttpRequest();
                                         xmlhttp.onreadystatechange = function() {
                                         if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                                         {
                                         document.getElementById("categoryName_Error").innerHTML = xmlhttp.responseText;
                                         }
                                         };
                                         xmlhttp.open("GET", "http://localhost:8080/Dashboard-SS-v2/Lecture/minuteCalculator?lecture_start=" + lecture_start + "&lecture_end=" + lecture_end, true);
                                         xmlhttp.send();*/
                                    });
                                </script>

                                <!---------------------- VIEW REFERENCE--------------------------------------->

                                <a class="btn btn-primary"
                                   href="<?php echo base_url(); ?>reference?lecture_id=<?php echo $lecture->lecture_id; ?>">
                                    View
                                </a>
                            </td>
                            <!---------------------REFERENCE END------------------------>

                            <!---------------------LECTURE VIDEO------------------------>
                            <td>
                                <a class="add-video btn btn-info"
                                   data-toggle="modal" data-remote="true" data-id="<?php echo $lecture->lecture_id; ?>"
                                   href="#addVideoModal">
                                    Add Video
                                </a>
                                <!--------------------- Add Video Modal ----------------->
                                <div class="modal fade" id="addVideoModal" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="addVideoModalLabel">Video Upload</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="upload" action="" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" id="lecture_video">
                                                    <label for="videoToUpload">Select video to upload:</label>
                                                    <input type="file"  name="video_path" id="video_path" required />
                                                    <br>
                                                    <button type="button" id="btn_upload" class="btn btn-success">Upload</button>

                                                </form>

                                                <!-----Progress Bar---->
                                                <div style="display:none;" id="progress-bar" class="progress">
                                                    <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                                <div style="display:none;" id="myProgress">
                                                    <div id="myBar"></div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Exit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!---------------------LECTURE VIDEO------------------------>

                            <!---------------------EDIT/DELETE-------------------------->
                            <td id="edit-delete">
                                <a class="btn btn-warning"
                                   href="<?php echo base_url(); ?>lecture/edit?q=<?php echo $lecture->lecture_id; ?>">
                                    Edit
                                </a>

                                <a class="delete-link btn btn-danger"
                                   data-toggle="modal" data-remote="true" data-id="<?php echo $lecture->lecture_id; ?>"
                                   href="#deletelectureModal">
                                    Delete
                                </a>
                                <!--------------------- Delete Lecture Modal ----------------->
                                <div class="modal fade" id="deletelectureModal" tabindex="-1" role="dialog"
                                     aria-labelledby="deletelectureModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="deletelectureModalLabel">Confirm Delete</h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure want to delete the lecture?
                                            </div>
                                            <div class="modal-footer">
                                                <a id="mylink" class="btn btn-danger" href="">Yes </a>
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">No
                                                </button>
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
                            <!---------------------EDIT/DELETE-------------------------->
                            <?php
                        } //If ending
                        else
                        {
                            //If admin = teacher, show comments of lecture
                            ?>
                            <td><a class="btn btn-default btn-success" href="<?php echo base_url();?>lecture/comments?lecture_id=<?php echo $lecture->lecture_id?>&lecture_name=<?php echo $lecture->lecture_name?>">
                                    Comments
                                </a>
                            </td>
                         <?php
                        }?>
                    </tr>
                <?php //For loop ending
                }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.row -->

<!-------------Uploading Video JS-------------------------->
<script>
    $(document).ready(function(){
        //Alert message close button
        $('.closebtn').click(function(e){
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function(){ div.style.display = "none"; }, 600);
        });

        //Setting lecture id on click of add video button
        $('.add-video').click(function(e){
            var lecture_id = $(this).data('id');
            $("#lecture_video").val(lecture_id);
        });

        //Uploading video
        $('#btn_upload').click(function(e){
            var videoSelect = document.getElementById('video_path');
            var uploadButton = document.getElementById("btn_upload");
            var progress_bar = document.getElementById("progress-bar");
            var videoProgress = document.getElementById("myProgress");
            var bar = document.getElementById("myBar");

            if(videoSelect.checkValidity() == true)
            {
                var lecture_id = document.getElementById('lecture_video').value;
                document.getElementById("onSubmit").style.display = "block";
                uploadButton.innerHTML = 'Uploading...';

                var video = videoSelect.files[0];
                var data = new FormData();
                data.append('video_path', video);


                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'http://localhost:8080/Second-Screen-API-v3/Helper/videoUpload?lecture_id='+lecture_id, true);

                //Upload progress
                xhr.upload.addEventListener("progress", function(evt){
                   // document.getElementById("progress-bar").style.display = "block";
                    document.getElementById("myProgress").style.display = "block";
                    if (evt.lengthComputable)
                    {
                        var percentComplete = parseInt((evt.loaded / evt.total) * 100);
                        //progress_bar.innerHTML =percentComplete + "%";
                        //progress_bar.style.width = percentComplete + "%";
                        bar.innerHTML =percentComplete + "%";
                        bar.style.width = percentComplete + "%";
                    }
                }, false);

                // When the request has completed (either in success or failure).
                xhr.upload.addEventListener('loadend', function(e) {
                    uploadButton.innerHTML = 'Uploaded...';
                    bar.innerHTML = "Processing Video....";

                });


                // the transfer has completed and the server closed the connection.
                xhr.onreadystatechange = function()
                {
                   //Hiding the loader and modal after video upload process
                    document.getElementById("onSubmit").style.display = "none";
                    uploadButton.innerHTML = 'Upload';
                    videoSelect.value= "";
                    $("#addVideoModal .close").click();

                    if (xhr.status == 200)
                    {
                        document.getElementById("alert-success").style.display = "block";
                    }
                    else
                    {
                        document.getElementById("alert-warning").style.display = "block";
                    }
                };



                //Send the Data.
                xhr.send(data);
            }
        });
    });
</script>

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