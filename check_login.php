<?php
require_once "classes.php";
session_start();
header('Content-Type: application/json');
if(isset($_POST['username'])&&isset($_POST['password']) )
{
    error_log($_POST['username']." ".$_POST['password']);
    $user=User::isSuccessfullLogin($_POST['username'],$_POST['password']);
    
    if ($user instanceof User)
    {
        if($user->user_type=="admin")
        {
            $_SESSION['admin']=$user;
            echo json_encode("admin success");
        }
        else
        {
            $dbc=createConnection();
            try{
                $query="SELECT * FROM bans WHERE id_user=$user->id_user";
                $result=mysqli_query($dbc,$query);
                if($result)
                {
                    if(mysqli_num_rows($result)>0){ //korisnik jeste banovan
                        $row=mysqli_fetch_assoc($result);
                        $banReason=$row['ban_reason'];
                        $date_end=$row['date_end'];
                        $currentDate = date("Y-m-d");

                        $todaysTimestamp=strtotime($currentDate);
                        $banTimestamp=strtotime($date_end);
                        
                        if($todaysTimestamp<$banTimestamp)
                        {
                            $response=array(
                                "banReason"=>$banReason,
                                "date_end"=>$date_end,
                                "status"=>"banned"
                            );
                            echo json_encode($response);
                        }
                        else
                        {
                            $_SESSION['user']=$user;
                            echo json_encode("success");
                        }
                        
                    }
                    else    //korisnik nije banovan
                    {
                        $_SESSION['user']=$user;
                        echo json_encode("success");
                    }
                }
                else
                {
                    error_log(mysqli_error($dbc));
                }

            }catch(Exception $e)
            {
                error_log($e);
            }finally{
                closeConnection($dbc);
            }

            
            
        }     
        exit();
    }
    else
    {
        echo json_encode("fail");
        session_destroy();
    }
        
}

?>