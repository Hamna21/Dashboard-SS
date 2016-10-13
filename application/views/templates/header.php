<html>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, MAX-AGE=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <!-- Custom CSS and JS -->
    <link rel = "stylesheet"
          href = "<?php echo base_url(); ?>css/custom.css">

    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/jquery.js"></script>

    <?php
    if($subtitle == "Add Course" || $subtitle == "Edit Course")
    {
        echo '<script type = "text/javascript" src = " '. base_url() .'js/courseRegister.js"></script>';
    }
    else if($subtitle == "Add Category")
    {
        echo '<script type = "text/javascript" src = " '. base_url() .'js/categoryRegister.js"></script>';
    }
    else if($subtitle == "Add Teacher")
    {
        echo '<script type = "text/javascript" src = " '. base_url() .'js/teacherRegister.js"></script>';
    }
    else if($subtitle == "Add Lecture")
    {
        echo '<script type = "text/javascript" src = " '. base_url() .'js/lectureRegister.js"></script>';
    }

    ?>

</head>
<body onunload="">

