<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if((int)$_REQUEST['addToSelected']>0)
{
	$munOrderSelected = $APPLICATION->get_cookie("munOrderSelected");
	$munOrderSelectedAr = explode(";",$munOrderSelected);
	$key=array_search((int)$_REQUEST['addToSelected'], $munOrderSelectedAr);
	$resArray=array();
	$count=count($munOrderSelectedAr)-1;
	if($key===false)
	{
		$munOrderSelectedAr[]=(int)$_REQUEST['addToSelected'];
		$resArray['type']="add";
		$count++;
	}
	else
	{
		unset($munOrderSelectedAr[$key]);
		$resArray['type']="del";
		$count--;
	}
	$resArray['ID']=(int)$_REQUEST['addToSelected'];
	$resArray['count']=$count;
	$munOrderSelected=implode(";",$munOrderSelectedAr);
	// устновим cookie на 3 месяца 
	$APPLICATION->set_cookie("munOrderSelected", $munOrderSelected, time()+60*60*24*30*2);
	if($_REQUEST['ajax']=="Y")
		echo json_encode($resArray);
}
elseif($_REQUEST['clear']=="all")
{
	$APPLICATION->set_cookie("munOrderSelected", false, time()+60*60*24*30*2);
	LocalRedirect(SITE_DIR."mun-order/selected/");
}
elseif($_REQUEST['clear']=="ok")
{
	ShowNote("Избранное очищено");
}