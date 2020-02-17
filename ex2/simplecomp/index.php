<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.exam",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"ID_IBLOCK_NEWS" => "1",
		"ID_IBLOCK_CATALOG" => "2",
		"UF_PROPERTY_CODE" => "UF_NEWS_LINK",
		"CACHE_TYPE" => "Y",
		"CACHE_TIME" => "180"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>