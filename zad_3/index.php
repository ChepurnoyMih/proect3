<?php

header('Content-Type:text/html;charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_GET['save'])) {
    print('Ваши результаты успешно отправлены');
  }
  include('form.php');
  exit();
}
$errors = FALSE;
$name = $_POST["name"];
$mail = $_POST["mail"];
$year = $_POST["year"];
$sex =	$_POST["pol"];
$flag=FALSE;
$countlimbs = $_POST["countlimbs"];
$biography = $_POST["biography"];	
$check1 = $_POST["check1"];

if (empty($name)) {
  echo	"Ваше имя:<br/>";
  $errors = TRUE;
}else if(!preg_match("#^[aA-zZ0-9\-_]+$#",$_POST["name"])){
	print('Символы введены некорректно!<br/>');
	$errors=TRUE;
}
if (empty($mail)){
	echo "Электронный адрес:<br/>";
	$errors = TRUE;
}
if	(empty($year)){
	echo "Выберите интервал, в который  входит год Вашего рождения:<br/>";
	$errors = TRUE;
}
if	(empty($_POST["pol"])){
	echo "укажите пол:<br/>";
	$errors	= TRUE;
}
if	(empty($_POST["countlimbs"])){
	echo "Количество конечностей:<br/>";
	$errors	= TRUE;	
}
$Super = $_POST["super"];
  if(!isset($Super))
  {
    echo("<p>Способности не выбраны!</p><br/>");
  }
  else
  {	echo"Суперспособности, которыми обладаете:<br/>";
    for($i=0; $i < count($Super); $i++)
    {
		if($Super[$i]=="no")$flag=TRUE;
    }
  }
 if($flag){
	 for($t=0;$t<count($Super);$t++){
		 if($Super[$t]!="no")unset($Super[$t]);
	 }
 }else if(!empty($Super)){
	 for($y=0;$y<count($Super);$y++){
		echo"$Super[$y]<br/>";
	}
 }
 $super_separated=implode(' ',$Super);
if	(empty($_POST["biography"])){
	echo "Заполните поле биографии!<br/>";
	$errors	= TRUE;
}
if	(empty($_POST["check1"])){
	echo "Нет соглашения со всеми условиями!<br/>";
	$errors	= TRUE;	
}

if($errors){
	exit();
}
$user = 'u25739';
$pass = '3238332';
$db = new PDO('mysql:host=localhost;dbname=u25739', $user, $pass,
array(PDO::ATTR_PERSISTENT => true));
try {
 $stmt = $db->prepare("INSERT INTO application (name, mail, birth, sex, countlimbs, super, biography,check1) 
 VALUES (:name, :mail, :birth, :sex, :countlimbs,:super,:biography, :check1)");
$stmt->bindParam(':name', $name_db);
$stmt->bindParam(':mail', $mail_db);
$stmt->bindParam(':year', $year_db);
$stmt->bindParam(':pol', $sex_db);
$stmt->bindParam(':countlimbs', $limb_db);
$stmt->bindParam(':super', $super_db);
$stmt->bindParam(':biography', $bio_db);
$stmt->bindParam(':check1', $check1_db);
$name_db=$_POST["name"];
$mail_db=$_POST["mail"];
$year_db=$_POST["year"];
$sex_db=$_POST["pol"];
$limb_db=$_POST["countlimbs"];
$super_db=$super_separated;
$bio_db=$_POST["biography"];
$check1_db=$_POST["check1"];
$stmt->execute();
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
header('Location: ?save=1');
?>

