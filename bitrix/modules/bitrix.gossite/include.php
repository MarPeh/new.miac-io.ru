<?
CModule::AddAutoloadClasses(
	"bitrix.gossite",
	array(
		"Bitrix\\GosSite\\Layout" => "lib/layout.php",
		"Bitrix\\GosSite\\Tools" => "lib/tools.php",
	)
);

require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/start.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/bitrix.gossite/lang/ru/include.php');
if (!class_exists('CGossiteMail')) {
	require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bitrix.gossite/tools/SendMailAttachments.php');
}

if (!class_exists('Mobile_Detect')) {
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bitrix.gossite/tools/Mobile_Detect.php'))
		require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/bitrix.gossite/tools/Mobile_Detect.php');
}

global $MESS;
if (!class_exists('GossiteTools')) {
	class GossiteTools{
		static function GeneratePassword($length)
		{
			$symbolBase = array('a', 'b', 'c', 'd', 'e', 'f',
			                    'g', 'h', 'i', 'j', 'k', 'l',
			                    'm', 'n', 'o', 'p', 'r', 's',
			                    't', 'u', 'v', 'x', 'y', 'z',
			                    'A', 'B', 'C', 'D', 'E', 'F',
			                    'G', 'H', 'I', 'J', 'K', 'L',
			                    'M', 'N', 'O', 'P', 'R', 'S',
			                    'T', 'U', 'V', 'X', 'Y', 'Z',
			                    '1', '2', '3', '4', '5', '6',
			                    '7', '8', '9', '0');
			$password = '';
			$symbolBaseLength = count($symbolBase);
			for ($i = 0; $i < $length; $i++) {
				$symbolIndex = rand(0, $symbolBaseLength - 1);
				$password .= $symbolBase[$symbolIndex];
			}
			return $password;
		}
	}
}

