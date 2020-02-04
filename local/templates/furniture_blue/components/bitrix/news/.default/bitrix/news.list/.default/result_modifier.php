<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arParams['SPECIAL_DATE'] == 'Y'){
    //echo "<pre>";print_r();echo "</pre>";
    $arResult["SPECIAL_DATE"] = $arResult['ITEMS']['0']['ACTIVE_FROM'];
    $cp = $this->__component;
    $cp->SetResultCacheKeys(array('SPECIAL_DATE'));
}