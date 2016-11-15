<?php
namespace Bitrix\GosSite;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Class Tools
 *
 * @package Bitrix\GosSite
 */
class Tools
{
    public static function getServicesCatsFilter($iblockId, $type)
    {
        if (Loader::includeModule("iblock")) {
            $filter = array();

            $resCatElCount = \CIBlockElement::GetList(
                array(),
                array("IBLOCK_ID" => $iblockId, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "PROPERTY_FOR" => $type),
                array("PROPERTY_CATEGORY1")
            );

            while ($arCatElCount = $resCatElCount->GetNext()) {
                if ($arCatElCount['CNT'] > 0) {
                    $filter[] = $arCatElCount['PROPERTY_CATEGORY1_VALUE'];
                }
            }
            if (count($filter) > 0) {
                return array("ID" => $filter);
            }
        }

        return array();
    }

    public static function readableFileSize($size, $precision = 1, $decimal = false)
    {
        return $size ? round($size / pow(1024, ($i = floor(log($size, $decimal ? 1000 : 1024)))), $precision) . ' ' . Loc::getMessage("SIZE_" . $i) : "0 " . Loc::getMessage("SIZE_0");
    }

    public static function pluralForm($number, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);

        return $number . " " . $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}