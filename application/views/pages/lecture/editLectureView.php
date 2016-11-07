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

<?php echo form_open_multipart('Lecture/editLecture', 'class="form" id="myform"');?>

<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_Name">Lecture Name</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" name="lecture_Name" id="lecture_Name" required value="<?php echo $this->session->lecture_Name;?>" />
        <span class="error"><p id ="lectureName_Error"></span></p> <?php if(isset($_SESSION['lectureName_Error'])) {echo  $this->session->lectureName_Error;} ?>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="course">Course</label>
    </div>
    <div class="col-md-12">
        <select class="form-control" required id="course" name="course"><option value="<?php echo $this->session->lecture_Domain;?>"><?php echo $this->session->lecture_Domain;?></option>
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
        <textarea class="form-control" type="text" name="lecture_Description" id="lecture_Description" required rows="3" maxlength="100"><?php echo $this->session->lecture_Description;?> </textarea>
        <span class="error"></span><p id ="lectureDescription_Error"></span></p><?php if(isset($_SESSION['lectureDescription_Error'])) {echo  $this->session->lectureDescription_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_start"> Lecture Starting Time</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" name="lecture_start" id="lecture_start" required value="<?php echo $this->session->lecture_start;?>"  />
        <span class="error"></span><p id ="lectureStart_Error"></span></p><?php if(isset($_SESSION['lectureStart_Error'])) {echo  $this->session->lectureStart_Error;} ?>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="lecture_end"> Lecture Ending Time</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" name="lecture_end" id="lecture_end" required value="<?php echo $this->session->lecture_end;?>"  />
        <span class="error"></span><p id ="lectureEnd_Error"></span></p><?php if(isset($_SESSION['lectureEnd_Error'])) {echo  $this->session->lectureEnd_Error;} ?>
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