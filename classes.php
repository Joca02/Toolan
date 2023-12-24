<?php
require_once "database.php";


class User{
    public $id_user;
    public $username;
    public $password;
    public $name;
    public $gender;
    public $user_type;
    public $prof_description;
    public $profile_picture;
    private static $dbc;

    //TODO pfp logika
    public function __construct( $id_user,$username, $password,$name,$gender,$user_type ,$prof_description,$profile_picture)
    {  
         $this->id_user=$id_user;
         $this->username=$username;
         $this->password=$password;
         $this->user_type=$user_type;
         $this->name=$name;
         $this->gender=$gender;
         $this->prof_description=$prof_description;
         $this->profile_picture=$profile_picture;
    }


    //returns new object if successfull
    //false if incorrect login info
    //null if there are database/connection problems. check log for more info
    public static function isSuccessfullLogin($usr,$psw)
    {
        $dbc=createConnection();
        $query="SELECT * FROM users WHERE username='$usr' AND password='$psw'";
        try{
            $result=mysqli_query($dbc,$query);
            if($result)
            {
                if(mysqli_num_rows($result)==1)
                {
                    $row=mysqli_fetch_assoc($result);
                    $id_user=$row['id_user'];
                    $username=$row['username'];
                    $password=$row['password'];
                    $name=$row['name'];
                    $user_type=$row['user_type'];
                    $prof_description=$row['prof_description'];
                    $profile_picture=$row['profile_picture'];
                    $gender=$row['gender'];
                    return new User($id_user,$username, $password,$name,$gender,$user_type ,$prof_description,$profile_picture);
                }
                else if(mysqli_num_rows($result)>1)
                {
                    error_log("Several users with same username: ".$usr);
                    return null;
                }
                else return false;
            }
            else {
                return null;
            }

        }
        catch (Exception $e)
        {
            error_log("Exception caught in login check: ".$e);
            return null;
        }
        finally {
            closeConnection($dbc);
        }
    }
}

?>