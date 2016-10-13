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
    <?php echo form_open_multipart('Course/addCourse', 'class="form" id="myform"');?>

    <div class="form-group">
        <div class="col-md-12">
            <label for="course_ID">Course ID</label>
        </div>
        <div class="col-md-12">
            <input class="form-control" type="text" value="<?php if(isset($_SESSION['course_ID'])) {echo  $this->session->course_ID;} ?>" name="course_ID" id="course_ID" required autofocus/>
            <span class="error"><p id ="courseID_Error"></span></p> <?php if(isset($_SESSION['courseID_Error'])) {echo  $this->session->courseID_Error;} ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <label for="course_Name">Course Name</label>
        </div>
        <div class="col-md-12">
            <input class="form-control" type="text" value="<?php if(isset($_SESSION['course_Name'])) {echo  $this->session->course_Name;} ?>" name="course_Name" id="course_Name" required />
            <span class="error"><p id ="courseName_Error"></span></p>  <?php if(isset($_SESSION['courseName_Error'])) {echo  $this->session->courseName_Error;} ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <label for="course_Description">Course Description</label>
        </div>
        <div class="col-md-12">
            <input class="form-control" type="text" value="<?php if(isset($_SESSION['course_Description'])) {echo  $this->session->course_Description;} ?>" name="course_Description" id="course_Description" required />
            <span class="error"></span> <?php if(isset($_SESSION['courseDescription_Error'])) {echo  $this->session->courseDescription_Error;} ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-12">
            <label for="category">Category</label>
        </div>
        <div class="col-md-12">
            <select class="form-control" required id="category" name="category"><option value="">Please select</option>
                <?php $increment = 1 ?>
                <?php foreach($categories as $category){?>
                    <option value="<?php echo $increment++;?>"><?php echo $category['category_Name'];?></option>
                <?php }?>
            </select>
            <span class="error"></span> <?php if(isset($_SESSION['categoryID_Error'])) {echo  $this->session->categoryID_Error;} ?>

        </div>
    </div>


    <div class="form-group">
        <div class="col-md-12">
            <label for="teacher">Teacher</label>
        </div>
        <div class="col-md-12">
            <select class="form-control" required id="teacher" name="teacher"><option value="">Please select</option>
                <?php $increment = 1 ?>
                <?php foreach($teachers as $teacher){?>
                    <option value="<?php echo $increment++;?>"><?php echo $teacher['teacher_Name'];?></option>
                <?php }?>
            </select>
            <span class="error"></span> <?php if(isset($_SESSION['teacherID_Error'])) {echo  $this->session->teacherID_Error;} ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-12">
            <label for="fileToUpload">Select image to upload:</label>
        </div>
        <div class="col-md-12">
            <input type="file"  name="image_Path" id="image_Path" required />
            <span class="error"></span> <?php if(isset($_SESSION['courseImage_Error'])) {echo  $this->session->courseImage_Error;} ?>
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