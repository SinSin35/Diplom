<?php
//создание формы полного описания товара  
function product($prodimg,$prodprice,$proddiscprice,$prodname,$prodopis,$prodid,$conn){
$product = "
<div class='col-md-6 my-3 my-md-0'>
	<div class='product'>
		<img src='$prodimg' class='img-fluid p-3 product_image'>
	</div>
</div>
<div class='col-md-6 my-3 my-md-0'>
	<div class='card-deck mb-3 text-center'>
		<div class='card mb-4 shadow-sm'>
			<div class='card-body'>
				<h4>
					$prodname
				</h4>
				<div class='dropdown-divider'></div>";
				//если цена со скидкой равна обычной цене
				if($prodprice==$proddiscprice){
					$product.="	<h1 class='card-title pricing-card-title'>
									$prodprice Р
								</h1>";
				}
				//если цена со скидкой не равна обычной цене
				else{
					$product.="<h1>
					<small><s class='text-secondary'>$prodprice P</s></small>
					<span class='price' id='disc'>$proddiscprice  P</span>
					</h1>";
				}
				$product.="
				<p>
					<span class='font-weight-bold'>Телефон:</span> +7-496-731-14-14
				</p>
				<p>
					<span class='font-weight-bold'>Условия оплаты:</span> Наличный расчет
				</p>
				<p>
					<span class='font-weight-bold'>Доставка:</span> Доставка курьером от 1 до 3 дней
				</p>
				<p>
					<span class='font-weight-bold'>Время работы:</span> Пн-пт 10:00-19:00
				</p>
				<form action='index.php' method='post'>";
				//если пользователь авторизовался
				if(isset($_SESSION['userID'])){
					$sql = "SELECT * FROM zakaz WHERE (Prod_id=".$prodid.")&&(User_id=".$_SESSION['userID'].");";
					$result = mysqli_query($conn,$sql);
					$resultCheck = mysqli_num_rows($result);
					if ($resultCheck == 0){
					$product.="<button class='btn btn-warning' name='add' style='width:70%'>Добавить в корзину</button>
								<input type='hidden' name='product_id' value='$prodid'>";
					}
					else{
						$row=mysqli_fetch_assoc($result);
						if ($row['bool']==0){
							$product.="
							<button class='btn btn-danger' name='delete' style='width:70%'>Удалить из корзины</button>
							<input type='hidden' name='product_id' value='$prodid'>";	
						}
						else if($row['bool']==1){
							$product.="<button class='btn btn-secondary' disabled style='width:70%'>Заказано</button>
							<input type='hidden' name='product_id' value='$prodid'>";
						}			
					}
				}
				else{
					$product.="
								<a class='btn btn-warning' href='./login.php' style='width:70%'>Добавить в  корзину</a>
								<input type='hidden' name='product_id' value='$prodid'>";}
					$product.="
				</form>
			</div>
		</div>
	</div>
</div>
<div class='col-md-12 my-3 my-md-0 productOpis'>
	<div class='text-left'>
		$prodopis
	</div>
</div>
";
echo $product;
}

?>	