<?php

session_start();
include_once('includes/config.php');
include_once("includes/header.php");

if(isset($_POST['postSubmit'])) {
    $post_sql = 'insert into slams (msg,commenter_id,owner_id)
values (:comment,
(select id from users where name = :commenter),
(select id from users where name = :owner))';

    $post_query = $dbh->prepare($post_sql);
    $post_query->bindParam(':comment', $_POST['post']);
    $post_query->bindParam(':commenter', $_SESSION['alogin']);
    $post_query->bindParam(':owner', $_REQUEST['usr']);
    $post_query->execute();
    $lastInsertId = $dbh->lastInsertId();


    if($lastInsertId)
    {
        echo "<script type='text/javascript'>alert('Comment Sucessfull!');</script>";
    }
    else
    {
        $error="Something went wrong. Please try again";
    }

}
echo "You are viewing ".$_REQUEST['usr']."'s wall<br><br>";
$message_sql = 'select commenters.name ,slams.msg from slams 
left join users as commenters on slams.commenter_id = commenters.id
left join users as owners on slams.owner_id = owners.id
where owners.name = :usrname';
$message_query = $dbh->prepare($message_sql);
$message_query->bindParam(':usrname',$_REQUEST['usr']);
$message_query->execute();
$rows = $message_query->fetchAll();
foreach($rows as $row){
    echo "<div class='ba b--dashed w-50'>".$row[0].' commented '.$row[1]."</div><br>";
}
?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tachyons/4.11.1/tachyons.css">
</head>

<?php

$post_form = '<form action="wall.php" method="POST" id="postForm">
    <div>
    <input type="hidden" name="usr" value=":usrname">
    <textarea rows="4" cols="50" id="postForm" name="post" placeholder="Enter your comments here"></textarea><br>
    <input type="Submit" name="postSubmit">
    </div>
</form>';

$post_form = str_replace(':usrname',$_REQUEST['usr'],$post_form);

if($_REQUEST['usr'] != $_SESSION['alogin']){
    echo $post_form;
}

?>
