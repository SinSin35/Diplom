<?php 
if (isset($_POST['signup-submit'])){

	require 'db_connection.php';
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repassword = $_POST['re-password'];
	$FIO = $_POST['FIO'];
	$adress = $_POST['adress'];

	//проверка на пустоту полей
	if(empty($username)||empty($password)||empty($repassword)||empty($FIO)||empty($adress)){
		header("Location: ../signup.php?error=emptyfields");
		exit();
	}
	//проверка на допустимые символы
	else if (!preg_match("/^[a-zA-Z0-9]*$/",$username)){
		header("Location: ../signup.php?error=invalidsymbols");
		exit();
	}
	//проверка на совпадение паролей
	else if($password !== $repassword){
		header("Location: ../signup.php?error=passwordnotmatch");
		exit();
	}
	else{
		$sql="SELECT User_username from user where User_username=?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../signup.php?error=sqlerror");
			exit();
		}
		else {
			mysqli_stmt_bind_param($stmt,"s",$username);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$resultcheck=mysqli_stmt_num_rows($stmt);
			//проверка на наличие логина в базе данных
			if ($resultcheck>0){
				header("Location: ../signup.php?error=usertaken");
				exit();
			}
			//запись нового пользователя
			else{
				$sql = "INSERT INTO user(User_username, User_password, User_FIO, User_adress,User_Admin) VALUES (?,?,?,?,0)";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt,$sql)){
					header("Location: ../signup.php?error=sqlerror");
					exit();
				}
				else{
					$hashedPwd = password_hash($password,PASSWORD_DEFAULT);

					mysqli_stmt_bind_param($stmt,"ssss",$username,$hashedPwd,$FIO,$adress);
					mysqli_stmt_execute($stmt);
					header("Location: ../login.php?signup=success");
					exit();
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else{
	header("Location: ../signup.php");
	exit();
}

 ?>