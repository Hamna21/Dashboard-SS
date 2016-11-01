<!---------------Page Heading--------------->

<style type="text/css">
    th{
        white-space: nowrap;
    }
    #lec_desc {
        width: 300px;
    }
    #edit-delete {
        width: 170px;
    }
    #quiz {
        width: 250px;
    }

</style>
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
<div class="pull-right "><a class="btn btn-default btn-success" href="<?php echo base_url();?>lecture/add">New Lecture</a></div>

<div class="row">
    <div class="col-lg-12">
        <h2>Lectures</h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>Lecture Name</th>
                    <th>Course</th>
                    <th>Lecture Description</th>
                    <th>Start-Time</th>
                    <th>End-Time</th>
                    <th>Quiz</th>
                    <th>Edit/Delete</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($lectures as $lecture){?>
                    <tr>
                        <td><?php echo $lecture->lecture_Name;?></td>
                        <td><?php echo $lecture->course_Name;?></td>
                        <td id="lec_desc"><?php echo $lecture->lecture_Description;?></td>
                        <td id="time"><?php echo $lecture->lecture_start;?></td>
                        <td id="time"><?php echo $lecture->lecture_end;?></td>
                        <td id="quiz">
                            <a class="btn btn-primary"
                               href="<?php echo base_url();?>lecture/add/quiz?q=<?php echo $lecture->lecture_ID;?>">
                                Add Quiz
                            </a>

                            <a class="delete-link btn btn-info"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $lecture->lecture_ID;?>" href="#quizModal">
                                View Quiz
                            </a>
                        </td>
                        <td id="edit-delete">
                            <a class="btn btn-warning"
                               href="<?php echo base_url();?>lecture/edit?q=<?php echo $lecture->lecture_ID;?>">
                                Edit
                            </a>

                            <a class="delete-link btn btn-danger"
                               data-toggle="modal" data-remote="true" data-id="<?php echo $lecture->lecture_ID;?>" href="#deletelectureModal">
                                Delete
                            </a>
                            <!--------------------- Delete Lecture Modal ----------------->
                            <div class="modal fade" id="deletelectureModal" tabindex="-1" role="dialog" aria-labelledby="deletelectureModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="deletelectureModalLabel">Confirm Delete</h4>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure want to delete the lecture?
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
                                    var lectureID = $(this).data('id');
                                    var link = document.getElementById("mylink");
                                    link.setAttribute('href', "<?php echo base_url()?>lecture/delete?q=" + lectureID);
                                });
                            </script>
                            <!--------------------- Delete lecture Modal ----------------->
                            
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