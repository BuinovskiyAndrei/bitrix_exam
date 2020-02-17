<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


/*************************************************************************
	Processing of received parameters
*************************************************************************/
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 180;


if(!empty($arParams["ID_IBLOCK_NEWS"]) && $this->StartResultCache())
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	//SELECT
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"NAME",
		"ACTIVE_FROM",
	);
	//WHERE
	$arFilter = array(
		"IBLOCK_ID" => $arParams["ID_IBLOCK_NEWS"],
		"ACTIVE"=>"Y",
	);
	//EXECUTE
	$rsIBlockElement = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
	while($arRes = $rsIBlockElement->GetNext()) {
		$news[$arRes['ID']]["NAME"] = $arRes["NAME"];
		$news[$arRes['ID']]["ACTIVE_FROM"] = $arRes["ACTIVE_FROM"];
		$newsId[] = $arRes['ID'];
	}
	
	$sectionId = array();	
	$arSelect = array(
		"NAME",
		"ID",
		$arParams["UF_PROPERTY_CODE"]
	);
	$arFilter = Array(
		'IBLOCK_ID'=>$arParams["ID_IBLOCK_CATALOG"],
		'GLOBAL_ACTIVE'=>'Y',
		"!".$arParams["UF_PROPERTY_CODE"]=>false
	);
	
	$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true, $arSelect);
	while($ar_result = $db_list->GetNext())
	{
		$sectionId[] = $ar_result["ID"];
		$sectionRes[$ar_result["ID"]]["NAME"] = $ar_result["NAME"];
		$sectionRes[$ar_result["ID"]][$arParams["UF_PROPERTY_CODE"]] = $ar_result[$arParams["UF_PROPERTY_CODE"]];
	}
	
	//SELECT
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
		"IBLOCK_SECTION_ID",
		"NAME",
		"PROPERTY_ARTNUMBER",
		"PROPERTY_MATERIAL",
		"PROPERTY_PRICE",
	);
	//WHERE
	
	$arFilter = array(
		"IBLOCK_ID" => $arParams["ID_IBLOCK_CATALOG"],
		"ACTIVE"=>"Y",
		"SECTION_ID" => $sectionId
	);

	//EXECUTE
	$rsIBlockElement = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
	while($arRes = $rsIBlockElement->GetNext()) {
		$product[] = array(
			"NAME"=>$arRes["NAME"],
			"ARTNUMBER"=>$arRes["PROPERTY_ARTNUMBER_VALUE"],
			"MATERIAL"=>$arRes["PROPERTY_MATERIAL_VALUE"],
			"PRICE"=>$arRes["PROPERTY_PRICE_VALUE"],
			"SECTION_ID"=>$arRes["IBLOCK_SECTION_ID"]
		);
	}
	
	$arResult["ITEMS"] = array();
	foreach($news as $newsId=>$newsItem){
		$arResult["ITEMS"][$newsId] = $newsItem;
		$sectionId = array();
		foreach($sectionRes as $secId=>$section){
			if(in_array($newsId, $section["UF_NEWS_LINK"])){
				$arResult["ITEMS"][$newsId]["SECTION"][$secId] = $section["NAME"];
				$sectionId[] = $secId;
			}
		}
		foreach($product as $prod){
			if(in_array($prod["SECTION_ID"],$sectionId)){
				$arResult["ITEMS"][$newsId]["PRODUCT"][] = $prod;
			}
		}
	}
	
	$arResult["COUNT_PRODUCT"] = count($product);
	$this->SetResultCacheKeys(array("COUNT_PRODUCT"));
	$this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("TITLE", array("#COUNT#"=>$arResult["COUNT_PRODUCT"])));

?>
