<link rel="stylesheet" href="css/bootstrap.min.css">	<!-- Bootstrap -->
<link rel="stylesheet" href="css/styles.css">	<!-- Файл CSS -->
<script src="https://kit.fontawesome.com/739623eb5a.js" crossorigin="anonymous"></script>	<!-- Значки -->

<!-- Форма логина -->
<div id="form">
	<?php require_once("php/header.php")?>
	<?php require_once("php/menu.php")?>
	<div class="SignLogin">
		<form action="php/login.inc.php" method="post">
			<?php 
				if($_GET['signup']=="success"){
					echo "<h2 class='text-center text-success pb-4'>Регистрация прошла успешно</h2>";
				}
			?>
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4 py-4 border border-info rounded">
					<h1 class="text-center">Login</h1>
					<?php 
						if (isset($_GET['error'])){	//вывод сообщений об ошибке
							if ($_GET['error']=="emptyusername"){	
								echo "<p class='text-danger'>*Логин не введен</p>";	
							}
							else if ($_GET['error']=="emptypassword"){	
								echo "<p class='text-danger'>*Пароль  не введен</p>";	
							}
							else if ($_GET['error']=="invaliduser"){
								echo "<p class='text-danger'>*Недопустимые символы</p>";	
							}
							else if ($_GET['error']=="mysql"){
								echo "<p class='text-danger'>*Проблема с базой данных</p>";	
							}
							else if ($_GET['error']=="nouser"){
								echo "<p class='text-danger\''>*Такого username не существует</p>";	
							}
							else if ($_GET['error']=="wrongpas"){
								echo "<p class='text-danger'>*Неверный пароль</p>";	
							}
						}
					 ?>
					<label for="Username">Username</label>
					<input type="text" class="form-control mb-4" name="username" placeholder="Username">
					<label for="password">Password</label>
					<input type="password" class="form-control mb-4" name="password" placeholder="Password">
					<p><a href="signup.php">Не зарегистрированы?</a></p>
					<button class="btn btn-primary" name="login-submit" type="submit">Войти</button>					
				</div>
				<div class="col-md-4"></div>
			</div>

		</form>
	</div>

</div>