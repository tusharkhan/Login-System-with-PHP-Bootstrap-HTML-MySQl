<?php require 'User.php'; ?>
<?php require 'head.php'; ?>
<?php Session::checkSession(); ?>
    <div class="container">
        <div class="row">
            <?php
                if (isset($_GET['id']))
                {
                    $userId = (int)$_GET['id'];
                }
                $user = new User();

                if(($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['update']) )
                {
                    $updateusr = $user->updateUser($userId, $_POST);
                }
            ?>
                <div class="panel-default panel">
                    <div class="page-header">
                        <h3 class="text-capitalize" style="position: relative; left: 10px"> profile <span class="pull-right" style="position: relative; right: 20px"><a
                                    href="index.php" class="btn btn-success">Home</a> </span> </h3>
                    </div>

                    <div class="panel-body">
                <?php
                    $sessionId = Session::get("id");
                    if ($userId != $sessionId):
                ?>
                        <div class='alert alert-danger'>
                            <h3 class="text-danger text-capitalize">this is not your profile , please go to your profile</h3>
                        </div>
                <?php endif; ?>
                <?php
                    $userData = $user->getUserDataById($userId);
                    if($userData):
                ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Your Name</label>
                                <input type="email" class="form-control" name="name" value="<?php echo $userData->name; ?>" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $userData->email; ?>" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        <?php
                            $sessionId = Session::get("id");
                            if ($userId == $sessionId):
                        ?>
                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                        <?php endif; ?>
                        </form>
                <?php endif; ?>
                    </div>
                </div>
        </div><!--row-->
    </div><!--container-->
<?php  require 'footer.php' ;?>