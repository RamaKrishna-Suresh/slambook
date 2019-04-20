<?php
session_start();
include('includes/config.php');
include_once("includes/header.php");

echo "Hi ".$_SESSION['alogin'];

if(isset($_POST['submitInvite'])){

    $insert_sql = "insert into invites (from_id,to_id) values ((select id from users where name=:fromName),(select id from users where name=:toName))";
    $insert_query = $dbh->prepare($insert_sql);
    $insert_query->bindParam(':fromName',$_SESSION['alogin'],PDO::PARAM_STR);
    $insert_query->bindParam(':toName',$_POST['toInvite'],PDO::PARAM_STR);
    $insert_query->execute();
    echo $insert_query->queryString;
    $lastInsertId = $dbh->lastInsertId();

    if($lastInsertId)
    {
        echo "<script type='text/javascript'>alert('Invite Sucessfull!');</script>";
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    }
    else
    {
        $error="Something went wrong. Please try again";
    }



}
?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tachyons/4.11.1/tachyons.css">
</head>
<div>
    <h3 class="">Your Invite(s)</h3>
    <div class="bg-lightest-blue white flex flex-column w-20">
        <?php
            $sql = "select from_users.name from invites 
                        inner join users as from_users on from_users.id = invites.from_id
                        inner join users as to_users on to_users.id = invites.to_id
                        where to_users.name = :current_user_name;";
            $query = $dbh->prepare($sql);
            $query->bindParam(':current_user_name', $_SESSION['alogin'],  PDO::PARAM_STR);
            $query->execute();
            $rows = $query->fetchAll();
            foreach ($rows as $row) {
                $temp_string = "<div>
                        <a href='wall.php?usr=:usr'>".$row[0]." has sent you an invite</a>
                      </div>";
                echo str_replace(':usr',$row[0],$temp_string);


            }
        ?>
    </div>
</div>
<div>
    <form name="inviteForm" action="dashboard.php" method="POST" >
        <h4>Send an invite to your friends</h4>
        Email <input type="text" placeholder="Friend's username" name="toInvite"/>
        <input type="submit" name="submitInvite"/>
    </form>
</div>

<div>
    <a href="wall.php?usr=<?php echo $_SESSION['alogin'];?>" >CLICK HERE TO SEE YOUR WALL</a>

</div>
