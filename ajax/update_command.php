<?php
require '../db.php';
require '../php/access.php';
require '../crypt.php';

if (!access(intval($_POST['user_id']), $db))
	exit('отказано в доступе');

$command_id = intval($_POST['command_id']);
$command_name = $_POST['command_name'];
$command_region = $_POST['command_region'];
$get_audio = intval($_POST['get_audio']);
$get_digital = intval($_POST['get_digital']);
$command_email = $_POST['command_email'];
$command_password = $_POST['command_password'];

if ($get_audio < 0)
	$get_audio = 0;
elseif ($get_audio > 100)
	$get_audio = 100;

if ($get_digital < 0)
	$get_digital = 0;
elseif ($get_digital > 100)
	$get_digital = 100;

// if password not changed
if ($command_password == '############') {
	$db->set_table('users');
	$db->set_update([
		'login' => $command_email,
		'audio_percent' => $get_audio,
		'digital_percent' => $get_digital,
		'name' => $command_name,
		'city' => $command_region,
	]);
	$db->set_where(['id' => $command_id]);
	$db->update('siissi');
}
else {
	$auth = get_hash_password($command_id, $command_password);

	// remove old data in passwords table
	$db->set_table('users');
	$db->set_where(['id' => $command_id]);
	$auth_old = $db->select('i')->fetch_array(MYSQLI_ASSOC)['auth'];

	$db->set_table('passwords');
	$db->set_where([]);
	$passes = $db->select();
	foreach ($passes as $passwor) {
		if (password_verify($auth_old, $passwor['id'])) {
			$db->set_where(['id' => $passwor['id']]);
			$db->delete('s');
		}
	}

	$db->set_table('users');
	$db->set_update([
		'login' => $command_email,
		'audio_percent' => $get_audio,
		'digital_percent' => $get_digital,
		'name' => $command_name,
		'city' => $command_region,
		'auth' => $auth,
	]);
	$db->set_where(['id' => $command_id]);
	$db->update('siisssi');

	$id = password_hash($auth, PASSWORD_DEFAULT);
	$password = mc_encrypt($command_password, SECRET_KEY);

	$db->set_table('passwords');
	$db->set_insert([
		'id' => $id,
		'password' => $password,
	]);
	$db->insert('ss');

	// send email to command
	$message = "<b><a href='http://partner.bbt-online.ru/'>Партнерская программа ББТ</a></b><br>".
				"Ваш новый пароль: $command_password<br>";
	$headers = 'From: bbt@online.ru' . "\r\n" .
	    'Reply-To: bbt@online.ru' . "\r\n" .
	    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	mail($command_email, 'ББТ обновила ваш пароль.', $message, $headers);
}
