<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>index.php/lectures">Lectures</a>
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
        <label for="lecture_ID">Lecture ID</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" value="<?php if(isset($_SESSION['lecture_ID'])) {echo  $this->session->lecture_ID;} ?>" name="lecture_ID" id="lecture_ID" required autofocus/>
        <span class="error"><p id ="lectureID_Error"></span></p> <?php if(isset($_SESSION['lectureID_Error'])) {echo  $this->session->lectureID_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_Name">Lecture Name</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" value="<?php if(isset($_SESSION['lecture_Name'])) {echo  $this->session->lecture_Name;} ?>" name="lecture_Name" id="lecture_Name" required />
        <span class="error"><p id ="lectureName_Error"></span></p> <?php if(isset($_SESSION['lectureName_Error'])) {echo  $this->session->lectureName_Error;} ?>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="course">Course</label>
    </div>
    <div class="col-md-12">
        <select class="form-control" required id="course" name="course"><option value="">Please select</option>
            <?php $increment = 1 ?>
            <?php foreach($courses as $course){?>
                <option value="<?php echo $increment++;?>"><?php echo $course['course_Name'];?></option>
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
        <input class="form-control" type="text" value="<?php if(isset($_SESSION['lecture_Description'])) {echo  $this->session->lecture_Description;} ?>" name="lecture_Description" id="lecture_Description" required />
        <span class="error"></span><p id ="lectureDescription_Error"></span></p><?php if(isset($_SESSION['lectureDescription_Error'])) {echo  $this->session->lectureDescription_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_Time">Lecture Time</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" value="<?php if(isset($_SESSION['lecture_Time'])) {echo  $this->session->lecture_Time;} ?>" name="lecture_Time" id="lecture_Time" required />
        <span class="error"></span><p id ="lectureTime_Error"></span></p><?php if(isset($_SESSION['lectureTime_Error'])) {echo  $this->session->lectureTime_Error;} ?>
    </div>
</div>

<input type="submit" name="commit" value="Submit" class="btn btn-default btn-success" />

</form>


</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->