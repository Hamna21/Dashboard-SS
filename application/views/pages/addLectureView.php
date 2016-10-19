<!---------------Page Heading--------------->
<div class="row" xmlns="http://www.w3.org/1999/html">
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
                <option value="<?php echo $course['course_ID'];?>"><?php echo $course['course_Name'];?></option>
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
        <textarea class="form-control" type="text" name="lecture_Description" id="lecture_Description" required rows="3" maxlength="100" value="<?php if(isset($_SESSION['lecture_Description'])) {echo  $this->session->lecture_Description;} ?>"> </textarea>
        <span class="error"></span><p id ="lectureDescription_Error"></span></p><?php if(isset($_SESSION['lectureDescription_Error'])) {echo  $this->session->lectureDescription_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="course">Lecture Starting Time</label>
    </div>
    <div class="col-md-12">
        <select class="form-control" required id="lecture_start" name="lecture_start"><option value="">Please select start time:</option>
            <?php
            for ($x = 0; $x <= 23; $x++) {?>
                <option value="<?php $x;?>"><?php echo $x.":00:00";?></option>
                }
            <?php }?>
        </select>
        <?php if(isset($_SESSION['courseID_Error'])) {echo  $this->session->courseID_Error;} ?>
        <br>
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