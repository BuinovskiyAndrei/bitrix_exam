<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оценка производительности");
?>
<?
//[ex2-88] Оценить скорость работы сайта – страницы и созданный простой компонент «Каталог товаров»
echo "/products/index.php - 23.88% <br>";
echo "размер кеша со всеми данными 14136-все данные в кеше. 9660-только нужные данные в кеше <br><br>";

//[ex2-10] Оценить скорость работы сайта – найти самую долгую страницу и самый долгий компонент
echo "/products/index.php - 22.07% <br>";
echo "bitrix:catalog 0.0404 сек.<br><br>";

//[ex2-11] Оценить скорость работы сайта – найти самую долгую страницу и количество запросов 
echo "/products/index.php - 22.07% <br>";
echo "bitrix:catalog.section 9 запр.<br><br>";
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>