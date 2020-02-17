<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$strElementAdd = CIBlock::GetArrayByID($arParams["IBLOCK_ID_PRODUCT"], "ELEMENT_ADD");
$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID_PRODUCT"], "ELEMENT_EDIT");
$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID_PRODUCT"], "ELEMENT_DELETE");
$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?><?echo time();?>
<a	href="<?=$APPLICATION->GetCurPage()?>?F=Y"><?=$APPLICATION->GetCurPage()?>?F=Y</a>
<p><?=GetMessage("CATALOG")?></p>
<ul>
	<?foreach ($arResult["ITEMS"] as $classificator):?>
	
		<li>
			<b><?=$classificator["NAME"];?></b>
			<ul>
				<?foreach ($classificator["PRODUCT"] as $product):
					$this->AddEditAction($product['ID'], $product['EDIT_LINK'], $strElementEdit);
					$this->AddEditAction($product['ID'], $product['EDIT_LINK'], $strElementEdit);
					$this->AddDeleteAction($product['ID'], $product['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
					$strMainID = $this->GetEditAreaId($product['ID']);
				?>
				
				<li id="<?=$strMainID?>">
					<?=$product["NAME"]?> - <?=$product["PRICE"]?> - <?=$product["MATERIAL"]?> - <?=$product["ARTNUMBER"]?> - <a href="<?=$product["DETAIL_PAGE_URL"]?>">(<?=$product["DETAIL_PAGE_URL"]?>)</a>
				</li>
				<?endforeach;?>
			</ul>
		</li>
	<?endforeach;?>
</ul>

<?=$arResult["NAV_STRING"]?>

<?$this->SetViewTarget('price');?>
   <div style="color:red; margin: 34px 15px 35px 15px">
		Минимальная цена: <?=$arResult["MIN_PRICE"]?>
		Максимальная цена: <?=$arResult["MAX_PRICE"]?>
   </div>
<?$this->EndViewTarget();?> 

