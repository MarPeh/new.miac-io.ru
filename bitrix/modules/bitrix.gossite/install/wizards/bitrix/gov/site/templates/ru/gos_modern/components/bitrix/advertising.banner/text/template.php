<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$frame = $this->createFrame()->begin("");
foreach ($arResult["BANNERS_PROPERTIES"] as $banner) {
    ?>
    <a href="<?echo $banner["REDIRECT_URL"]?>" class="col-margin white-box padding-box ta-center d-b">
        <img src="<?echo $banner["IMAGE_DATA"]["SRC"]?>" alt="<?echo $banner["IMAGE_ALT"]?>">
        <b class="d-b text-primary"><?echo $banner["NAME"]?></b>
    </a>
    <?
}
$frame->end();

