<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>index.php/courses">Courses</a>
            </li>
            <li class="active">
                <i class="fa fa-plus"></i> <?php echo $subtitle; ?>
            </li>
        </ol>
    </div>
</div>
<?php echo form_open_multipart('Course/editCourse', 'class="form" id="myform"');?>

<div class="form-group">
    <div class="col-md-12">
        <label for="course_Name">Course Name</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" name="course_Name" id="course_Name" required readonly  value="<?php echo $this->session->course_Name; ?>" />
        <span class="error"><p id ="courseName_Error"></span></p>  <?php if(isset($_SESSION['courseName_Error'])) {echo  $this->session->courseName_Error;} ?>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="course_Description">Course Description</label>
    </div>
    <div class="col-md-12">
        <textarea class="form-control" type="text" name="course_Description" id="course_Description" maxlength="100" rows="3" required><?php echo $this->session->course_Description; ?></textarea>
        <span class="error"></span> <?php if(isset($_SESSION['courseDescription_Error'])) {echo  $this->session->courseDescription_Error;} ?>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="category">Category</label>
    </div>
    <div class="col-md-12">
        <select class="form-control" required id="category" name="category"><option value="<?php echo $this->session->category_ID; ?>"><?php echo $this->session->category_Name; ?></option>
            <?php foreach($categories as $category){?>
                <option value="<?php echo $category['category_ID'];?>"><?php echo $category['category_Name'];?></option>
            <?php }?>
        </select>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="teacher">Teacher</label>
    </div>
    <div class="col-md-12">
        <select class="form-control" required id="teacher" name="teacher"><option value="<?php echo $this->session->teacher_ID; ?>"><?php echo $this->session->teacher_Name; ?></option>
            <?php foreach($teachers as $teacher){?>
                <option value="<?php echo $teacher['teacher_ID'];?>"><?php echo $teacher['teacher_Name'];?></option>
            <?php }?>
        </select>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="imageUploaded">Image Uploaded:</label>
    </div>
    <div class="col-md-12">
        <img src="http://localhost:8080/Dashboard-SS/uploads/<?php echo $this->session->course_ThumbImage;?>">
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="fileToUpload">Select new image to upload (if required):</label>
    </div>
    <div class="col-md-12">
        <input type="file"  name="image_Path" id="image_Path"/>
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