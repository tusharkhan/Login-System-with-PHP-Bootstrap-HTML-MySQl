<?php
/**
 * Created by PhpStorm.
 * User: Tanzil
 * Date: 4/25/2017
 * Time: 2:33 PM
 */

    $filepath = realpath(dirname(__FILE__));
    include_once $filepath.'\Session.php';
    //echo $filepath;
    Session::init();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    </head>
    <?php
        if(isset($_GET['action']) && $_GET['action'] == "logout")
        {
            Session::sessionDestroy();
        }//Logging out
    ?>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Home</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            $userId = Session::get("id");
                            $userLogin = Session::get("login");
                            if($userLogin == true):
                        ?>
                            <li>
                                <a href="index.php">Home</a>
                            </li>
                            <li>
                                <a href="profile.php?id=<?php echo $userId; ?>">Profile</a>
                            </li>
                            <li>
                                <a href="?action=logout">Logout</a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="login.php">Login</a>
                            </li>
                            <li>
                                <a href="register.php">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

