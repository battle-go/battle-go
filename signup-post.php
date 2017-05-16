<?php

require_once '_include/connection.php';

$sql = 'INSERT INTO users(email, password, name, token)
        VALUES(:email, :password, :name, :token)';

$token = mt_rand();

$req = $db->prepare($sql);
$req->execute(array(
	'email'     => $_POST['email'],
	'password'  => $_POST['password'],
  'name'      => $_POST['name'],
	'token'     => $token
));

require_once 'login-post.php'

?>
