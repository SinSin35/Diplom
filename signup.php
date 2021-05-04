<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css">
<script src="https://kit.fontawesome.com/739623eb5a.js" crossorigin="anonymous"></script>

<div id="form">
	<?php require_once("php/header.php")?>
	<?php require_once("php/menu.php")?>
	<div class="SignLogin">
		<form action="php/signup.inc.php" method="post">
			<div class="row">
				<div class="col-md-4"></div>
				<div class="col-md-4 py-4 border border-info rounded">
					<h1 class="text-center">Sign up</h1>
					<?php 
						if (isset($_GET['error'])){ //вывод сообщений об ошибке
							if ($_GET['error']=="emptyfields"){
								echo "<p class='text-danger'>*Не все поля заполнены</p>";	
							}
							else if ($_GET['error']=="invalidsymbols"){
								echo "<p class='text-danger'>*Недопустимые символы</p>";	
							}
							else if ($_GET['error']=="passwordnotmatch"){
								echo "<p class='text-danger'>*Пароли не совпадают</p>";	
							}
							else if ($_GET['error']=="sqlerror"){
								echo "<p class='text-danger'>*Проблема с базой данных</p>";	
							}
							else if ($_GET['error']=="usertaken"){
								echo "<p class='text-danger'>*Данный username уже занят</p>";	
							}
						}
					 ?>
					<label for="FIO">ФИО</label>
					<input type="text" class="form-control mb-4" name="FIO" placeholder="ФИО">
					<label for="Username">Username</label>
					<input type="text" class="form-control mb-4" name="username" placeholder="Username">
					<label for="password">Password</label>
					<input type="password" class="form-control mb-4" name="password" placeholder="Password">
					<label for="re-password">Repeat password</label>
					<input type="password" class="form-control mb-4" name="re-password" placeholder="Password">
					<label for="adress">Адрес</label>
					<input type="text" class="form-control mb-4" name="adress" placeholder="Улица, дом..">
					<button class="btn btn-primary" name="signup-submit" type="submit">Зарегистрироваться</button>					
				</div>
				<div class="col-md-4"></div>
			</div>

		</form>
	</div>

</div>