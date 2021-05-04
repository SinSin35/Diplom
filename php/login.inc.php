<?php
//Обработка логина 
if (isset($_POST['login-submit'])){
	require 'db_connection.php';

	$username = $_POST['username'];
	$password = $_POST['password'];

	//проверка на пустоту логина 
	if(empty($username)){
		header("Location: ../login.php?error=emptyusername");
		exit();
	}
	//проверка на пустоту пароля
	else if(empty($password)){
		header("Location: ../login.php?error=emptypassword");
		exit();
	}
	//проверка на допустимые символы
	else if (!preg_match("/^[a-zA-Z0-9]*$/",$username)){
		header("Location: ../login.php?error=invaliduser");
		exit();
	}
	else{
		$sql = "SELECT * FROM user WHERE User_username=?;";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../login.php?error=mysql");
			exit();
		}
		else{
			mysqli_stmt_bind_param($stmt,"s",$username);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if($row=mysqli_fetch_assoc($result)){
				//если логин есть в базе данных
				$pwdCheck = password_verify($password,$row['User_password']);
				if ($pwdCheck == false){
					//если пароли не совпадают
					header("Location: ../login.php?error=wrongpas");
					exit();		
				}
				else if($pwdCheck==true){
					//пароли совпали - вход
					session_start();
					$_SESSION['userID']=$row['User_id'];
					$_SESSION['userUsername']=$row['User_username'];
					$_SESSION['userFIO']=$row['User_FIO'];
					$_SESSION['userAdmin']=$row['User_Admin'];
					

					header("Location: ../index.php?login=success");
					exit();					
				}
				else{
					header("Location: ../login.php?error=wrongpas");
					exit();	
				}
			}
			else{
				//логина нет в базе данных
				header("Location: ../login.php?error=nouser");
				exit();				
			}
		}

		
	}
}