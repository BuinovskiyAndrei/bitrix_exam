<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("T_IBLOCK_DESC_PHOTO_LIST"),
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_PHOTO_DESC"),
	"CACHE_PATH" => "Y",
	"SORT" => 40,
	"PATH" => array(
		"ID" => "my_component",
        "NAME" => GetMessage("T_IBLOCK_EX2"),
		"SORT" => 20,
	),
);

?>