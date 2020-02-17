<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(

	"PARAMETERS" => array(
		"ID_IBLOCK_NEWS" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ID_IBLOCK_NEWS"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"ID_IBLOCK_CATALOG" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("ID_IBLOCK_CATALOG"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"UF_PROPERTY_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("UF_PROPERTY_CODE"),
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"CACHE_TIME"  =>  Array("DEFAULT"=>180),
	),
);
?>
