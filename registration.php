<?php
//input
function selection($str) {
  $str=strip_tags($str);
  $str=stripslashes($str);
  $str=trim($str);
  return $str;
}
$check=0;
$password="";
$pr="";
if(isset($_POST['us']) && !empty($_POST['us'])&& $_POST['us'] == selection($_POST['us']) && strlen($_POST['us'])<=40 && strlen($_POST['us'])>=3){
  $fname=$_POST['us'];
  $check++;
}
else {
  echo "Nem megfelelö a Felhasználónév!";
}
if(isset($_POST['em']) && !empty($_POST['em'])&& $_POST['em'] == selection($_POST['em']) && strlen($_POST['em'])<=40 && strlen($_POST['em'])>=6){
  $email=$_POST['em'];
  $check++;
}
else {
  echo "Nem megfelelö az e-mail cím!";
}
if(isset($_POST['ps']) && !empty($_POST['ps'])&& $_POST['ps'] == selection($_POST['ps']) && strlen($_POST['ps'])<=40 && strlen($_POST['ps'])>=8){
  $password=$_POST['ps'];
}
else {
  echo "Nem megfelelö a jelszó!";
}
if(isset($_POST['pr']) && !empty($_POST['pr'])&& $_POST['pr'] == selection($_POST['pr']) && strlen($_POST['pr'])<=40 && strlen($_POST['pr'])>=8){
  $pr=$_POST['pr'];
}

//password check
if($pr==$password)
{
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);
  if(!$uppercase || !$lowercase || !$number ) {
    echo 'A jelszónak legalább egy nagy és egy kis betűt illetve egy számot kell tartalmaznia!';
 }
 else {
   $check++;
 }
}
else {
  echo "A jelszavak nem egyeznek!";
}
//check userdata
$success=0;
if($check==3)
{
  //connection
  include("connection.php");
  $result =mysqli_query($db, "SELECT * FROM `accounts`");
  if(mysqli_num_rows($result)>0){
    $table=array();
    $id=0;
    $cus=false;
    $cem=false;
    while($row=$result->fetch_object()){
     array_push($table,$row);
     if($table[$id]->username==$fname)
     {
       $cus=true;
     }
     if($table[$id]->email==$email)
     {
       $cem=true;
     }
     $id++;
   }
   if($cus==true)
   {
     echo "A felhasználónév már foglalt!";
   }
   else {
     $success++;
   }
   if($cem==true)
   {
     echo "Ezen az e-mail címen már regisztráltak!";
   }
   else {
     $success++;
   }

  }
  else if(mysqli_num_rows($result)==0){
   $success=2;
 }
}
if($success==2)
{
  $query ="INSERT INTO `accounts` (`username`,`email`,`password`) VALUES ('".$fname."','".$email."','".$password."')";
  $db->query($query) or die ("Hiba a kapcsolatban!");
echo "Sikeres Regisztráció!";
}
  if(isset($db))
  {
    $db->close();
    $result->free();
  }


?>
