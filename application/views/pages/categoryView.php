<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> <?php echo $title; ?>
            </li>
        </ol>
    </div>
</div>


<div class="pull-right "><a class="btn btn-default btn-success" style="margin-left: 30px" href="<?php echo base_url();?>index.php/category/save_in_excel">Export Data</a></div>
<div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url();?>index.php/category/add">New Category</a></div>


<div class="row">
    <div class="col-lg-12">
        <h2>Categories</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Category Image</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($categories as $category){?>
                    <tr>

                        <td><?php echo $category['category_ID'];?></td>
                        <td><?php echo $category['category_Name'];?></td>
                        <td><?php echo $category['category_Image'];?></td>
                    </tr>
                <?php }?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<!-- /.row -->

<!-- Pagination -->
<div class="row">
    <div class="col-md-12 text-center">
        <?php echo $links ?>
    </div>
</div>


</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
<!--wrapper -->