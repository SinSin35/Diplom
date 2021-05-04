<?php 
//создание таблицы заказов для админов
function tableZakazu($zakazID,$zakazName,$zakazPrice,$zakazKolvo,$zakazAdress,$zakazFIO,$zakazDATE){
	$tableZakazu="
	<div class='row pl-4 w-100'>
		<div class='col-md-1 border '>
			$zakazID
		</div>
		<div class='col-md-3 border'>
			$zakazName
		</div>
		<div class='col-md-1 border'>
			$zakazPrice
		</div>
		<div class='col-md-1 border'>
			$zakazKolvo
		</div>
		<div class='col-md-3 border'>
			$zakazAdress
		</div>
		<div class='col-md-2 border'>
			$zakazFIO
		</div>
		<div class='col-md-1 border'>
			$zakazDATE
		</div>
	</div>
	";
echo $tableZakazu;
}

//создание таблицы продуктов для админов
function tableProductu($productID,$productName,$productType,$prodPrice,$prodDiscPrice,$prodKolvo){
	$tableProductu="
	<div class='row text-center pl-4 w-100'>
		<div class='col-md-1 border'>
			$productID
		</div>
		<div class='col-md-3 border'>
			$productName
		</div>
		<div class='col-md-3 border'>
			$productType
		</div>
		<div class='col-md-2 border'>
			$prodPrice
		</div>
		<div class='col-md-2 border'>
			$prodDiscPrice
		</div>
		<div class='col-md-1 border'>
			$prodKolvo
		</div>
	</div>
	";
echo $tableProductu;
}

function tableUsers($userID,$userUsername,$userFIO,$userAdmin){
	$tableUsers="
	<div class='row text-center pl-4 w-100'>
		<div class='col-md-1 border'>
			$userID
		</div>
		<div class='col-md-2 border'>
			$userUsername
		</div>
		<div class='col-md-3 border'>
			$userFIO
		</div>
		<div class='col-md-3 border'>
			$userAdmin
		</div>
	</div>
	";
echo $tableUsers;
}
 ?>
