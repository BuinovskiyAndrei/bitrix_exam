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
/** @global CCacheManager $CACHE_MANAGER */
global $CACHE_MANAGER;


/*************************************************************************
	Processing of received parameters
*************************************************************************/
if(!isset($arParams["CACHE_TIME"])){
	$arParams["CACHE_TIME"] = 1800000;
}

if (isset($_GET["F"])) {
	$arParams["CACHE_TIME"] = 0;
}

if (empty($arParams['PAGE_ELEMENT_COUNT']))
{
	$arParams['PAGE_ELEMENT_COUNT'] = 3;
}

$arNavParams = array(
	"nPageSize" => $arParams["PAGE_ELEMENT_COUNT"],
);

$arNavigation = CDBResult::GetNavParams($arNavParams);
		
	
if(!empty($arParams['IBLOCK_ID_PRODUCT']) && !empty($arParams['IBLOCK_ID_CLASSIFICATOR']) && !empty($arParams['PROPERTY_PRIVYZKA']) && $this->StartResultCache(false, array($USER->GetGroups(),$arNavigation)))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	
	//echo "<pre>";print_r($arNavigation);echo "</pre>";
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
	$rsIBlockElement = CIBlockElement::GetList(array("SORT" =>"DESC"), $arFilter, false, $arNavParams, $arSelect);
	while($arResClassificator = $rsIBlockElement->GetNext())
	{
		$idClassificator[] =  $arResClassificator["ID"];
		$arResult["ITEMS"][$arResClassificator["ID"]]["NAME"] =  $arResClassificator["NAME"];
	}
	$arResult["NAV_STRING"] = $rsIBlockElement->GetPageNavStringEx($navComponentObject, "", $arParams["PAGER_TEMPLATE"]);

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
		
		if(isset($_GET["F"])){
			$arFilter[]=[
				"LOGIC" => "OR",
				array("<=PROPERTY_PRICE" => 1700, "=PROPERTY_MATERIAL" => "Дерево, ткань"),
				array("<PROPERTY_PRICE" => 1500, "=PROPERTY_MATERIAL" => "Металл, пластик"),
			];
		}
		//EXECUTE
		$rsProduct = CIBlockElement::GetList($sort, $arFilter, false, false, $arSelect);
		$rsProduct->SetUrlTemplates($arParams["URL_TAMPLATE"]);
		while($arRes = $rsProduct->GetNext())
		{
			$arPrice[] = $arRes["PROPERTY_PRICE_VALUE"];
			$arButtons = CIBlock::GetPanelButtons(
				$arRes["IBLOCK_ID"],
				$arRes["ID"],
				$arRes["SECTION_ID"],
				array("SECTION_BUTTONS"=>false, "SESSID"=>false, "CATALOG"=>true)
			);

		
			$arResult["ITEMS"][$arRes["PROPERTY_".$arParams["PROPERTY_PRIVYZKA"]."_VALUE"]]["PRODUCT"][] = [
				"NAME" => $arRes["NAME"],
				"ID" => $arRes["ID"],
				"PRICE" => $arRes["PROPERTY_PRICE_VALUE"],
				"ARTNUMBER" => $arRes["PROPERTY_ARTNUMBER_VALUE"],
				"MATERIAL" => $arRes["PROPERTY_MATERIAL_VALUE"],
				"DETAIL_PAGE_URL" => $arRes["DETAIL_PAGE_URL"],
				"EDIT_LINK" => $arButtons["edit"]["edit_element"]["ACTION_URL"],
				"DELETE_LINK" => $arButtons["edit"]["delete_element"]["ACTION_URL"],
			];
		}
		
		$arResult["MIN_PRICE"] = min($arPrice);
		$arResult["MAX_PRICE"] = max($arPrice);
		
		$arResult["COUNT"] = count($idClassificator);
		
		//тег для инфоблока услуги
		$CACHE_MANAGER->RegisterTag("iblock_id_3");
		
		$this->SetResultCacheKeys(array(
			"COUNT",
		));
	
		$this->IncludeComponentTemplate();
	} else {
		$this->AbortResultCache();
	}
}

if ($APPLICATION->GetShowIncludeAreas())
{
	$this->AddIncludeAreaIcon(
		Array(
			"ID" => "Идентификатор кнопки",
			"TITLE" => "ИБ в админке",
			"URL" => "/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=".$arParams["IBLOCK_ID_PRODUCT"]."&type=products&lang=ru&find_el_y=Y",
			"IN_PARAMS_MENU" => true, //показать в контекстном меню
		)
	);
}
$APPLICATION->SetTitle(GetMessage("TITLE", array("#COUNT#"=>$arResult["COUNT"])));
//echo "<pre>";print_r($arResult);echo "</pre>"
?>
