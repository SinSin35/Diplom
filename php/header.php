<div class="border border-info rounded">
	<a href="./index.php"><img src="./imgs/logo/logo.png" id="logo" alt="logo"></a>
	<div class="row" id="Header">
		<div class="col-md-3">Тел.: +7-496-731-14-14</div>
		<div class="col-md-6">Фестивальный пр-д, 1В, Протвино, Московская обл., Россия</div>
		<div class="col-md-3">Время работы: 10:00-19:00</div>
	</div>
	<nav class="navbar navbar-expand-lg navbar-light bg-light" id="NavbarMain">
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav">
				<form action="./index.php" method="post" class="form-inline" id="formHeader">
					<input class="form-control ml-sm-4 mr-sm-2 align-middle" name="MainSearch" id="MainSearch" type="text" placeholder="Поиск по товарам" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0 mr-sm-3" name="SearchSubmit" type="submit">Search</button>
				</form>
				<form action="./index.php" method="post" class="form-inline" id="formHeader2">
			      	<?php if(isset($_SESSION['userID'])){
			      		echo "
			      		<button type='submit' class='btn btn-light' name='cartt'><i class='fas fa-shopping-cart'></i> Корзина</button>
			      		<a class='nav-item nav-link ml-sm-3' id='logout' href='php/logout.inc.php'><i class='fas fa-user'></i> Выход</a>
			      		<p class='py-2 pl-4'>".$_SESSION['userFIO']."</p>";	
			      	}
			      	else {
			      		echo "
								<a class='nav-item nav-link mx-sm-3' href='./login.php'><i class='fas fa-shopping-cart'></i> Корзина</a>
			      			<a class='nav-item nav-link mr-sm-3' id='login' href='login.php'><i class='fas fa-user'></i> Вход</a>
			      			<hr>
			      			<a class='nav-item nav-link' href='signup.php'>Регистрация</a>"
			      			;
			      	} ?>
		      	</form>
			</div>
		</div>
	</nav>

</div>
