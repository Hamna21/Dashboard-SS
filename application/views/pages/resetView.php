<html>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type = 'text/javascript' src = "<?php echo base_url(); ?>js/login.js"></script>
    <link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/signin.css">
</head>
<body>

<div class="container">
    <!---Displaying alert--->
    <?php
    if(isset($_SESSION['error']))
    {
        echo '<div class="alert alert-danger">';
        echo ' <strong>Failure....</strong>'. "     " . $this->session->message;
        echo '</div>';
    }
    ?>

    <?php echo form_open('Login/resetPassword', 'class="form-signin" id="myform"');?>

    <h2 class="form-signin-heading">Reset Password</h2>

    <input type="hidden" name="reset_hash" value="<?php echo $reset_hash?>">


    <label for="password" class="sr-only">Password</label>
    <input type="password" id="password" name = "password" class="form-control" placeholder="Password" required />
    <span class="error"><p id ="passwordError"></span></p> <?php if(isset($_SESSION['password_Error'])) {echo  $this->session->password_Error;} ?>


    <button class="btn btn-lg btn-primary btn-block" type="submit">Reset</button>
    </form>

</div> <!-- /container -->

</body>
</html>
