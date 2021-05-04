<?php
//создание формы продукта в корзине 
function cart($prodimage,$prodname,$prodprice,$prodopismin,$productid,$prodkolvo){
	$cart="
	<div class='cold-md-12 w-100'>
		<form action='index.php' method='post'>
		<div class='cart pl-3 w-100'>
			<div class='card mb-3 w-100' >
			  	<div class='row no-gutters w-100'>
			    	<div class='col-md-3 cartitem'>
			    		<a href='./index.php?product=$productid'>
			      		<img src='$prodimage' class='img-fluid card-img w-100' alt='$prodname'>
			      		</a>
			    	</div>
			    	<div class='col-md-7'>
			      		<div class='card-body'>
			      			<a href='./index.php?product=$productid'>
			        		<h5 class='card-title'>$prodname</h5>
			        		</a>
			        		<h2>$prodprice P</h2>
			        		<p class='card-text'>$prodopismin</p>
			        
			       			 <div class='align-bottom h-100'>
			        			<button class='btn btn-danger' name='delete' style='width:50%'>Удалить из корзины</button>
			    				<button class='btn btn-success' name='buy' style='width:45%'>Заказать</button>
			       				<input type='hidden' name='product_id' value='$productid'>
			       			 </div>
			       			 <p class='text-danger'>Осталось: $prodkolvo</p>
			      		</div>
			    	</div>
			    	<div class='col-md-2 quantityDiv'>
						<div class='quantity'>
							<i class='fas fa-minus-circle plusminus' data-step='-1'></i>
							<input type='text' class='quantityInput' name='kolvo' value='1' readonly>
							<i class='fas fa-plus-circle plusminus' data-step='1'></i>
						</div>
			    	</div>
			  	</div>
			</div>		
		</div>
		</form>
	</div>
	";
echo $cart;
}

//создание формы заказа
function zakaz($prodimage,$prodname,$prodprice,$prodopismin,$productid,$prodkolvo){
	$zakaz="
	<div class='cold-md-12 w-100'>
		<form action='index.php' method='post'>
		<div class='cart pl-3 w-100'>
			<div class='card mb-3 w-100' >
			  	<div class='row w-100 no-gutters'>
			    	<div class='col-md-3 cartitem'>
			    		<a href='./index.php?product=$productid'>
			      		<img src='$prodimage' class='img-fluid card-img w-100' alt='$prodname'>
			      		</a>
			    	</div>
			    	<div class='col-md-7'>
			      		<div class='card-body'>
			      			<a href='./index.php?product=$productid'>
			        		<h5 class='card-title'>$prodname</h5>
			        		</a>
			        		<h2>$prodprice P</h2>
			        		<p class='card-text'>$prodopismin</p>
			        
			      		</div>
			    	</div>
			    	<div class='col-md-2'>
			    		<p class='font-weight-bold'>Заказано: $prodkolvo</p>
			    	</div>
			  	</div>
			</div>		
		</div>
		</form>
	</div>
	";
echo $zakaz;
}
?>



