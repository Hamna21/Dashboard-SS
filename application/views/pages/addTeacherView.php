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

<?php echo form_open_multipart('Teacher/addTeacher', 'class="form" id="myform"');?>

<div class="form-group">
    <div class="col-md-12">
        <label for="teacher_ID">Teacher ID</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" value=" <?php if(isset($_SESSION['teacher_ID'])) {echo  $this->session->teacher_ID;} ?>" name="teacher_ID" id="teacher_ID" required autofocus/>
        <span class="error"><p id ="teacherID_Error"></span></p> <?php if(isset($_SESSION['teacherID_Error'])) {echo  $this->session->teacherID_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="teacher_Name">Teacher Name</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" value=" <?php if(isset($_SESSION['teacher_Name'])) {echo  $this->session->teacher_Name;} ?>" name="teacher_Name" id="teacher_Name" required />
        <span class="error"><p id ="teacherName_Error"></span></p><?php if(isset($_SESSION['teacherName_Error'])) {echo  $this->session->teacherName_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="teacher_Designation">Teacher Designation</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" value=" <?php if(isset($_SESSION['teacher_Designation'])) {echo  $this->session->teacher_Designation;} ?>" name="teacher_Designation" id="teacher_Designation" required />
        <span class="error"><p id ="teacherDesignation_Error"></span></p><?php if(isset($_SESSION['teacherDesignation_Error'])) {echo  $this->session->teacherDesignation_Error;} ?>
    </div>
</div>


<div class="form-group">
    <div class="col-md-12">
        <label for="teacher_Domain">Teacher Domain</label>
    </div>
    <div class="col-md-12">
        <select class="form-control" required id="teacher_Domain" name="teacher_Domain"><option value="">Please select</option>
            <?php $increment = 1 ?>
            <?php foreach($categories as $category){?>
                <option value="<?php echo $category['category_Name'];?>"><?php echo $category['category_Name'];?></option>
            <?php }?>
            <?php if(isset($_SESSION['teacherDomain_Error'])) {echo  $this->session->teacherDomain_Error;} ?>
        </select>
    </div>
</div>




<div class="form-group">
    <div class="col-md-12">
        <label for="fileToUpload">Select image to upload:</label>
    </div>
    <div class="col-md-12">
        <input type="file"  name="image_Path" id="image_Path" required />
        <span class="error"></span><?php if(isset($_SESSION['teacherImage_Error'])) {echo  $this->session->teacherImage_Error;} ?>
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