<?php
require '../db.php';
$email = $_POST['email'];

$db->set_table('users');
$db->set_where(['login' => $email]);
$correct = $db->select('s');

if (!$correct || $correct->num_rows === 0) {
	echo "no";
} else {
	echo 'yes';

	$correct = $correct->fetch_array(MYSQLI_ASSOC);
	$auth = $correct['auth'];

	$message = "<b><a href='http://partner.bbt-online.ru/'>Партнерская программа ББТ</a></b><br>".
				"Чтобы сбросить пароль для аккаунта $email перейдите по ссылке:<br>" .
				"http://partner.bbt-online.ru/forgot_password.php?reset={$email}_".md5($auth);
	$headers = 'From: bbt@online.ru' . "\r\n" .
	    'Reply-To: bbt@online.ru' . "\r\n" .
	    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	mail($email, 'Сброс пароля', $message, $headers);
}
