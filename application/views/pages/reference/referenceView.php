<style type="text/css">
    #date-helper {
        height: 30px;
        position: relative;
        border: 2px solid #cdcdcd;
        border-color: rgba(0,0,0,.14);
        background-color: AliceBlue ;   ;
        font-size: 14px;
    }
</style>

<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo " References of Lecture: " . $lecture->lecture_name ; ?>
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

<!------------------------- ADD REFERENCE--------------------->
<div class="pull-right ">
    <a class="addReference-link btn btn-success"
       data-id="<?php echo $lecture->lecture_id;?>"
       data-date="<?php echo $lecture->lecture_date;?>"
       data-start="<?php echo $lecture->lecture_start;?>"
       data-end="<?php echo $lecture->lecture_end;?>"
       data-toggle="modal" data-remote="true"  href="#addReferenceModal">
        New Reference
    </a>
</div>

<!----------------------ADD REFERENCE MODAL--------------------------------------->
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

                <input type="hidden" name="date" id="date" required value="" />
                <input type="hidden" name="start_time" id="start_time" required value="" />


                <!-----------------------MINUTE AND SECOND CALCULATOR---------------------->
                <div class="form-group">
                    <label for="lecture_date">Reference Date and Time:</label>
                    <div class="row">
                        <div class="col-md-4">
                            <textarea id="date-helper"><?php echo $lecture->lecture_date?></textarea>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" required id="minute" name="minute"><option value="">Minute:</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" required id="second" name="second"><option value="">Second:</option>
                                <?php for($sec=0; $sec<=60; $sec++)
                                {?>
                                    <option value="<?php echo $sec?>"><?php echo $sec?></option>
                                    <?php
                                }?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-----REFERENCE TYPE----->
                <div class="form-group">
                    <label for="type">Reference Type:</label>
                    <input type="radio" value="lecture" name="type" id="lectureCheck"/>Lecture
                    <input type="radio" value="video" name="type" id="videoCheck"/>Video
                    <input type="radio" value="simulation" name="type" id="simulationCheck"/>Simulation
                </div>

               <!--------HIDING/SHOWING DIV BASED ON TYPE SELECTION------------>
                <script>
                    $(document).ready(function(){
                        $("#lectureCheck").click(function(){
                            $("#ifLectureReference").fadeIn();
                            $("#ifVidSimuReference").fadeOut("fast");
                        });
                        $("#videoCheck, #simulationCheck").click(function(){
                            $("#ifVidSimuReference").fadeIn();
                            $("#ifLectureReference").fadeOut("fast");
                        });
                    });
                </script>
                <!-----REFERENCE TYPE----->

                <div id="ifLectureReference" style="display: none">
                    <div class="form-group">
                        <label for="prev_lectureID">Previous Lecture:</label>
                        <select class="form-control"  id="prev_lectureID" name="prev_lectureID"><option value="">Please select</option>
                            <?php foreach($lectures_reference as $lecture_reference){?>
                                <option value="<?php echo $lecture_reference->lecture_id;?>"><?php echo $lecture_reference->lecture_name;?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <div id="ifVidSimuReference" style="display: none">
                    <div class="form-group">
                        <label for="link">Link (Video/Simulation):</label>
                        <textarea class="form-control" type="text" name="link" id="link" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="fileToUpload">Select image to upload (Video/Simulation):</label>
                        <input type="file"  name="image_Path" id="image_Path" />
                    </div>
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
    $(document).on("click", ".addReference-link", function ()
    {
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

        var diff =(end.getTime() - start.getTime())/1000;
        diff /= 60;
        var minutes =  Math.abs(Math.round(diff));

        var min = 0,
            max = minutes,
            select = document.getElementById('minute');

        for (var i = min; i<=max; i++){
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = i;
            select.appendChild(opt);
        }

    });
</script>
<!----------------------ADD REFERENCE MODAL--------------------------------------->


<div class="row">
    <div class="col-lg-12">
        <h1></h1>
        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Reference Type</th>
                    <th>Reference Time</th>
                    <th>Reference Value</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($references as $reference){?>
                <tr>
                    <td><?php echo $reference->type;?></td>
                    <td><?php echo $reference->time;?></td>
                    <td><?php echo $reference->value;?></td>

                    <!------------  EDIT/DELETE--------------------->
                    <td>
                        <!--------------------- EDIT---------------->
                        <!-- Setting reference information to be displayed in edit form-->

                        <a class="edit-link btn btn-warning"
                           data-toggle="modal" data-remote="true"
                           data-id="<?php echo $reference->reference_id;?>"
                           data-time="<?php echo $reference->time;?>"
                           data-type="<?php echo $reference->type;?>"
                           data-value="<?php echo $reference->value;?>"
                           href="#editReferenceModal">
                            Edit
                        </a>

                        <!---------EDIT MODAL------------->
                        <div class="modal fade" id="editReferenceModal" tabindex="-1" role="dialog" aria-labelledby="editReferenceModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="editReferenceModalLabel">Edit Reference</h4>
                                    </div>
                                    <div class="modal-body">
                                        <?php echo form_open_multipart('Lecture_Reference/editReference','class="form" id="myform"');?>

                                        <input type="hidden" name="reference_ID_edit" id="reference_ID_edit" value="">
                                        <input type="hidden" name="lecture_ID_edit" id="lecture_ID_edit" value="<?php echo $lecture->lecture_id?>">

                                        <div class="form-group">
                                            <label for="type">Reference Type:</label>
                                            <select class="form-control" required id="type_edit" name="type_edit"><option value=""></option>
                                                <option value="lecture">Previous Lecture</option>
                                                <option value="video">Video</option>
                                                <option value="simulation">Simulation</option>
                                            </select>
                                        </div>

                                        <!------- REFERENCE DATE and TIME---------->
                                        <div class="form-group">
                                            <label for="lecture_date">Reference Date and Time</label>
                                            <div class='input-group date' id='datetimepicker5'>
                                                <input type='text' name='time_edit' id="time_edit" required class="form-control" />
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
                                            <select class="form-control"  id="prev_lectureID_edit" name="prev_lectureID_edit"><option value=""></option>
                                                <?php foreach($lectures_reference as $lecture_reference){?>
                                                    <option value="<?php echo $lecture_reference->lecture_id;?>"><?php echo $lecture_reference->lecture_name;?></option>
                                                <?php }?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="link">Link (Video/Simulation):</label>
                                            <textarea class="form-control" type="text" name="link_edit" id="link_edit" value="" rows="2"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="fileToUpload">Select new image to upload (Video/Simulation):</label>
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

                        <!-- Setting quiz information in edit form-->

                        <script>
                            $(document).on("click", ".edit-link", function () {
                                var reference_ID = $(this).data('id');
                                var reference_time = $(this).data('time');
                                var reference_type = $(this).data('type');
                                var reference_value = $(this).data('value');
                                $("#reference_ID_edit").val(reference_ID);
                                $("#time_edit").val(reference_time);
                                $("#type_edit").val(reference_type);
                                $("#prev_lectureID_edit").val(reference_value);
                                $("#link_edit").val(reference_value);
                            });
                        </script>
                        <!---------EDIT MODAL------------->

                        <!--------------------- DELETE----------------->
                        <a class="delete-link btn btn-danger"
                           data-toggle="modal" data-remote="true"
                           data-id="<?php echo $reference->reference_id;?>"
                           data-lecture="<?php echo $lecture->lecture_id;?>"
                           href="#deleteReferenceModal">
                            Delete
                        </a>
                        <!--------------------- Delete Reference Modal ----------------->
                        <div class="modal fade" id="deleteReferenceModal" tabindex="-1" role="dialog" aria-labelledby="deleteReferenceModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="deleteReferenceModalLabel">Confirm Delete</h4>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure want to delete the reference?
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
                                var reference_id = $(this).data('id');
                                var lecture_id = $(this).data('lecture');
                                var link = document.getElementById("inner-deleteLink");
                                link.setAttribute('href', "<?php echo base_url();?>reference/delete?reference_id=" + reference_id + '&lecture_id=' +lecture_id);
                            });
                        </script>
                        <!--------------------- Delete Quiz Modal ----------------->
                    </td>

                    <!------------  EDIT/DELETE--------------------->
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

