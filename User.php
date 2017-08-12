<?php
/**
 * Created by PhpStorm.
 * User: Tushar
 * Date: 4/25/2017
 * Time: 4:34 PM
 */
    include 'database.php';
    include_once 'Session.php';

    class User
    {
        private $db;

        /**
         *  Database Class
         */
        public function __construct()
        {
            $this->db = new Database();
        }

        /**
         * return Registration
         */
        public function userRegistration($data)
        {
            $name     = $data['name'];
            $email    = $data['email'];
            $passWord = md5($data['password']);
            $rePassWord = md5($data['rePassword']);

            /*
             * Checking Email
             */
            $mailCheck = $this->MailCheck($email);

            /*
             * Filter for Registration
             * information
             * @return $dangerMsg
             */
            if ((empty($name)) || (empty($email)) || (empty($passWord)))
            {
                if (empty($name))
                {
                    echo "<div class='alert alert-danger'>";
                          echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " Name Should be field.";
                        echo "</div>";
                    //return $dangerMsg;
                }
                elseif (empty($email))
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " E-mail Should be field.";
                    echo "</div>";
                }
                elseif(empty($passWord))
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " Password Must be field.";
                    echo "</div>";
                }
            }
            elseif (!empty($passWord))
            {
                if(strcasecmp($passWord, $rePassWord) != 0)
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo "Password Not Matched.";
                    echo "</div>";
                }
                if(strlen($passWord) <= 5)
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " Password Must More Than 5 Character.";
                    echo "</div>";
                }
            }

            if(!empty($email))
            {
                if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "pleas"; echo "</strong>"; echo " Enter a Valid E-mail";
                    echo "</div>";
                }
            }

            if($mailCheck == true)
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong class='text-capitalize text-danger'> "; echo "sorry !"; echo "</strong>"; echo "  E-mail Exist";
                echo "</div>";
            }
            //return $dangerMsg;

            $sql = "INSERT INTO info (name, email, pass) VALUES (:name,:email,:password)";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':name', $name);
            $query->bindValue(':email', $email);
            $query->bindValue(':password', $passWord);
            $result = $query->execute();

            if($result)
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong class='text-capitalize text-success'> "; echo "congratulation you have been registered successfully "; echo "</strong>";
                echo "</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong class='text-capitalize text-danger'> "; echo "sorry !"; echo "</strong>"; echo "  There have been some problem inserting values";
                echo "</div>";
            }
        }//Function for Registration

        /**
         * return MailCheck
         */
        public function MailCheck($email)
        {
            $sql = "SELECT email FROM info WHERE email = :email";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':email', $email);
            $query->execute();

            if($query->rowCount() > 0)
            {
                return (true);
            }
            else
            {
                return (false);
            }
        }

        public function getLoginUser($email, $password)
        {
            $sql = "SELECT * FROM info WHERE email = :email AND pass = :password LIMIT 1";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':email', $email);
            $query->bindValue(':password', $password);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        }


        /**
         * userLogin Function
         * for login
         */
        public function userLogin($data)
        {
            $logEmail = $data['email'];
            $loginPass = md5($data['password']);

            /*
             * Checking Email
             */
            $loginMailCheck = $this->MailCheck($logEmail);

            if(empty($logEmail) || empty($loginPass))
            {
                if(empty($logEmail))
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " E-mail Should be field.";
                    echo "</div>";
                }
                elseif (empty($loginPass))
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " Password Should be field.";
                    echo "</div>";
                }
            }/*Checking if input is empty*/

            if(!empty($logEmail))
            {
                if(filter_var($logEmail, FILTER_VALIDATE_EMAIL) == false)
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "pleas"; echo "</strong>"; echo " Enter a Valid E-mail";
                    echo "</div>";
                }

                if ($loginMailCheck == false)
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry !"; echo "</strong>"; echo "  E-mail don't Exist";
                    echo "</div>";
                }
            }

            $result = $this->getLoginUser($logEmail, $loginPass);

            if($result)
            {
                Session::init();
                Session::set("login", true);
                Session::set("id", $result->id);
                Session::set("name", $result->name);
                Session::set("loginMessage", "<div class='alert alert-success'><strong class='text-capitalize text-success'> welcome ! </strong>  You are loggedIn!!</div>");
                header("Location: index.php");
            }
            /*else
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong class='text-capitalize text-danger'> "; echo "sorry !"; echo "</strong>"; echo "  You are not Registered Yes!!";
                echo "</div>";
            }*/

        }//userLogin function

        public function getUserData()
        {
            $sql = "SELECT * FROM info ORDER BY id ASC";
            $query = $this->db->pdo->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        }//User Data Function


        public function getUserDataById($userId)
        {
            $sql = "SELECT * FROM info WHERE id = :id LIMIT 1";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':id', $userId);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        }//Function for getting User Data By Id

        public function updateUser($id, $data)
        {
            $name     = $data['name'];
            $email    = $data['email'];
            $passWord = md5($data['password']);

            /*
             * Filter for Registration
             * information
             * @return Danger Message
             */
            if ((empty($name)) || (empty($email)) /*|| (empty($passWord))*/)
            {
                if (empty($name))
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " Name Should be field.";
                    echo "</div>";
                    //return $dangerMsg;
                }
                elseif (empty($email))
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " E-mail Should be field.";
                    echo "</div>";
                }
                /*
                elseif(empty($passWord))
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " Password Must be field.";
                    echo "</div>";
                }
                */
            }

            elseif (!empty($passWord))
            {
                if(strlen($passWord) <= 5)
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "sorry!"; echo "</strong>"; echo " Password Must More Than 5 Character.";
                    echo "</div>";
                }
            }


            if(!empty($email))
            {
                if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
                {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong class='text-capitalize text-danger'> "; echo "pleas"; echo "</strong>"; echo " Enter a Valid E-mail";
                    echo "</div>";
                }
            }

            $sql = "UPDATE info SET name = :name ,email = :email , pass = :pass WHERE id = :id";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':name', $name);
            $query->bindValue(':email', $email);
            $query->bindValue(':pass', $passWord);
            $query->bindValue(':id', $id);
            $result = $query->execute();

            if($result)
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong class='text-capitalize text-success'> "; echo "congratulation your information have been updated successfully "; echo "</strong>";
                echo "</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong class='text-capitalize text-danger'> "; echo "sorry !"; echo "</strong>"; echo "  There have been some problem inserting values";
                echo "</div>";
            }
        }//Function for update uset data

    }//Main Class
?>