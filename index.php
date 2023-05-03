<?php
	require "includes/db.php";
?>

<?php
	//Считывание информации статистики
	$user = R::findOne('statssb_stats', 'name = ?', [$_SESSION['logged_user'] -> realname]);

	$setskin = 0;

	//Проверка есть ли скин, вывод какой это был файл
	if (empty($userSkin = R::findOne('userskins', 'user = ?', [$_SESSION['logged_user'] -> realname])) == false) {
		echo 'Скин уже есть ';
		echo $userSkin['skin'];
		$setskin = 1;
	}
	
	if(isset($_FILES['filename'])){
		$errors = array();
		$file_name1 = $_FILES['filename']['name'];
		$file_name = $_FILES['filename']['name'];
		$file_size = $_FILES['filename']['size'];
		$file_tmp = $_FILES['filename']['tmp_name'];

		$file_name1 = $_SESSION['logged_user'] -> realname.".skin";
		$newFilePath = "C:/Users/IlyaMikryukov/Desktop/Minecraft/MinecraftProject/ServerMinecraft/Lobby/plugins/SkinsRestorer/Skins/".$_SESSION['logged_user'] -> realname.".skin";

		$pathPlayer = "C:/Users/IlyaMikryukov/Desktop/Minecraft/MinecraftProject/ServerMinecraft/Lobby/plugins/SkinsRestorer/Players/".$_SESSION['logged_user'] -> realname.".player";

		if($file_size > 1048576) {
			$errors[0] = ' Файл должен быть не больше 1 мб';
		}

		if($_FILES['filename']['size'] == 0) {
			$errors[0] = ' Файл не выбран';
		}

		if(empty($errors) == true) {

			if (R::exec('SELECT permission FROM luckperms_user_permissions WHERE permission = ?', ['skinsrestorer.skin.'.$_SESSION['logged_user'] -> realname]) == 0) {
				//Поиск UUID пользователя, чтобы добавить именно ему возможность сменить скин на ранее загруженный
				$userUUIDPerm = R::findOne('statssb_stats', 'name = ?', [$_SESSION['logged_user'] -> realname]);

				//Добавление привилегии данному пользователю по UUID
				R::exec('INSERT INTO luckperms_user_permissions SET uuid = ?, permission = ?, value = ?, server = ?, world = ?, expiry = ?, contexts = ?',
				[$userUUIDPerm -> uuid, 'skinsrestorer.skin.'.$_SESSION['logged_user'] -> realname, 1, 'global', 'global', 0, '{}']);
			}

			if($setskin == 0) {
				R::exec('INSERT INTO userskins SET user = ?, skin = ?', [$_SESSION['logged_user'] -> realname, $file_name1]);
			} else {
				R::exec('UPDATE userskins SET skin = ? WHERE user = ?', [$file_name1, $_SESSION['logged_user'] -> realname]);
			}

			move_uploaded_file($file_tmp, $newFilePath);

			if (file_exists($pathPlayer)) {
				//проверяем, существует ли файл
				$fp = fopen($pathPlayer,"w");//если существуем, открываем файл
				fwrite($fp, $_SESSION['logged_user'] -> realname);//записываем в файл
				fclose($fp);//закрываем файл.
			} else {
				$fp = fopen($pathPlayer,"w");//если файла info.txt не существует, создаем его
				fwrite($fp, $_SESSION['logged_user'] -> realname);//записываем в файл
				fclose($fp);//закрываем файл.
			}
		echo ' Скин изменен';
		} else {
		print $errors[0];
		}
	}
?>

<?php
	if(isset($_SESSION['logged_user'])): ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="indexStyle.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineWay</title>
</head>

<body>
	<script>
		function chColor(el) {
			el.style.color = 'red';
		}
	</script>
	<h1>Авторизован!</h1>
	<h1>Привет, <?php echo $_SESSION['logged_user'] -> realname; ?>!</h1>
	<h1>Статистика</h1>
	Убийства игроков: <?php echo $user -> kills ?><br>
	Смерти: <?php echo $user -> deaths ?><br>
	Ранг по убийствам игроков: <?php echo $user -> kills_rank ?><br>
	Ранг по смертям: <?php echo $user -> deaths_rank ?><br>
	<h1>Скин</h1>

	<form action="" method="POST" enctype="multipart/form-data">
		<div id="btn">
			<label for="files" id="chFile" onclick="chColor(this)">Выберите файл</label>
		</div>
		<?php echo $file_name1 ?>
		<input type="file" accept=".skin" name="filename" id="files">
		<input type="submit" class="sendFile" value="Отправить">
	</form>

	<br>
	<br>
	<form action="servercon.php" method="POST">
		<label for="com">Выполнить</label>
		<input type="text" id="com" name="command">
		<input type="submit" id="submit" value="Отправить">
	</form>
	<br>
	<br>

	<br><a href='/logout.php'>Выйти</a>
</body>
</html>
<?php else:?>
	
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="indexStyle.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineWay</title>
</head>

<body>
	<a href="/login.php">Login</a><br>
	<a href="/signup.php">Signup</a><br>
</body>
</html>
<?php endif; ?>