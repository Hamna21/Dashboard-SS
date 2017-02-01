<style type="text/css">
    th{
        white-space: nowrap;
    }
    #user_name {
        width: 200px;
    }
    #time {
        width: 60px;
    }
    #text {
        width: 700px;
    }
</style>


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
                <i class="fa fa-file"></i> <?php echo $title; ?>
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <h2>Comments of Course: <?php echo $course_name?></h2>

        <div class="table-responsive" >
            <table class="table table-bordered table-hover table-striped auto">
                <thead>
                <tr>
                    <th>User Name</th>
                    <th>Comment</th>
                    <th>Comment Time</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($comments as $comment){?>
                <tr>
                    <td id="user_name"><?php echo $comment->user->user_name;?></td>
                    <td id="text"><?php echo $comment->comment_text;?></td>
                    <td id="time"><?php echo $comment->comment_time?></td>
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