if (!class_exists('GossiteEvents')) {
	class GossiteEvents{
		function gossiteOnEndBufferContent(&$content)
		{
			$alreadyInstalled=COption::GetOptionString('bitrix.gossite', "mobile_installed", "", SITE_ID);
			if($alreadyInstalled=="Y")
			{
				$content = preg_replace('#<meta id="bx_mobile_viewport" name="viewport" content="(.+)">#U', '<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no">', $content);
			}
		}

		function OnCreatePanel()
		{
			if($GLOBALS["USER"]->IsAdmin() && COption::GetOptionString("main", "wizard_solution", "", SITE_ID) == "gossite"
                && is_dir($_SERVER['DOCUMENT_ROOT'].'/bitrix/wizards/bitrix/gov'))
			{
				$GLOBALS['APPLICATION']->AddPanelButton(array(
					'HREF'=>"/bitrix/admin/wizard_install.php?lang=ru&wizardName=bitrix:gov&wizardSiteID=".SITE_ID."&".bitrix_sessid_get(),
					'ID'=>'gosportal',
					'ICON' => 'bx-panel-site-wizard-icon',
					'ALT'=>GetMessage('GOSSITE_BUTTON_COMMON_TITLE'),
					'TEXT'=>GetMessage('GOSSITE_BUTTON_COMMON_TEXT'),
					'MAIN_SORT'=>'1025',
					'SORT'=>20,
					'TYPE' => 'BIG'));
			}
			global $APPLICATION;
			$page = $APPLICATION->GetCurPage();
			$checkType='';
			if (isset($_COOKIE['siteType'])) $checkType=$_COOKIE['siteType'];
			$detect = new Mobile_Detect();
			if ($checkType!=='original'&&$checkType!=='special'){
				if ($detect->isMobile() && ($detect->isTablet() && !$detect->isiOS()))
					$checkType='pda';
			}
			if ($page==SITE_DIR || $page==SITE_DIR."index.php"){
				if (COption::GetOptionString('bitrix.gossite', 'installed',"N", SITE_ID)==='Y'){
					if ($checkType=='pda'){
						//					LocalRedirect("/index_mobile.php");
					}
					elseif ($checkType=='special')
						LocalRedirect(SITE_DIR."index_contrast.php");
				}
			}
			elseif ($page==SITE_DIR."index_contrast.php"){
				if ($checkType=='pda'){
					//				LocalRedirect("/index_mobile.php");
				}
				elseif ($checkType=='original')
					LocalRedirect(SITE_DIR."index.php");
			}
			elseif ($page==SITE_DIR."index_mobile.php"){
				if ($checkType=='special')
					LocalRedirect(SITE_DIR."index_contrast.php");
				elseif ($checkType=='original')
					LocalRedirect(SITE_DIR."index.php");
			}
		}
		function OnProlog()
		{
			if($GLOBALS['USER']->IsAdmin())
			{
				unset($GLOBALS['APPLICATION']->arPanelButtons['portal_wizard']);
			}
		}
		function DetectMobile(){
			global $APPLICATION;
			$checkType='';
			if (isset ($_GET['type'])){
				if ($_GET['type']=='pda' || $_GET['type']=='special' || $_GET['type']=='original')
					$checkType = $_GET['type'];
			}
			else{
				if (isset($_COOKIE['siteType']))
					$checkType=$_COOKIE['siteType'];
			}

			$page = $APPLICATION->GetCurPage();

			$detect = new Mobile_Detect();
			if ($checkType!=='original'&&$checkType!=='special'){
				if ($detect->isMobile() && !$detect->isTablet())
					$checkType='pda';
			}
			setcookie('siteType', $checkType, time()+3600*24*30,'/');
			define('siteType',$checkType);
			if ($page==SITE_DIR || $page==SITE_DIR."index.php"){
				if (COption::GetOptionString('bitrix.gossite', 'installed',"N", SITE_ID)==='Y'){
					if ($checkType=='pda'){
						//					LocalRedirect("/index_mobile.php");
					}
					elseif ($checkType=='special')
						LocalRedirect(SITE_DIR."index_contrast.php");
				}
			}
			elseif ($page==SITE_DIR."index_contrast.php"){
				if ($checkType=='pda'){
					//				LocalRedirect("/index_mobile.php");
				}
				elseif ($checkType=='original')
					LocalRedirect(SITE_DIR."index.php");
			}
			elseif ($page==SITE_DIR."index_mobile.php"){
				if ($checkType=='special')
					LocalRedirect(SITE_DIR."index_contrast.php");
				elseif ($checkType=='original')
					LocalRedirect(SITE_DIR."index.php");
			}
		}

		function gossiteOnAfterResultAdd($WEB_FORM_ID, $RESULT_ID)
		{
			global $USER;
			$gossiteFORM_ID = COption::GetOptionString('bitrix.gossite', "internet_reception_form_id", "", SITE_ID);
			$gossiteFORM_EMAIL = COption::GetOptionString('bitrix.gossite', "internet_reception_form_email", "", SITE_ID);
			$gossiteSUPPORT_STATUSE = COption::GetOptionString('bitrix.gossite', "internet_reception_support_statuse", "", SITE_ID);

			$gossiteFORM_REQ_ID = COption::GetOptionString('bitrix.gossite', "request_information_form_id", "", SITE_ID);
			$gossiteFORM_REQ_EMAIL = COption::GetOptionString('bitrix.gossite', "request_information_form_email", "", SITE_ID);
			$gossiteREQ_SUPPORT_STATUSE = COption::GetOptionString('bitrix.gossite', "request_information_support_statuse", "", SITE_ID);


			if (($WEB_FORM_ID == $gossiteFORM_ID)||($WEB_FORM_ID == $gossiteFORM_REQ_ID))
			{
				CForm::GetResultAnswerArray(
					$WEB_FORM_ID,
					$arrColumns,
					$arrAnswers,
					$arrAnswersVarname,
					array("RESULT_ID" => $RESULT_ID
					)
				);
				CFormResult::GetDataByID(
					$RESULT_ID,
					array('STATUS_ID'),
					$a1,
					$a2
				);
				if ($WEB_FORM_ID == $gossiteFORM_ID) {
					$mailField = array_shift($arrAnswers[$RESULT_ID][$gossiteFORM_EMAIL]);
				}
				else {
					$mailField=array_shift($arrAnswers[$RESULT_ID][$gossiteFORM_REQ_EMAIL]);
				}
				$email = $mailField['USER_TEXT'];

				if($email)
				{
					$user_info=array();
					if ($USER->IsAuthorized())
					{
						$user_id = $USER->GetID();
						$user_info = $USER->GetByID($user_id);
						$user_info = $user_info->Fetch();
					}
					else
					{
						$filter = array("ACTIVE"=>"Y","EMAIL"=>$email);
						$dbUser = $USER->GetList(($by="id"), ($order="desc"), $filter);
						if ($arUser = $dbUser->Fetch())
						{
							$user_id = $arUser['ID'];
							$user_info = $arUser;
						}
					}
					$arEventFields = array("DATETIME" => ConvertTimeStamp(time(), "FULL", "ru"));
					$arSupFields=array();
					$arFixedFieldsEvent=array("NAME", "TEXT", "TYPE", "ADDRESS", "PHONE", "EMAIL");
					$arFixedFieldsSup=array("EMAIL", "TYPE", "TITLE");
					foreach($arrAnswersVarname[$RESULT_ID] as $fieldCode=>$arAnswers)
					{
						foreach($arAnswers as $answer)
						{
							if(!in_array($fieldCode, $arFixedFieldsEvent))
							{
								$arEventFields["TEXT"].=$answer['TITLE'].": ";
								if($answer['FIELD_TYPE']=="file")
								{
									$arFile = CFile::GetFileArray($answer['USER_FILE_ID']);
									$arEventFields["TEXT"].='http://'.str_replace(' ','%20',$_SERVER['SERVER_NAME'].$arFile["SRC"]);
								}
								else
								{
									if($answer['ANSWER_TEXT'] && !$answer['USER_TEXT'])
										$arEventFields["TEXT"].=$answer['ANSWER_TEXT'];
									else
										$arEventFields["TEXT"].=$answer['USER_TEXT'];
								}
								$arEventFields["TEXT"].="\r\n\r\n";
							}
							else
							{
								if($answer['ANSWER_TEXT'] && !$answer['USER_TEXT'])
									$arEventFields[$fieldCode].=$answer['ANSWER_TEXT'];
								else
									$arEventFields[$fieldCode].=$answer['USER_TEXT'];
							}

							if(!in_array($fieldCode, $arFixedFieldsSup))
							{
								$arSupFields["MESSAGE"].=$answer['TITLE'].": ";
								if($answer['FIELD_TYPE']=="file")
								{
									$arFile = CFile::GetFileArray($answer['USER_FILE_ID']);
									$arSupFields["MESSAGE"].='http://'.str_replace(' ','%20',$_SERVER['SERVER_NAME'].$arFile["SRC"]);
								}
								else
								{
									if($answer['ANSWER_TEXT'] && !$answer['USER_TEXT'])
										$arSupFields["MESSAGE"].=$answer['ANSWER_TEXT'];
									else
										$arSupFields["MESSAGE"].=$answer['USER_TEXT'];
								}
								$arSupFields["MESSAGE"].="\r\n\r\n";
							}
							else
							{
								if($answer['ANSWER_TEXT'] && !$answer['USER_TEXT'])
									$arSupFields[$fieldCode].=$answer['ANSWER_TEXT'];
								else
									$arSupFields[$fieldCode].=$answer['USER_TEXT'];
							}

						}
					}
					if(CModule::IncludeModule("support"))
					{
						if ($WEB_FORM_ID == $gossiteFORM_ID) {
							$msg_title = GetMessage('appeal_to').$arSupFields['TITLE'];
							$STATUS_ID = $gossiteSUPPORT_STATUSE;
							$CATEGORY_SID = "appeal";
						}
						else {
							$msg_title = GetMessage('request_to').$arSupFields['TITLE'];
							$STATUS_ID = $gossiteREQ_SUPPORT_STATUSE;
							$CATEGORY_SID = "request";
						}
						$arFields = array(
							"OWNER_USER_ID" => $user_id,
							"OWNER_SID"  => $email,
							"SOURCE_SID"  => "email",
							"MESSAGE_AUTHOR_SID"  => $email,
							"MESSAGE_SOURCE_SID"  => "email",
							"TITLE"  => $msg_title,
							"MESSAGE" => $arSupFields['MESSAGE'],
							"STATUS_ID" => $STATUS_ID,
							"CATEGORY_SID" => $CATEGORY_SID,
							"UF_FORM_RESULT" => $RESULT_ID
						);
						$TICKET_ID="";
						$RESPONSIBLE_USER_ID = COption::GetOptionString('support','DEFAULT_RESPONSIBLE_ID',0);
						if (intval($RESPONSIBLE_USER_ID)!=0) {
							$arFields['RESPONSIBLE_USER_ID'] = $RESPONSIBLE_USER_ID;
						}
						$NEW_TICKET_ID = CTicket::Set($arFields, $MESSAGE_ID, $TICKET_ID, "N");
						if ($NEW_TICKET_ID)
						{
							$arEventFields["ID"] = $NEW_TICKET_ID;
							CEvent::Send("TICKET_NEW_FOR_EXCHANGE", SITE_ID, $arEventFields);
						}
					}
				}
			}
		}

		// Обработчики события вызываются перед добавлением нового результата веб-формы.
		// Может быть использовано для каких-либо дополнительных проверок или изменения значения полей результата веб-формы.
		// Возврат обработчиком каких-либо значений не предполагается.
		// Ошибки нужно возвращать посредством $APPLICATION->ThrowException().

		// WEB_FORM_ID - ID веб-формы.
		// arFields - Массив полей результата для записи в БД.
		// arrVALUES - Массив значений ответов результата веб-формы.

		function gossiteOnBeforeResultAdd($WEB_FORM_ID, $arFields, $arrVALUES)
		{
			global $APPLICATION;
			global $USER;
			$gossiteFORM_ID = COption::GetOptionString('bitrix.gossite', "internet_reception_form_id", "", SITE_ID);
			$gossiteFORM_EMAIL = COption::GetOptionString('bitrix.gossite', "internet_reception_form_email", "", SITE_ID);
			$gossiteFORM_USER_REGISTER = COption::GetOptionString('bitrix.gossite', "internet_reception_register_user", "", SITE_ID);

			$gossiteFORM_REQ_ID = COption::GetOptionString('bitrix.gossite', "request_information_form_id", "", SITE_ID);
			$gossiteFORM_REQ_EMAIL = COption::GetOptionString('bitrix.gossite', "request_information_form_email", "", SITE_ID);
			$gossiteFORM_REQ_USER_REGISTER = COption::GetOptionString('bitrix.gossite', "internet_reception_register_user", "", SITE_ID);


			if (($WEB_FORM_ID == $gossiteFORM_ID  && $gossiteFORM_EMAIL)||($WEB_FORM_ID == $gossiteFORM_REQ_ID  && $gossiteFORM_REQ_EMAIL))
			{
				if (!$USER->IsAuthorized()) {
					$register=false;
					$email='';
					if ($gossiteFORM_USER_REGISTER=="Y" && $WEB_FORM_ID == $gossiteFORM_ID) {
						$register=true;
						$email=$arrVALUES['form_email_'.$gossiteFORM_EMAIL];
					} elseif ($gossiteFORM_REQ_USER_REGISTER=="Y" && $WEB_FORM_ID == $gossiteFORM_REQ_ID) {
						$register=true;
						$email=$arrVALUES['form_email_'.$gossiteFORM_REQ_EMAIL];
					}
					if ($register) {
						$filter = array("ACTIVE"=>"Y","EMAIL"=>$email);
						$dbUser = $USER->GetList(($by="id"), ($order="desc"), $filter);
						if(empty($email))
							$APPLICATION->ThrowException(GetMessage('EMAIL_EMPTY_ERROR'));

						if ($arUser = $dbUser->Fetch())
							$APPLICATION->ThrowException(GetMessage('EMAIL_EXIST_ERROR'));

						$password = GossiteTools::GeneratePassword(8); //генерация пароля

						//поле Имя
						$rsField = CFormField::GetBySID('NAME');
						$arField = $rsField->Fetch();
						$fio = 'form_'.$arField['TITLE_TYPE'].'_'.$arField['ID'];

						if (COption::GetOptionString("main", "captcha_registration", "N") == "Y") {
							if (array_key_exists('captcha_sid',$_POST)) {
								// It was already checked in web form component.
								// Registration doesn't work without this because captcha was deleted on previous check.
								$arFields = array(
									'ID' => $_POST['captcha_sid'],
									'CODE' => strtoupper($_POST['captcha_word']),
								);
								CCaptcha::Add($arFields);
							}
							$can_send = $USER->Register($email, "",  $arrVALUES[$fio], $password, $password, $email,false,$_POST['captcha_word'],$_POST['captcha_sid']);
						}
						else {
							$can_send = $USER->Register($email, "",  $arrVALUES[$fio], $password, $password, $email);
						}

						if ($can_send)
						{
							CUser::SendUserInfo($USER->GetID(), SITE_ID, "");
							$USER->Logout();
						}
						else
						{
							$APPLICATION->ThrowException(GetMessage('USER_REGISTER_ERROR'));
						}
					}
				}
			}
		}

		function gossiteGetObjectMapCoords (&$arFields) {
			/** @todo: Need optimization*/
			if (array_key_exists('IBLOCK_ID',$arFields)) {
				$rsIB = CIBlock::GetByID($arFields['IBLOCK_ID']);
				$arIB = $rsIB->GetNext();
				$SITE_ID = $arIB['LID'];
			} else {
				$SITE_ID = SITE_ID;
			}
			$current_objects_ib = array(
				COption::GetOptionString('bitrix.gossite', "objects_ib", 0, $SITE_ID),
				COption::GetOptionString('bitrix.gossite', "routes_ib", 0, $SITE_ID),
				COption::GetOptionString('bitrix.gossite', "events_ib", 0, $SITE_ID),
			);

			if (in_array($arFields['IBLOCK_ID'],$current_objects_ib)) {
				if ($arFields['IBLOCK_ID']==$current_objects_ib[0]) {
					$ADDRESS = COption::GetOptionString('bitrix.gossite', "objects_address", 0, $SITE_ID);
					$LAT = COption::GetOptionString('bitrix.gossite', "objects_lat", 0, $SITE_ID);
					$LNG = COption::GetOptionString('bitrix.gossite', "objects_lng", 0, $SITE_ID);
				} elseif ($arFields['IBLOCK_ID']==$current_objects_ib[1]) {
					$ADDRESS = COption::GetOptionString('bitrix.gossite', "routes_address", 0, $SITE_ID);
					$LAT = COption::GetOptionString('bitrix.gossite', "routes_lat", 0, $SITE_ID);
					$LNG = COption::GetOptionString('bitrix.gossite', "routes_lng", 0, $SITE_ID);
				}
				else {
					$ADDRESS = COption::GetOptionString('bitrix.gossite', "events_address", 0, $SITE_ID);
					$LAT = COption::GetOptionString('bitrix.gossite', "events_lat", 0, $SITE_ID);
					$LNG = COption::GetOptionString('bitrix.gossite', "events_lng", 0, $SITE_ID);
				}

				if ($LAT==0 || $LNG==0 || $ADDRESS==0)
					return;

				$rsSites = CSite::GetByID('s1');
				$arSite = $rsSites->Fetch();
				$charset = $arSite['CHARSET'];

				$address =	current($arFields['PROPERTY_VALUES'][$ADDRESS]);
				$address = $address['VALUE'];
				if (!empty($address)) {
					if(ToLower($charset)=="windows-1251")
					{
						$address=iconv('windows-1251', 'UTF-8', $address);
					}
					$geocode = simplexml_load_file('http://maps.googleapis.com/maps/api/geocode/xml?address='.urlencode($address).'&sensor=false');
					$lat=$geocode->result->geometry->location->lat;
					$lon=$geocode->result->geometry->location->lng;
					if(ToLower($charset)=="windows-1251")
					{
						$lat=iconv('UTF-8', 'windows-1251', $lat);
						$lon=iconv('UTF-8', 'windows-1251', $lon);
					}
					$arFields['PROPERTY_VALUES'][$LAT] = array(array('VALUE'=>$lat));
					$arFields['PROPERTY_VALUES'][$LNG] = array(array('VALUE'=>$lon));
				}
			}
		}
	}

	class CGovernment {
		static $Regions = false;
		static $RegionCapitals = false;

		function InitNames() {
			if (CGovernment::$Regions == false){
				CGovernment::$Regions = array();
				$arRegionsID = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,53,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,79,82,83,86,87,89);
				foreach($arRegionsID as $regionID){
					CGovernment::$Regions[$regionID] = GetMessage('gossite_region_'.$regionID);
				}
			}

			if (CGovernment::$RegionCapitals == false){
				CGovernment::$RegionCapitals = array();
				$arCapitalsID = array(77,78,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,53,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,51,52,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,79,82,83,86,87,89);
				foreach($arCapitalsID as $capitalID){
					CGovernment::$RegionCapitals[$capitalID] = GetMessage('gossite_city_'.$capitalID);
				}
			}
		}

		function RegionExists($region) {
			return isset(self::$Regions[$region]);
		}
		function GetRegions () {
			return self::$Regions;
		}
		function GetRegionCapitals () {
			return self::$RegionCapitals;
		}

		function GetRegionName($region) {
			return self::$Regions[$region];
		}

		function ScanCoats($dirName, $siteId) {
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $dirName)) return;
			$coatDir = dir($_SERVER['DOCUMENT_ROOT'] . $dirName);
			while (false !== ($entry = $coatDir->read())) {
				if (substr($entry, -4) == '.png') {
					?>
					<div style="height:108px;width:88px;float:left;padding:4px;text-align:center;">
						<a href="#" onclick="return setCoat('<?echo $dirName; ?><?echo $entry; ?>','<?=$siteId?>');"><img src="<?echo $dirName; ?><?echo $entry; ?>"<?if ($nameArray !== null){?>  width="48" height="56"<?}?> style="border:0;" /></a><br/>
						<small><? echo $entry; ?></small>
						<?
						?>
					</div>
					<?
				}
			}
			$coatDir->close();
		}

		function showCoats($dirName, $nameArray = null, $siteID) {
			if ($nameArray  == 'city') {
				$nameArray = CGovernment::$RegionCapitals;
				asort($nameArray);
			}
			elseif ($nameArray  == 'region') {
				$nameArray = CGovernment::$Regions;
				asort($nameArray);
			}

			foreach ($nameArray as $code => $name) {
				if (file_exists($_SERVER['DOCUMENT_ROOT'] . $dirName . $code . '.png')) {
					?>
					<div style="height:108px;width:88px;float:left;padding:4px;text-align:center;">
						<a href="#" onclick="return setCoat('<?echo $dirName; ?><?echo $code; ?>.png','<?=$siteID?>');"><img src="<?echo $dirName; ?><?echo $code; ?>.png" width="48" height="56" style="border:0;" /></a><br/>
						<small><? echo $name; ?></small>
					</div>
					<?
				}
			}
		}

		function InitImage($imageID, $imageWidth, $imageHeight = 0, $type = BX_RESIZE_IMAGE_PROPORTIONAL)
		{
			$imageFile = false;
			$imageImg = "";

			if(($imageWidth = intval($imageWidth)) <= 0) $imageWidth = 100;
			if(($imageHeight = intval($imageHeight)) <= 0) $imageHeight = $imageWidth;

			$imageID = intval($imageID);

			if($imageID > 0)
			{
				$imageFile = CFile::GetFileArray($imageID);
				if ($imageFile !== false)
				{
					$arFileTmp = CFile::ResizeImageGet(
						$imageFile,
						array("width" => $imageWidth, "height" => $imageHeight),
						$type,
						false
					);
					$imageImg = CFile::ShowImage($arFileTmp["src"], $imageWidth, $imageHeight, "border=0", "");
				}
			}

			return array("FILE" => $imageFile, "CACHE" => $arFileTmp, "IMG" => $imageImg);
		}

		public static function PhpToJSObject($arData, $bWS = false, $bSkipTilda = false)
		{
			static $aSearch = array("\r", "\n");

			if(is_array($arData))
			{
				$i = -1;
				$j = -1;
				if (!empty($arData))
				{
					foreach($arData as $j => $temp)
					{
						$i++;
						if ($j !== $i)
							break;
					}
				}

				if($j === $i)
				{
					foreach($arData as $key => $value)
					{
						if(is_numeric($value))
						{

							$arData[$key] = $value;
						}
						elseif(is_string($value))
						{
							if(preg_match("#['\"\\n\\r<\\\\\x80]#", $value))
								$arData[$key] = "'".CUtil::JSEscape($value)."'";
							else
								$arData[$key] = "'".$value."'";
						}
						elseif(is_bool($value))
						{
							if($value === true)
								$arData[$key] = 'true';
							else
								$arData[$key] = 'false';
						}
						elseif(is_array($value))
						{
							$arData[$key] = CGovernment::PhpToJSObject($value, $bWS, $bSkipTilda);
						}
						else
						{
							if(preg_match("#['\"\\n\\r<\\\\\x80]#", $value))
								$arData[$key] = "'".CUtil::JSEscape($value)."'";
							else
								$arData[$key] = "'".$value."'";
						}
					}
					return '['.implode(',', $arData).']';
				}

				$sWS = ','.($bWS ? "\n" : '');
				$res = ($bWS ? "\n" : '').'{';
				$first = true;
				foreach($arData as $key => $value)
				{
					if ($bSkipTilda && substr($key, 0, 1) == '~')
						continue;

					if($first)
						$first = false;
					else
						$res .= $sWS;

					if(preg_match("#['\"\\n\\r<\\\\\x80]#", $key))
						$res .= "'".str_replace($aSearch, '', CUtil::JSEscape($key))."':";
					else
						$res .= "'".$key."':";

					if(is_numeric($value))
					{

						$res .= $value;
					}
					elseif(is_string($value))
					{
						if(preg_match("#['\"\\n\\r<\\\\\x80]#", $value))
							$res .= "'".CUtil::JSEscape($value)."'";
						else
							$res .= "'".$value."'";
					}
					elseif(is_bool($value))
					{
						if($value === true)
							$res .= 'true';
						else
							$res .= 'false';
					}
					elseif(is_array($value))
					{
						$res .= CGovernment::PhpToJSObject($value, $bWS, $bSkipTilda);
					}
					else
					{
						if(preg_match("#['\"\\n\\r<\\\\\x80]#", $value))
							$res .= "'".CUtil::JSEscape($value)."'";
						else
							$res .= "'".$value."'";
					}
				}
				$res .= ($bWS ? "\n" : '').'}';

				return $res;
			}
			elseif(is_bool($arData))
			{
				if($arData === true)
					return 'true';
				else
					return 'false';
			}
			else
			{
				if(preg_match("#['\"\\n\\r<\\\\\x80]#", $arData))
					return "'".CUtil::JSEscape($arData)."'";
				else
					return "'".$arData."'";
			}
		}
	}
}
?>