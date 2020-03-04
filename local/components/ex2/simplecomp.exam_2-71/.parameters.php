<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCK_ID_PRODUCT" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_ID_PRODUCT"),
			"TYPE" => "STRING",
		),
		"IBLOCK_ID_CLASSIFICATOR" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_ID_CLASSIFICATOR"),
			"TYPE" => "STRING",
		),
		"URL_TAMPLATE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("URL_TAMPLATE"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"PROPERTY_PRIVYZKA" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("PROPERTY_PRIVYZKA"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"PAGE_ELEMENT_COUNT" => array(
            "PARENT" => "BASE",
			"NAME" => GetMessage("PAGE_ELEMENT_COUNT"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>180),
	),
);
?>
