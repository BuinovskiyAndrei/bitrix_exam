<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"IBLOCK_NEWS_ID" => array(
            "PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_NEWS_ID"),
			"TYPE" => "STRING",
		),
        "PROPERTY_CODE" => array(
            "PARENT" => "BASE",
			"NAME" => GetMessage("PROPERTY_CODE"),
			"TYPE" => "STRING",
		),
        "UF_PROPERTY_CODE" => array(
            "PARENT" => "BASE",
			"NAME" => GetMessage("UF_PROPERTY_CODE"),
			"TYPE" => "STRING",
		),
        "CACHE_TIME"  =>  Array("DEFAULT"=>180),
	),
);