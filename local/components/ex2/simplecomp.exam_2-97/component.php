<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if(!$USER->IsAuthorized())
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_NOT_AUTHORIZE"));
	return;
}

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 180;

if(!empty($arParams['IBLOCK_NEWS_ID']) && !empty($arParams['PROPERTY_CODE']) && !empty($arParams['UF_PROPERTY_CODE']) && $this->StartResultCache(false, $USER->GetID()) )
{
	
	//current user
	$sortOrder = "asc";
	$arOrderUser = array("id");
	$arFilterUser = [
		"ACTIVE" => "Y",
		"ID" => $USER->GetID(),
	];
	$arParameters = [
		"SELECT" =>[
			$arParams['UF_PROPERTY_CODE'],
		],
		"FIELDS" =>[
			"ID"
		],
	];
	
	$rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser,$arParameters); // выбираем пользователей
	while($arUser = $rsUsers->GetNext())
	{
		$currentUserAuthorType = $arUser["UF_AUTHOR_TYPE"];
	}
	
	// user
	$arOrderUser = array("id");
	$sortOrder = "asc";
	$arFilterUser = array(
		"ACTIVE" => "Y",
		$arParams['UF_PROPERTY_CODE'] => $currentUserAuthorType,
	);
	
	$arParameters = [
		"FIELDS" =>[
			"ID",
			"LOGIN",
		],
	];
	
	$arResult["USERS"] = array();
	$rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser, $arParameters); // выбираем пользователей
	while($arUser = $rsUsers->GetNext())
	{
		$userId[] = $arUser["ID"];
		$arResult["USERS"][] = $arUser;
	}
	
	
	//iblock elements
	$arSelectElems = array (
		"ID",
		"IBLOCK_ID",
		"NAME",
		"ACTIVE_FROM",
		"PROPERTY_".$arParams['PROPERTY_CODE'],
	);
	$arFilterElems = [
		"IBLOCK_ID" => $arParams["IBLOCK_NEWS_ID"],
		"ACTIVE" => "Y",
		"PROPERTY_".$arParams['PROPERTY_CODE'] => $userId,
	];
	
	$arResult["ELEMENTS"] = array();
	$rsElements = CIBlockElement::GetList([], $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElements->GetNext())
	{
		if($arElement["PROPERTY_".$arParams['PROPERTY_CODE']."_VALUE"] == $USER->GetID()){
			$curentUserNews[] = $arElement["ID"];
		}else{
			$arResult["ELEMENTS"][$arElement["PROPERTY_".$arParams['PROPERTY_CODE']."_VALUE"]][] = $arElement;
		}
	}	
	
	$count = 0;
	foreach ($arResult["USERS"] as $userKey=>$user) {
		foreach ($arResult["ELEMENTS"][$user["ID"]] as $key=>$news) {
			if (in_array($news["ID"],$curentUserNews)) {
				unset($arResult["ELEMENTS"][$user["ID"]][$key]);
			}
		}
		$count += count($arResult["ELEMENTS"][$user["ID"]]);
		if(count($arResult["ELEMENTS"][$user["ID"]]) <=0) {
			unset($arResult["USERS"][$userKey]);
		}
	}
	
	$arResult["COUNT"] = $count;
	$this->setResultCacheKeys("COUNT");
	$this->includeComponentTemplate();		
}

$APPLICATION->SetTitle(GetMessage("TITLE", ["#COUNT#" =>$arResult["COUNT"]]));
?>