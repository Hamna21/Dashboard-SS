<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>categories">Categories</a>
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
        <label for="category_Name">Category Name</label>
    </div>
    <div class="col-md-12">
        <input class="form-control" type="text"  name="category_Name" id="category_Name" required value="<?php if(isset($_SESSION['category_Name'])) {echo  $this->session->category_Name;} ?>" />
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