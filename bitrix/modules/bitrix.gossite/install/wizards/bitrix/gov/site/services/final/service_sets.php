<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

COption::SetOptionString("bitrix.gossite", "template_version", \Bitrix\Main\ModuleManager::getVersion('bitrix.gossite'), false, WIZARD_SITE_ID);