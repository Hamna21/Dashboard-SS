<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!----------Brand and toggle get grouped for better mobile display------------->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url();?>index.php/dashboard">Second Screen Admin</a>
    </div>

    <!------------------ Top Menu Items----------------->
    <ul class="nav navbar-right top-nav">
        <!---------------PROFILE---------------->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->user?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="http://localhost:8080/Dashboard-SS/index.php/Login/logoutUser"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>

    <!-------------Sidebar Menu Items - These collapse to the responsive navigation menu on small screens----------------->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="<?php echo ($title == "Dashboard" ? "active" : "")?>"> <a href="<?php echo base_url();?>index.php/dashboard"><i class="fa fa-fw fa-table"></i> Dashboard</a> </li>
            <li class="<?php echo ($title == "Courses" ? "active" : "")?>"> <a href="<?php echo base_url();?>index.php/courses"><i class="fa fa-fw fa-table"></i> Courses</a> </li>
            <li class="<?php echo ($title == "Categories" ? "active" : "")?>"> <a href="<?php echo base_url();?>index.php/categories"><i class="fa fa-fw fa-table"></i> Categories</a> </li>
            <li class="<?php echo ($title == "Teachers" ? "active" : "")?>"> <a href="<?php echo base_url();?>index.php/teachers"><i class="fa fa-fw fa-table"></i> Teachers</a> </li>
            <li class="<?php echo ($title == "Lectures" ? "active" : "")?>"> <a href="<?php echo base_url();?>index.php/lectures"><i class="fa fa-fw fa-table"></i> Lectures</a> </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>


<!---------------------PAGE HEADING------------------>
<div id="wrapper">
    <div id="page-wrapper">
        <div class="container-fluid">
            <!---Displaying alert/success in case of Form Submission--->
            <?php
            if(isset($_SESSION['error']))
            {
                echo '<div class="alert alert-danger">';
                echo ' <strong>Failure....</strong>'. "     " . $this->session->message;
                echo '</div>';
            }
            if(isset($_SESSION['success']))
            {
                echo '<div class="alert alert-success">';
                echo ' <strong>Success....</strong>'. "     " . $this->session->message;
                echo '</div>';
            }
            ?>