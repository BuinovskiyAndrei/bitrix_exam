<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["ITEMS"])):?>
<ul>
	<?foreach($arResult["ITEMS"] as $item):?>
	<li>
		<b><?=$item["NAME"]?></b><span> - <?=$item["ACTIVE_FROM"]?>
		(
			<?$counter = 1;
			foreach($item["SECTION"] as $section):
				if (count($item["SECTION"]) != $counter) {
					echo $section. ",";
				} else {
					echo $section;
				}
				
				$counter ++;
			endforeach;?>
		)
		</span>
		<ul>
			<?foreach($item["PRODUCT"] as $product):?>
				<li>
					<?=$product["NAME"]?> - <?=$product["PRICE"]?> - <?=$product["MATERIAL"]?> - <?=$product["ARTNUMBER"]?>
				</li>
			<?endforeach;?>
		</ul>
	</li>
	<?endforeach;?>
</ul>
<?endif;?>
