<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>index.php/teachers">Teachers</a>
            </li>
            <li class="active">
                <i class="fa fa-plus"></i> <?php echo $subtitle; ?>
            </li>
        </ol>
    </div>
</div>

<?php echo form_open_multipart('Teacher/editTeacher', 'class="form" id="myform"');?>

<div class="form-group">
    <div class="col-md-12">
        <label for="teacher_Name">Teacher Name</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text"  name="teacher_Name" id="teacher_Name" required value="<?php echo $this->session->teacher_Name; ?> " />
        <span class="error"><p id ="teacherName_Error"></span></p><?php if(isset($_SESSION['teacherName_Error'])) {echo  $this->session->teacherName_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="teacher_Designation">Teacher Designation</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" name="teacher_Designation" id="teacher_Designation" required value="<?php echo $this->session->teacher_Designation; ?>"  />
        <span class="error"><p id ="teacherDesignation_Error"></span></p><?php if(isset($_SESSION['teacherDesignation_Error'])) {echo  $this->session->teacherDesignation_Error;} ?>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="teacher_Domain">Teacher Domain</label>
    </div>
    <div class="col-md-12">
        <select class="form-control" required id="teacher_Domain" name="teacher_Domain"><option value="<?php echo $this->session->teacher_Domain;?>"><?php echo $this->session->teacher_Domain;?></option>
            <?php foreach($categories as $category){?>
                <option value="<?php echo $category['category_Name'];?>"><?php echo $category['category_Name'];?></option>
            <?php }?>
            <?php if(isset($_SESSION['teacherDomain_Error'])) {echo  $this->session->teacherDomain_Error;} ?>
        </select>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="imageUploaded">Image Uploaded:</label>
    </div>
    <div class="col-md-12">
        <img src="http://localhost:8080/Dashboard-SS/uploads/<?php echo $this->session->teacher_ThumbImage;?>">
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