<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SPECIAL_DATE" => Array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage("T_IBLOCK_DESC_SPECIAL_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	
	"IBLOCK_ID_CANONICAL" => Array(
		"PARENT" => "DETAIL_SETTINGS",
		"NAME" => GetMessage("IBLOCK_ID_CANOINICAL"),
		"TYPE" => "STRING",
	),
);
?>
