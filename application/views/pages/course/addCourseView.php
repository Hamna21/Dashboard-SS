<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>courses">Courses</a>
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
            <label for="course_Name">Course Name</label>
        </div>
        <div class="col-md-12">
            <input class="form-control" type="text"  name="course_Name" id="course_Name" maxlength="30" required value="<?php if(isset($_SESSION['course_Name'])) {echo  $this->session->course_Name;} ?>" />
            <span class="error"><p id ="courseName_Error"></span></p>  <?php if(isset($_SESSION['courseName_Error'])) {echo  $this->session->courseName_Error;} ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <label for="course_Description">Course Description</label>
        </div>
        <div class="col-md-12">
            <textarea class="form-control" type="text" name="course_Description" id="course_Description" maxlength="100" rows="3" required><?php if(isset($_SESSION['course_Description'])) {echo  $this->session->course_Description;} ?></textarea>
            <span class="error"></span> <?php if(isset($_SESSION['courseDescription_Error'])) {echo  $this->session->courseDescription_Error;} ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <label for="category">Category</label>
        </div>
        <div class="col-md-12">
            <select class="form-control" required id="category" name="category"><option value="">Please select</option>
                <?php foreach($categories as $category){?>
                    <option value="<?php echo $category->category_id;?>"><?php echo $category->category_name;?></option>
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
                <?php foreach($teachers as $teacher){?>
                    <option value="<?php echo $teacher->teacher_id;?>"><?php echo $teacher->teacher_name;?></option>
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