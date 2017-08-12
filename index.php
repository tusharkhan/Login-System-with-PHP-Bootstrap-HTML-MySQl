<?php include 'User.php';?>
<?php require 'head.php'; ?>
<?php
    //$filepath = realpath(dirname(__FILE__));
    //include_once 'Session.php';
    Session::checkSession();
    //Session::init();
    $user = new User();
    $loginMessage = Session::get("loginMessage");

    if(isset($loginMessage))
    {
        echo $loginMessage;
    }
?>
<?php
if(isset($_GET['action']) && $_GET['action'] == "logout")
{
    Session::sessionDestroy();
}
?>
    <div class="container">
        <div class="row">
            <div class="panel-default panel">
                <div class="page-header">
                    <h3 class="text-capitalize" style="position: relative; left: 10px">  user list <span class="pull-right" style="position: relative; right: 20px"><strong>WELCOME </strong>
                            <span class="text-info">
                        <?php
                            $userNane = Session::get("name");
                            if(isset($userNane))
                            {
                                echo " ".$userNane;
                            }
                            Session::set("loginMessage", NULL);
                        ?>
                            <span>
                        </span>
                    </h3>
                </div>

                <div class="panel-body">
                    <table class="table table-hover table-responsive">
                        <thead>
                        <tr>
                            <th width="20%">#</th>
                            <th width="20%">Name</th>
                            <th width="20%">Email</th>
                            <th width="20%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $user = new User();
                                $userData = $user->getUserData();

                                if($userData):
                                    $i = 0;
                                    foreach ($userData as $sdata):
                                        $i++;
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $i;?></th>
                                    <td>
                                        <?php  echo $sdata['name'];?>
                                    </td>
                                    <td>
                                        <?php  echo $sdata['email'];?>
                                    </td>
                                    <td>
                                        <a href="profile.php?id=<?php  echo $sdata['id'];?>" class="btn btn-info">VIEW</a>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5">
                                        <h2 class="text-danger text-capitalize">no uset data found</h2>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--row-->
    </div><!--container-->
<?php  require 'footer.php' ;?>