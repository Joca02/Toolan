<?php

function createConnection()
{
    require_once "classes.php";
    try
    {
        $dbc = @mysqli_connect("127.0.0.1", "root", "", "pva_projekat");
        if (!$dbc) {
            error_log("Connection failed: " . mysqli_connect_error());
            return false;
        }
        return $dbc;
    }
    catch(Exception $e)
    {
        error_log("There was a problem connecting to the database: " . $e->getMessage());

        return false;
    }
}

function closeConnection($dbc)
{
    if(!mysqli_close($dbc))
    {
        echo "Error closing connection";
    }
}

function generateUser($row)
{
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

function findNames($dbc,$characters)
{
    
    $query = "SELECT * FROM users WHERE name LIKE '$characters%' AND user_type != 'admin'";

    $result=mysqli_query($dbc,$query);
    if(!$result)throw new Exception("Query in findNames failed.");
    $filteredUsers=[];
    while($row=mysqli_fetch_assoc($result))
    {               
        $filteredUsers[]=generateUser($row);
    }
    header('Content-Type: application/json');
    echo json_encode($filteredUsers);

}


function findUserById($id)
{
    $dbc = createConnection();
    $query = "SELECT * FROM users WHERE id_user = $id";
    
    try {
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_assoc($result);

        return generateUser($row);
    } catch (Exception $e) {
        error_log($e);
    } finally {
        closeConnection($dbc);
    }
}

?>