<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>lectures">Lectures</a>
            </li>
            <li class="active">
                <i class="fa fa-plus"></i> <?php echo $subtitle; ?>
            </li>
        </ol>
    </div>
</div>

<?php echo form_open_multipart('Lecture/addLecture', 'class="form" id="myform"');?>

<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_Name">Lecture Name</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" name="lecture_Name" id="lecture_Name" required value="<?php if(isset($_SESSION['lecture_Name'])) {echo  $this->session->lecture_Name;} ?>" />
        <span class="error"><p id ="lectureName_Error"></span></p> <?php if(isset($_SESSION['lectureName_Error'])) {echo  $this->session->lectureName_Error;} ?>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="course">Course</label>
    </div>
    <div class="col-md-12">
        <select class="form-control" required id="course" name="course"><option value="">Please select</option>
            <?php foreach($courses as $course){?>
                <option value="<?php echo $course->course_id;?>"><?php echo $course->course_name;?></option>
            <?php }?>
        </select>
        <?php if(isset($_SESSION['courseID_Error'])) {echo  $this->session->courseID_Error;} ?>
        <br>
    </div>
</div>



<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_Description">Lecture Description</label>
    </div>
    <div class="col-md-12">
        <textarea class="form-control" type="text" name="lecture_Description" id="lecture_Description" required rows="4"><?php if(isset($_SESSION['lecture_Description'])) {echo  $this->session->lecture_Description;} ?> </textarea>
        <span class="error"></span><p id ="lectureDescription_Error"></span></p><?php if(isset($_SESSION['lectureDescription_Error'])) {echo  $this->session->lectureDescription_Error;} ?>
    </div>
</div>


<!------- LECTURE DATE ---------->
<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_date">Lecture Start Date and Time</label>
    </div>
    <div class="col-md-12">
        <div class='input-group date' id='datetimepicker1'>
            <input type='text' name='lecture_date' id="lecture_date" class="form-control" />
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>

        <script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
    </div>
</div>
<!------- LECTURE DATE---------->

<!------- LECTURE ENDING TIME---------->
<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_start">Lecture Ending Time</label>
    </div>
    <div class="col-md-12">
        <div class='input-group date' id='datetimepicker4'>
            <input type='text' id="lecture_end" name="lecture_end" class="form-control" />
            <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
            </span>
        </div>

        <br>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker4').datetimepicker({
                    format: 'LT'
                });
            });
        </script>
    </div>
</div>
<!------- LECTURE ENDING TIME--------->


<input type="submit" name="commit" value="Submit" class="btn btn-default btn-success" />

</form>


</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->