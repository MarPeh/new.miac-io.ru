<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (WIZARD_IS_RERUN)
	return;

if(!CModule::IncludeModule("iblock"))
	return;
?>