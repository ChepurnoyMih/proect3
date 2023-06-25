<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if (!empty($_SESSION['login']))
{
    session_destroy();
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>

    <head>
        <title>Autorization</title>
    </head>
    <div class="Form">
        <form action="" method="post">
            Логин:<input name="login"/>
            Пароль:<input name="pass" type="password"/>
            <input type="submit" value="Войти" />
        </form>
    </div>


    <?php
}
else {
    $user = 'u52886';
    $pass = '2557509';
    $db = new PDO('mysql:host=localhost;dbname=u52886', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    $login = $_POST['login'];
    $stmt = $db->prepare("SELECT * FROM users WHERE login LIKE ?");
    $stmt->execute([$login]);
    $flag=0;
    while($row = $stmt->fetch())
    {
        if(!strcasecmp($row['login'],$_POST['login'])&&password_verify($_POST['pass'],$row['hash']))
        {
            $flag=1;
            $user_id=$row['user_id'];
        }
    }
    if($flag) {
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['uid'] = $user_id;
        header('Location: index.php');
    }
    else{
        header('Location: login.php');
    }
}
