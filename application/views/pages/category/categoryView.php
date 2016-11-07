<!---------------Page Heading--------------->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="<?php echo base_url();?>dashboard">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> <?php echo $title; ?>
            </li>
        </ol>
    </div>
</div>

<div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url();?>category/add">New Category</a></div>


<div class="row">
    <div class="col-lg-12">
        <h2>Categories</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Category Image</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($categories as $category){?>
                    <tr>
                        <td><?php echo $category->category_name;?></td>
                        <td>
                            <img src="http://cte.itu.edu.pk/second_screen_api/uploads/<?php echo $category->category_thumbimage;?>">
                        </td>
                        <td>
                            <a class="btn btn-warning"
                               href="<?php echo base_url();?>Category/edit?q=<?php echo $category->category_id;?>">
                                Edit
                            </a>

                            <a class="delete-link btn btn-danger"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $category->category_id;?>" href="#deleteCategoryModal">
                                Delete
                            </a>
                            <!--------------------- Delete Category Modal ----------------->
                            <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="deleteCategoryModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure want to delete the category?
                                        </div>
                                        <div class="modal-footer">
                                            <a id = "mylink" class="btn btn-danger" href="">Yes </a>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).on("click", ".delete-link", function () {
                                    var categoryID = $(this).data('id');
                                    var link = document.getElementById("mylink");
                                    link.setAttribute('href', "<?php echo base_url();?>category/delete?q=" + categoryID);
                                });
                            </script>
                            <!--------------------- Delete Category Modal ----------------->
                        </td>
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