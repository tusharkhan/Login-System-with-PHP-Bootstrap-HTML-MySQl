<?php
/**
 * Created by PhpStorm.
 * User: Tanzil
 * Date: 4/25/2017
 * Time: 4:58 PM
 */
    require 'head.php';
    include 'User.php';
    $user = new User();
?>
<?php
    if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['register']) )
    {
        $userRegit = $user->userRegistration($_POST);
    }
?>
    <div class="container">
        <div class="row">
            <div class="panel-default panel">
                <div class="page-header">
                    <h3 class="text-capitalize">  user login  </h3>
                </div>

                <div class="panel-body">
                    <form action="" method="POST">
                        <!--
                            Checking User Registration
                            if true Return $userRegit
                        -->
                        <?php
                            if (isset($userRegit))
                            {
                                return $userRegit;
                            }
                        ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Your Name</label>
                            <input type="email" class="form-control" name="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Re Enter Password</label>
                            <input type="password" class="form-control" name="rePassword" placeholder="Re Enter Password">
                        </div>
                        <button type="submit" class="btn btn-primary" name="register">Register</button>
                    </form>
                </div>
            </div>
        </div><!--row-->
    </div><!--container-->
<?php require 'footer.php'?>
