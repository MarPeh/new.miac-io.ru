<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();
if (is_array($arResult['DEPARTMENTS'])) {
	foreach ($arResult['DEPARTMENTS'] as $dkey=>$arDept) {
		foreach ($arDept['USERS'] as $key=>$arUser) {
			if(isset($arUser['PERSONAL_PHOTO']))
			{
				$arFilter = '';
				$arFileTmp = CFile::ResizeImageGet(
					$arUser['PERSONAL_PHOTO'],
					array("width" => 160, "height" => 200),
					BX_RESIZE_IMAGE_PROPORTIONAL,
					true, $arFilter
				);
				$arResult['DEPARTMENTS'][$dkey]['USERS'][$key]['PERSONAL_PHOTO'] = array();
				$arResult['DEPARTMENTS'][$dkey]['USERS'][$key]['PERSONAL_PHOTO']['WIDTH']=$arFileTmp["width"];
				$arResult['DEPARTMENTS'][$dkey]['USERS'][$key]['PERSONAL_PHOTO']['HEIGHT']=$arFileTmp["height"];
				$arResult['DEPARTMENTS'][$dkey]['USERS'][$key]['PERSONAL_PHOTO']['SRC']=$arFileTmp["src"];
			}
		}
	}
}

?>
