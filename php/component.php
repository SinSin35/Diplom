<?php
//создание формы продукта на главной странице
function component($productimage,$productname,$producttext,$productdiscount,$productprice,$productid,$conn){
$element = "
<div class='col-md-4 col-sm-6 my-3 py-3 my-md-0'>
	<form action='index.php' method='post'>
		<div class='card shadow'>
			<a href='./index.php?product=$productid'>
			<div id='card-top'>
				<img src='$productimage' alt='$productname' class='img-fluid card-img-top'>
			</div>
			<div class='card-body'>
				<h5 class='card-title'>
					$productname
				</h5>
			</a>
				<p class='card-text' id='description'>
					$producttext
				</p>";
				//если обычная цена равна цене со скидкой, оставляем только цену со скидкой
				if($productprice==$productdiscount){
					$element.="<h5>
					<span class='price' id='disc'> $productprice P</span>
					</h5>";
				}
				//если не равна, то выводим обычную и цену скидкой
				else{
					$element.="<h5>
					<small><s class='text-secondary' id='nondisc'>$productdiscount</s></small>
					<span class='price' id='disc'> $productprice P</span>
					</h5>";
				};

				//если пользователь авторизовался
				if(isset($_SESSION['userID'])){
					$sql = "SELECT * FROM zakaz WHERE (Prod_id=".$productid.")&&(User_id=".$_SESSION['userID'].");";
					$result = mysqli_query($conn,$sql);
					$resultCheck = mysqli_num_rows($result);
					$row=mysqli_fetch_assoc($result);
					if ($resultCheck == 0){		//если продукт не добавлен в корзину и не заказан
					$element.="<button type='submit' class='btn btn-warning my-3' name='add'>Добавить в корзину</button>
								<input type='hidden' name='product_id' value='$productid'>";}
					else{
						if($row['bool']==0){	//если продукт добавлен в корзину
					$element.="<button type='submit' class='btn btn-danger my-3' name='delete'>Удалить из корзины</button>
						<input type='hidden' name='product_id' value='$productid'>";
						}
						else 	//если продукт заказан
							$element.="<button type='submit' disabled class='btn btn-secondary my-3'>Заказано</button>";					
					};
				}
				//если пользователь не авторизовался
				else{	
					$element.="<a href='./login.php' class='btn btn-warning my-3'>Добавить в корзину</a>
								<input type='hidden' name='product_id' value='$productid'>";
				};
				$element.="
			</div>
		</div>
	</form>
</div>";
echo $element;
}
?>

