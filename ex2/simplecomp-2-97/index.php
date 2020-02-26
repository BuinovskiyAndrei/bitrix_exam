<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("простой компонент 2-97");
?><?$APPLICATION->IncludeComponent(
	"ex2:simplecomp.exam_2-97",
	"",
	Array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_NEWS_ID" => "1",
		"PROPERTY_CODE" => "AUTHOR",
		"UF_PROPERTY_CODE" => "UF_AUTHOR_TYPE",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "180"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>