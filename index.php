<?php
	session_start(); //создаем сессию для пользователя
	// header('Content-Type: text/html; charset=utf-8');
	include_once("php/db_connection.php"); //подключение к БД
	require_once("php/component.php");  //подключаем файл создания формы товара на главной странице
	require_once("php/product.php");  //подключаем файл создания формы полного описания товара
	require_once("php/cart.php");	//подключаем файл создания товаров в корзине товаров

	$users_id = $_SESSION['userID'];	//текущий пользователь
	$prods_id = $_POST["product_id"];	//текущий продукт

	if(isset($_POST['add'])){			//по нажатию на кнопку добавить товар в корзину
	$sql="INSERT INTO zakaz(Zakaz_id, User_id, Prod_id, kolvo) VALUES (NULL, '$users_id', '$prods_id', '1')";
	mysqli_query($conn,$sql);
	}

	else if(isset($_POST['delete'])){	//по нажатию на кнопку удалить товар из корзины
	$sql="DELETE FROM zakaz WHERE (User_id=".$users_id.")&&(Prod_id=".$prods_id.");";
	mysqli_query($conn,$sql);
	}

	else if(isset($_POST['DeleteZakaz'])){	//Админское меню: удалить заказ
	$sql="DELETE FROM zakaz WHERE Zakaz_id=".$_POST['DeleteZakaz'].";";
	mysqli_query($conn,$sql);
	}

	else if(isset($_POST['DeleteProduct'])){	//Админское меню: удалить товар
	$sql="DELETE FROM product WHERE Prod_id=".$_POST['DeleteProduct'].";";
	mysqli_query($conn,$sql);
	}

	else if(isset($_POST['ToggleAdmin'])){	//Админское меню: добавить/убрать права админа
	$sql="UPDATE user SET User_Admin = !User_Admin WHERE User_id=".$_POST['ToggleAdmin'].";";
	mysqli_query($conn,$sql);
	}

	else if(isset($_POST['AdminAddProduct'])){	//Админское меню: добавить или обновить имеющийся продукт
		$prod_id = $_POST['productID'];
		$prod_name = $_POST['productName'];
		$prod_type=$_POST['productType'];
		$prod_price=$_POST['productPrice'];
		$prod_disc_price = $_POST['productDiscPrice'];
		$prod_kolvo = $_POST['productKolvo'];
		$prod_image = $_POST['productImage'];
		$prod_opis = $_POST['productOpis'];
		$prod_opis_min = $_POST['productOpisMin'];
		if($prod_id==NULL)		//если идентификатор не введен, то добавление нового товара
			$sql="INSERT INTO product(Prod_id,Prod_name,Prod_id_type,Prod_price,Prod_disc_price,Prod_kolvo,Prod_image,Prod_opis,Prod_opis_min) 
			VALUES (NULL,'$prod_name','$prod_type','$prod_price','$prod_disc_price','$prod_kolvo','$prod_image','$prod_opis','$prod_opis_min');";
		else{					//если идентификатор введен, то обновление данных введенного товара
			$sql = "SELECT * FROM product where Prod_id=$prod_id";	//текущая информация о продукте
			$result=mysqli_query($conn,$sql);
			$row=mysqli_fetch_assoc($result);

			//если поле не заполнено, то оставляем неизмененным
			if ($prod_name==NULL) $prod_name=$row['Prod_name'];		
			if ($prod_type==NULL) $prod_type=$row['Prod_id_type'];
			if ($prod_price==NULL) $prod_price=$row['Prod_price'];
			if ($prod_disc_price==NULL) $prod_disc_price=$row['Prod_disc_price'];
			if ($prod_kolvo==NULL) $prod_kolvo=$row['Prod_kolvo'];
			if ($prod_image==NULL) $prod_image=$row['Prod_image'];
			if ($prod_opis==NULL) $prod_opis=$row['Prod_opis'];
			if ($prod_opis_min==NULL) $prod_opis_min=$row['Prod_opis_min'];
			//

			$sql="UPDATE product SET Prod_name='$prod_name',Prod_id_type='$prod_type',Prod_price='$prod_price',Prod_disc_price='$prod_disc_price',Prod_kolvo='$prod_kolvo',Prod_image='$prod_image',Prod_opis='$prod_opis',Prod_opis_min='$prod_opis_min' WHERE Prod_id='$prod_id';";
		}
		mysqli_query($conn,$sql);
	}

	else if(isset($_POST["buy"])){		//по нажатию на кнопку добавить товар из корзины в заказы
		$sql="SELECT Prod_kolvo FROM product where Prod_id=".$prods_id.";";	//Узнаем количество данного товара
		$result=mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		if((int)$row["Prod_kolvo"]>=(int)$_POST["kolvo"]){		//Если количество товара на складе больше/равно количеству заказываемого товара, то заказ проходит
			$sql="UPDATE zakaz SET data=(SELECT CURRENT_DATE),kolvo=".$_POST["kolvo"]." WHERE (User_id=".$users_id.")&&(Prod_id=".$prods_id.");";
			mysqli_query($conn,$sql);
			$sql="UPDATE product SET Prod_kolvo=".((int)$row["Prod_kolvo"]-(int)$_POST["kolvo"])." WHERE Prod_id=".$prods_id.";";
			mysqli_query($conn,$sql);	
		}
		else{		// в ином случае выдает ошибку
			$message = "Неверно указано количество товара";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
	}	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta  content="charset=utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">	<!-- Bootstrap -->
		<link rel="stylesheet" href="css/styles.css">			<!-- Файл CSS -->
		<script src="https://kit.fontawesome.com/739623eb5a.js" crossorigin="anonymous"></script>	<!-- Значки -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>	<!-- JQuery -->

		<title>Интернет-магазин Курсор</title>
	</head>
	
	<body>
		<div id="form">			<!-- форма с шириной 75% по середине -->	
			<?php require_once("php/header.php")?>	<!-- Добавление хэдера страницы -->
			<?php require_once("php/menu.php")?>	<!-- Добавления меню -->
			<div class="container">		
			<?php
				if($_SESSION['userAdmin']===1){		//Если логиниться админ
					require_once("php/table.php");	//Подключаем файл для создания таблицы заказов админа
					echo "	
					<form action='index.php' method='post'>			<!-- Форма отправки на главную страницу -->
						<button type='submit' class='btn btn-success mb-2 mr-2' name='AdminZakazu'>Все заказы</button>	<!-- Кнопка для показа таблицы всех заказов -->
						<button type='submit' class='btn btn-warning mb-2 mr-2' name='AdminProductu'>Все продукты</button>	<!-- Кнопка для показа таблицы всех товаров -->
						<button type='submit' class='btn btn-info mb-2 mr-2' name='AdminAdd'>Добавить/обновить продукт</button>		<!-- Кнопка для заказа/обновления данных товара -->
						<button type='submit' class='btn btn-danger mb-2 mr-2' name='Administration'>Добавить/убрать администратора</button>		<!-- Кнопка для добавления/удаления прав администратора -->
					</form>	
					";	
				}
			?>

				<div class="row text-center py-4 pl-4">			<!-- строка -->
					<?php
					if(isset($_POST['AdminZakazu'])){	//По нажатию на кнопку показ таблицы заказов
						//кнопка удаления продукта
						echo "
						<form action='index.php' method='post'>
						<input type='number' id='DeleteID' name='DeleteZakaz' placeholder='Идентификатор' min='1'>
						<button class='btn btn-danger mb-3 ml-2'>Удалить заказ</button>
						</form>	
						";
						//
						tableZakazu('id','Название','Цена','Кол-во','Адрес покупателя','ФИО покупателя','Дата');
						$sql="SELECT * FROM zakaz INNER JOIN product USING(Prod_id) INNER JOIN user USING (User_id) WHERE data IS NOT NULL";  //sql запрос для показа всех заказов
						$result = mysqli_query($conn,$sql);		//посылаем sql запрос в БД
						$resultCheck = mysqli_num_rows($result);	//подсчет строк по sql запросу
						if ($resultCheck > 0){						//если есть заказы
							while($row=mysqli_fetch_assoc($result)){	//цикл выборки по одной строке 
								tableZakazu($row['Zakaz_id'],$row['Prod_name'],$row['Prod_disc_price']*$row['kolvo'],$row['kolvo'],$row['User_adress'],$row['User_FIO'],$row['data']); //строка таблицы заказов
							}
						}
					}

					else if(isset($_POST['AdminProductu'])){	//По нажатию на кнопку показ таблицы продуктов
						//кнопка удаления продукта
						echo "		
						<form action='index.php' method='post'>
						<input type='number' id='DeleteID' name='DeleteProduct' placeholder='Идентификатор' min='1'>
						<button class='btn btn-danger mb-3 ml-2'>Удалить продукт</button>
						</form>	
						";
						//

						tableProductu('id','Название','Тип','Цена','Цена со скидкой','Кол-во');
						$sql = "SELECT * FROM product INNER JOIN categories USING(Prod_id_type) ORDER BY Prod_id ASC;"; //выводим все продукты в таблицу по возрастанию id
						$result = mysqli_query($conn,$sql);		//посылаем sql запрос в БД
						$resultCheck = mysqli_num_rows($result);	//подсчет строк по sql запросу
						if ($resultCheck > 0){						//если есть продукты
							while($row=mysqli_fetch_assoc($result)){	//цикл выборки по одной строке 
								tableProductu($row['Prod_id'],$row['Prod_name'],$row['TypeName'],$row['Prod_price'],$row['Prod_disc_price'],$row['Prod_kolvo']); //строка таблицы продуктов
							}
						}
					}

					else if(isset($_POST['AdminAdd'])){
						//форма добавления/обновления продукта
						echo "
							<p class='font-weight-light'>* Для добавления нового продукта - введите все кроме идентификатора.</p>
							<p class='font-weight-light'>* Для обновления столбцов старого продукта- введите его идентификатор и поля которые хотите изменить.</p>
							<form action='index.php' class='mx-0 w-75 justfiy-contenc-center' method='post'>
								<div class='w-100'>
									<button class='btn btn-success my-3' name='AdminAddProduct'>Добавить/обновить продукт</button>
									<input type='number' class='form-control mb-2' name='productID' placeholder='Идентификатор'>
									<input type='text' class='form-control mb-2' name='productName' placeholder='Название'>
									<select class='custom-select w-100 mb-2' name='productType'>
										<option value='' selected disabled hidden>Категория</option>
										<option value='1'>Наушники</option>
										<option value='2'>Колонки</option>
										<option value='3'>Видеокамеры и фотоаппараты</option>
										<option value='5'>Видеорегистраторы</option>
										<option value='6'>Компьютеры</option>
										<option value='7'>Игровые компьютеры</option>
										<option value='8'>Компьютеры Apple</option>
										<option value='9'>Мониторы</option>
										<option value='10'>Игровые мониторы</option>
										<option value='11'>Ноутбуки Apple</option>
										<option value='12'>Игровые ноутбуки</option>
										<option value='13'>Трансформеры 2 в 1</option>
										<option value='14'>Ультрабуки</option>
										<option value='15'>Клавиатуры/компьютерные мыши</option>
										<option value='18'>Микрофоны</option>
										<option value='19'>Apple iPad</option>
										<option value='20'>Планшеты Samsung</option>
										<option value='21'>Планшеты Huawei</option>
										<option value='22'>Аксессуары для планшетов</option>
										<option value='23'>Принтеры</option>
										<option value='24'>Сканеры</option>
										<option value='25'>Картриджи</option>
										<option value='26'>Бумага для принтеров</option>
									</select>
									<input type='text' class='form-control mb-2' name='productPrice' placeholder='Цена'>
									<input type='text' class='form-control mb-2' name='productDiscPrice' placeholder='Цена со скидкой'>
									<input type='text' class='form-control mb-2' name='productImage' placeholder='Адрес изображения'>
									<input type='text' class='form-control mb-2' name='productKolvo' placeholder='Кол-во'>
									<input type='text' class='form-control mb-2' name='productOpisMin' placeholder='Короткое описание'>
									<textarea class='form-control' name='productOpis' placeholder='Описание'></textarea>
								</div>
							</form>
						";
					}

					else if (isset($_POST['Administration'])){
						echo "
						<form action='index.php' method='post'>
						<input type='number' id='AddAdminstrator' name='ToggleAdmin' placeholder='Идентификатор' min='1'>
						<button class='btn btn-danger mb-3 ml-2'>Добавить/убрать права администратора</button>
						</form>	
						";
						//
						tableUsers('id','Логин','ФИО','Права администратора');
						$sql="SELECT * FROM user";  //sql запрос для показа всех пользователей
						$result = mysqli_query($conn,$sql);		//посылаем sql запрос в БД
						$resultCheck = mysqli_num_rows($result);	//подсчет строк по sql запросу
						if ($resultCheck > 0){						//если есть пользователи
							while($row=mysqli_fetch_assoc($result)){	//цикл выборки по одной строке 
								tableUsers($row['User_id'],$row['User_username'],$row['User_FIO'],$row['User_Admin']); //строка таблицы заказов
							}
						}
					}

					else if (isset($_GET['product'])){		//отображение страницы продукта
						 $sql="SELECT * FROM product where Prod_id=".$_GET['product'].";";
						 $result = mysqli_query($conn,$sql);
						 $row=mysqli_fetch_assoc($result);
						 product($row['Prod_image'],$row['Prod_price'],$row['Prod_disc_price'],$row['Prod_name'],nl2br($row['Prod_opis']),$row['Prod_id'],$conn);
					}

					else if(isset($_POST['cartt'])){	//отображение корзины
						$sql="SELECT * FROM zakaz INNER JOIN product USING(Prod_id) WHERE User_id=".$users_id.";";
						$sql1="SELECT * FROM zakaz INNER JOIN product USING(Prod_id) WHERE (User_id=".$users_id.")&&(data IS NOT NULL);";	
						$sql2="SELECT * FROM zakaz INNER JOIN product USING(Prod_id) WHERE (User_id=".$users_id.")&&(data IS NULL);";
						$result = mysqli_query($conn,$sql);
						$result1= mysqli_query($conn,$sql1);
						$result2= mysqli_query($conn,$sql2);
						$resultCheck = mysqli_num_rows($result);
						$resultCheck1 = mysqli_num_rows($result1);
						$resultCheck2 = mysqli_num_rows($result2);
						if ($resultCheck > 0){		//если в корзине есть товары/заказы
						 	if($resultCheck1>0){	//если есть заказы
						 		echo "<h2 class='mx-auto'>Заказы</h2>";
						 		while($row=mysqli_fetch_assoc($result1)){
						 		zakaz($row['Prod_image'],$row['Prod_name'],$row['Prod_disc_price'],$row['Prod_opis_min'],$row['Prod_id'],$row['kolvo']);}
						 		if($resultCheck2>0){	//случай когда есть и товары в корзине, и заказы
						 			echo "<h2 class='mx-auto'>Корзина</h2>";
						 			while($row=mysqli_fetch_assoc($result2)){
						 			cart($row['Prod_image'],$row['Prod_name'],$row['Prod_disc_price'],$row['Prod_opis_min'],$row['Prod_id'],$row['Prod_kolvo']);}
						 		}
						 	}
						 	else{
						 		echo "<h2 class='mx-auto'>Корзина</h2>";	//случай когда есть только товары в корзине
						 		while($row=mysqli_fetch_assoc($result2)){
						 			cart($row['Prod_image'],$row['Prod_name'],$row['Prod_disc_price'],$row['Prod_opis_min'],$row['Prod_id'],$row['Prod_kolvo']);}
						 	}
						}
						else{
							echo "<h1>Корзина пуста</h1>";	//случай когда нет ни товаров в корзине, ни заказов
						}
					}			 
					else{
						if (isset($_GET['categories'])){	//выбор категорий товаров
							if($_GET['categories']=='27'){	//если выбраны Все ноутбуки
								$sql = "SELECT * FROM product INNER JOIN categories USING(Prod_id_type) where ((Prod_id_type=11)||(Prod_id_type=12)||(Prod_id_type=13)||(Prod_id_type=14))";	
							}	
							else if($_GET['categories']=='28'){		//если выбраны Все планшеты
								$sql = "SELECT * FROM product INNER JOIN categories USING(Prod_id_type) where ((Prod_id_type=19)||(Prod_id_type=20)||(Prod_id_type=21))";
							}
							else{		//если выбрана любая другая категория
								$sql = "SELECT * FROM product INNER JOIN categories USING(Prod_id_type) WHERE Prod_id_type=".$_GET['categories'].";";
							} 						
							
						}
						else if(isset($_POST['MainSearch'])){		//выбор продуктов по поиску
							$searchq=$_POST['MainSearch'];		//введенный текст в поиск
							
							$sql="SELECT * FROM product INNER JOIN categories USING(Prod_id_type) WHERE ((Prod_name LIKE '%$searchq%')||(Prod_opis_min LIKE '%$searchq%'));";
						}
						//в любом другом случае показывать главную страницу - все товары в рандомном порядке
						else{$sql = "SELECT * FROM product INNER JOIN categories USING(Prod_id_type) ORDER BY rand();";}
						$result = mysqli_query($conn,$sql);
						$resultCheck = mysqli_num_rows($result);
						if ($resultCheck > 0){	
							while($row=mysqli_fetch_assoc($result)){
							component($row['Prod_image'],$row['Prod_name'],$row['Prod_opis_min'],$row['Prod_price'],$row['Prod_disc_price'],$row['Prod_id'],$conn);
							}	
						}
						else{
							echo "<h1>Таких товаров нет :(</h1>";
						}
					}
					?>
				</div>
			</div>
		</div>
	</body>

<!-- Увеличение и уменьшение количества товара на 1 по нажатию на кнопку -->
<script src="js/app.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>