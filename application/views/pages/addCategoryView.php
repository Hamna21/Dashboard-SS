<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>index.php/categories">Categories</a>
            </li>
            <li class="active">
                <i class="fa fa-plus"></i> <?php echo $subtitle; ?>
            </li>
        </ol>
    </div>
</div>

<?php echo form_open_multipart('Category/addCategory', 'class="form" id="myform"');?>

<div class="form-group">
    <div class="col-md-12">
        <label for="category_ID">Category ID</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" value="<?php if(isset($_SESSION['category_ID'])) {echo  $this->session->category_ID;} ?>" name="category_ID" id="category_ID" required autofocus/>
        <span class="error"><p id ="categoryID_Error"></span></p> <?php if(isset($_SESSION['categoryID_Error'])) {echo  $this->session->categoryID_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="category_Name">Category Name</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text" value="<?php if(isset($_SESSION['category_Name'])) {echo  $this->session->category_Name;} ?>" name="category_Name" id="category_Name" required />
        <span class="error"><p id ="categoryName_Error"></span></p> <?php if(isset($_SESSION['categoryName_Error'])) {echo  $this->session->categoryName_Error;} ?>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <label for="fileToUpload">Select image to upload:</label>
    </div>
    <div class="col-md-12">
        <input type="file"  name="image_Path" id="image_Path" required />
        <span class="error"></span><?php if(isset($_SESSION['categoryImage_Error'])) {echo  $this->session->categoryImage_Error;} ?>
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