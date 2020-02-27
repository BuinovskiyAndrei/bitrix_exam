<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент 2-71");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.exam_2-71",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_ID_PRODUCT" => "2",
		"IBLOCK_ID_CLASSIFICATOR" => "7",
		"URL_TAMPLATE" => "catalog_exam/#SECTION_ID#/#ELEMENT_CODE#",
		"PROPERTY_PRIVYZKA" => "PREVYZKA_K_FIRME",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "180"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>