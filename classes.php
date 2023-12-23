<?php
require_once "database.php";


class User{
    public $id;
    public $username;
    public $password;
    public $name;
    public $user_type;
    public $prof_description;
    public $profile_picture;
    private static $dbc;

    //TODO pfp logika
    public function __construct( $id,$username, $password,$name,$user_type ,$prof_description)
    {  
         $this->id=$id;
         $this->username=$username;
         $this->password=$password;
         $this->user_type=$user_type;
         $this->name=$name;
         $this->prof_description=$prof_description;
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
                    $id=$row['id'];
                    $username=$row['username'];
                    $password=$row['password'];
                    $name=$row['name'];
                    $user_type=$row['user_type'];
                    $prof_description=$row['prof_description'];
                    return new User($id,$username, $password,$name,$user_type ,$prof_description);
                }
                else 
                {
                    error_log("Several users with same username: ".$usr);
                    return null;
                }
            }
            else {
                return false;
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