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

?>
<p><?=GetMessage("CATALOG")?></p>
<ul>
	<?foreach ($arResult as $classificator):?>
		<li>
			<b><?=$classificator["NAME"];?></b>
			<ul>
				<?foreach ($classificator["PRODUCT"] as $product):?>
				<li>
					<?=$product["NAME"]?> - <?=$product["PRICE"]?> - <?=$product["MATERIAL"]?> - <?=$product["ARTNUMBER"]?> - <a href="<?=$product["DETAIL_PAGE_URL"]?>">(<?=$product["DETAIL_PAGE_URL"]?>)</a>
				</li>
				<?endforeach;?>
			</ul>
		</li>
	<?endforeach;?>
</ul>