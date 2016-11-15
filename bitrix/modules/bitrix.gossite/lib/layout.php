<?php
namespace Bitrix\GosSite;

/**
 * Class Layout
 *
 * @package Bitrix\GosSite
 */
class Layout
{
    /**
     * @param $wrapperType
     *
     * @return string
     */
    public static function printWrapper($wrapperType)
    {
        if ($GLOBALS["APPLICATION"]->GetProperty("no_wrapper") === "Y") {
            return "";
        }

        switch ($wrapperType) {
            case "header":
                return "<div class=\"white-box padding-box\">";
                break;
            case "footer":
                return "</div>";
                break;
        }
    }

    /**
     * @return string
     */
    public static function printSidebar()
    {
        if ($GLOBALS["APPLICATION"]->GetProperty("no_sidebar") === "Y") {
            return "";
        }

        return $GLOBALS["APPLICATION"]->GetViewContent("sidebar");
    }
}