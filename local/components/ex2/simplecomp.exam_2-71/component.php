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

if(!empty($arParams['IBLOCK_ID_PRODUCT']) && !empty($arParams['IBLOCK_ID_CLASSIFICATOR']) && !empty($arParams['PROPERTY_PRIVYZKA']) && $this->StartResultCache(false, $USER->GetGroups()))
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
		"NAME"
	);
	//WHERE
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID_CLASSIFICATOR"],
		"ACTIVE"=>"Y",
		"CHECK_PERMISSIONS"=>"Y",
	);

	//EXECUTE
	$rsIBlockElement = CIBlockElement::GetList(array("SORT" =>"DESC"), $arFilter, false, false, $arSelect);
	while($arResClassificator = $rsIBlockElement->GetNext())
	{
		$idClassificator[] =  $arResClassificator["ID"];
		$arResult[$arResClassificator["ID"]]["NAME"] =  $arResClassificator["NAME"];
	}
	
	if (!empty($idClassificator)) {
		$sort = [
			"name" => "asc",
			"SORT" =>"asc"
		];
		//SELECT
		$arSelect = array(
			"ID",
			"IBLOCK_ID",
			"NAME",
			"SECTION_ID",
			"PROPERTY_PRICE",
			"PROPERTY_ARTNUMBER",
			"PROPERTY_MATERIAL",
			"PROPERTY_".$arParams["PROPERTY_PRIVYZKA"],
			"DETAIL_PAGE_URL",
		);
		//WHERE
		$arFilter = array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID_PRODUCT"],
			"ACTIVE"=>"Y",
			"CHECK_PERMISSIONS"=>"Y",
			"PROPERTY_".$arParams['PROPERTY_PRIVYZKA'] => $idClassificator
		);
	
		//EXECUTE
		$rsProduct = CIBlockElement::GetList($sort, $arFilter, false, false, $arSelect);
		$rsProduct->SetUrlTemplates($arParams["URL_TAMPLATE"]);
		while($arRes = $rsProduct->GetNext())
		{
			$arResult[$arRes["PROPERTY_".$arParams["PROPERTY_PRIVYZKA"]."_VALUE"]]["PRODUCT"][] = [
				"NAME" => $arRes["NAME"],
				"PRICE" => $arRes["PROPERTY_PRICE_VALUE"],
				"ARTNUMBER" => $arRes["PROPERTY_ARTNUMBER_VALUE"],
				"MATERIAL" => $arRes["PROPERTY_MATERIAL_VALUE"],
				"DETAIL_PAGE_URL" => $arRes["DETAIL_PAGE_URL"],
			];
		}
		
		$arResult["COUNT"] = count($idClassificator);
		
		$this->SetResultCacheKeys(array(
			"COUNT"
		));
		
		$this->IncludeComponentTemplate();
	} else {
		$this->AbortResultCache();
	}
}

$APPLICATION->SetTitle(GetMessage("TITLE", array("#COUNT#"=>$arResult["COUNT"])));
?>
