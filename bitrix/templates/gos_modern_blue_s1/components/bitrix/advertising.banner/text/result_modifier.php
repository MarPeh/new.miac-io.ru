<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult["BANNERS_PROPERTIES"] as &$banner) {
    $banner["IMAGE_DATA"] = CFile::GetFileArray($banner["IMAGE_ID"]);
    $banner["REDIRECT_URL"] = CAdvBanner::GetRedirectURL(CAdvBanner::PrepareHTML($banner["URL"], $banner), $banner);
}
?>