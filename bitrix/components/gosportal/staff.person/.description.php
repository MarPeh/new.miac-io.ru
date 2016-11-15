<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
$arComponentDescription = array(
    "NAME"        => GetMessage("INTR_MSP_COMPONENT_NAME"),
    "DESCRIPTION" => GetMessage("INTR_MSP_COMPONENT_DESCR"),
    "ICON"        => "/images/comp.gif",
    "CACHE_PATH"  => "Y",
    "PATH"        => array(
		"ID" => "gossite",
		"NAME" => GetMessage('T_MEDSITE_SECTION_NAME'),
        "CHILD" => array(
            "ID"   => "structure",
            "NAME" => GetMessage("INTR_STRUCTURE_GROUP_NAME"),
        )
    )
);
?>