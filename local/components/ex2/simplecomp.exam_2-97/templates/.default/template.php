<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["USERS"])):?>
<ul>
	<?foreach($arResult["USERS"] as $users):?>
	<li>
		<span><b>[<?=$users["ID"]?>] - <?=$users["LOGIN"]?></b></span>
		<ul>
			<?foreach($arResult["ELEMENTS"][$users["ID"]] as $news):?>
				<li>
					<?=$news["NAME"]?> - <?=$news["ACTIVE_FROM"]?>
				</li>
			<?endforeach;?>
		</ul>
	</li>
	<?endforeach;?>
</ul>
<?endif;?>
