<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("form"))
	return;
//if (WIZARD_INSTALL_DEMO_DATA === false)
//	return;
//if (WIZARD_IS_RERUN)
//	return;

$arrForms=array(
		Array(
			'NAME' => GetMessage('internet_reception_NAME'),
			'SID' => 'internet_reception_'.WIZARD_SITE_ID,
			'BUTTON' => GetMessage('internet_reception_BUTTON'),
			'C_SORT' => '100',
			'IMAGE_ID' => '',
			'USE_CAPTCHA' => 'N',
			'DESCRIPTION' => '',
			'DESCRIPTION_TYPE' => 'text',
			'FORM_TEMPLATE' => '',
			'USE_DEFAULT_TEMPLATE' => 'Y',
			'SHOW_TEMPLATE' => '',
			'MAIL_EVENT_TYPE' => 'FORM_FILLING_internet_reception',
			'SHOW_RESULT_TEMPLATE' => '',
			'PRINT_RESULT_TEMPLATE' => '',
			'EDIT_RESULT_TEMPLATE' => '',
			'FILTER_RESULT_TEMPLATE' => '',
			'TABLE_RESULT_TEMPLATE' => '',
			'USE_RESTRICTIONS' => 'N',
			'RESTRICT_USER' => '0',
			'RESTRICT_TIME' => '0',
			'STAT_EVENT1' => 'form',
			'STAT_EVENT2' => '',
			'STAT_EVENT3' => '',
			'VARNAME' => 'internet_reception',
			'arMENU' => array(
					'en' => 'Write a letter',
					'ru' => GetMessage('internet_reception_arMENU_ru'),
					),
			'arRESTRICT_STATUS_TMP' => array(
					),
			'arrMAIL_EVENT_TYPE' => array(
					'ru' => array(
							'LID' => 'ru',
							'EVENT_NAME' => 'FORM_FILLING_internet_reception',
							'NAME' => GetMessage('internet_reception_arrMAIL_EVENT_TYPE_ru_NAME'),
							'DESCRIPTION' => GetMessage('internet_reception_arrMAIL_EVENT_TYPE_ru_DESCRIPTION'),
							'SORT' => '150',
							),
					'en' => array(
							'LID' => 'en',
							'EVENT_NAME' => 'FORM_FILLING_internet_reception',
							'NAME' => 'Web form filled "internet_reception"',
							'DESCRIPTION' => GetMessage('internet_reception_arrMAIL_EVENT_TYPE_en_DESCRIPTION'),
							'SORT' => '150',
							),
					),
			'MAIL_TEMPLATES_TEMP' => array(
					),
			'questions' => array(
					'0' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('internet_reception_questions_0_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'FILE',
							'C_SORT' => '900',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'N',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'FILE',
							'validators' => array(
									'0' => array(
											'ACTIVE' => 'Y',
											'C_SORT' => '100',
											'PARAMS' => array(
													'0' => array(
															'NAME' => 'EXT',
															'VALUE' => 'doc,rtf,pdf,txt',
															),
													'1' => array(
															'NAME' => 'EXT_CUSTOM',
															'VALUE' => 'jpg,png,gif,bmp',
															),
													),
											'NAME' => 'file_type',
											),
									),
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'file',
											'FIELD_WIDTH' => '0',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'1' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('internet_reception_questions_1_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'TEXT',
							'C_SORT' => '800',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'TEXT',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'textarea',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '3',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'2' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('internet_reception_questions_2_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'TITLE',
							'C_SORT' => '200',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'TITLE',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'text',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'3' => array(
							'ACTIVE' => 'Y',
							'TITLE' => 'E-Mail',
							'TITLE_TYPE' => 'text',
							'SID' => 'EMAIL',
							'C_SORT' => '700',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => GetMessage('EMAIL_COMMENT'),
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'EMAIL',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'email',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'4' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('internet_reception_questions_5_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'ADDRESS',
							'C_SORT' => '500',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'ADDRESS',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'textarea',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '3',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'5' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('internet_reception_questions_7_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'NAME',
							'C_SORT' => '300',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'NAME',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'text',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
			),
			'arGROUP_TMP'=>array(
				2=>20
			),
			'statuses' => array(
				'0' => array(
					'CSS' => 'statusgreen',
					'C_SORT' => '100',
					'ACTIVE' => 'Y',
					'TITLE' => "DEFAULT",
					'DESCRIPTION' => "DEFAULT",
					'DEFAULT_VALUE' => 'Y',
					'HANDLER_OUT' => '',
					'HANDLER_IN' => '',
					'MAIL_TEMPLATE_TMP' => array(
							),
					'tmp_id' => 'tmp_1',
					'MAIL_EVENT_TYPES' => array(
					),
					'arPERMISSION_VIEW_TMP' => array(
						'0' => '0',
					),
					'arPERMISSION_MOVE_TMP' => array(
						'0' => '2',
					),
					'arPERMISSION_EDIT_TMP' => array(
						'0' => '0',
					),
					'arPERMISSION_DELETE_TMP' => array(
						'0' => '0',
					),
				),
				'1' => array(
					'CSS' => 'statusgreen',
					'C_SORT' => '200',
					'ACTIVE' => 'Y',
					'TITLE' => "DRAFT",
					'DESCRIPTION' => "",
					'DEFAULT_VALUE' => 'N',
					'HANDLER_OUT' => '',
					'HANDLER_IN' => '',
					'MAIL_TEMPLATE_TMP' => array(
					),
					'tmp_id' => 'tmp_1',
					'MAIL_EVENT_TYPES' => array(
					),
					'arPERMISSION_VIEW_TMP' => array(
						'0' => '0',
					),
					'arPERMISSION_MOVE_TMP' => array(
						'0' => '2',
					),
					'arPERMISSION_EDIT_TMP' => array(
						'0' => '0',
					),
					'arPERMISSION_DELETE_TMP' => array(
						'0' => '0',
					),
				),
			),
		),
		
				
		Array(
			'NAME' => GetMessage('request_information_NAME'),
			'SID' => 'request_information_'.WIZARD_SITE_ID,
			'BUTTON' => GetMessage('request_information_BUTTON'),
			'C_SORT' => '100',
			'IMAGE_ID' => '',
			'USE_CAPTCHA' => 'N',
			'DESCRIPTION' => '',
			'DESCRIPTION_TYPE' => 'text',
			'FORM_TEMPLATE' => '',
			'USE_DEFAULT_TEMPLATE' => 'Y',
			'SHOW_TEMPLATE' => '',
			'MAIL_EVENT_TYPE' => 'FORM_FILLING_request_information',
			'SHOW_RESULT_TEMPLATE' => '',
			'PRINT_RESULT_TEMPLATE' => '',
			'EDIT_RESULT_TEMPLATE' => '',
			'FILTER_RESULT_TEMPLATE' => '',
			'TABLE_RESULT_TEMPLATE' => '',
			'USE_RESTRICTIONS' => 'N',
			'RESTRICT_USER' => '0',
			'RESTRICT_TIME' => '0',
			'STAT_EVENT1' => 'form',
			'STAT_EVENT2' => '',
			'STAT_EVENT3' => '',
			'VARNAME' => 'internet_reception',
			'arMENU' => array(
					'en' => 'Write a letter',
					'ru' => GetMessage('request_information_arMENU_ru'),
					),
			'arRESTRICT_STATUS_TMP' => array(
					),
			'arrMAIL_EVENT_TYPE' => array(
					'ru' => array(
							'LID' => 'ru',
							'EVENT_NAME' => 'FORM_FILLING_request_information',
							'NAME' => GetMessage('request_information_arrMAIL_EVENT_TYPE_ru_NAME'),
							'DESCRIPTION' => GetMessage('request_information_arrMAIL_EVENT_TYPE_ru_DESCRIPTION'),
							'SORT' => '150',
							),
					'en' => array(
							'LID' => 'en',
							'EVENT_NAME' => 'FORM_FILLING_request_information',
							'NAME' => 'Web form filled "request_information"',
							'DESCRIPTION' => GetMessage('request_information_arrMAIL_EVENT_TYPE_en_DESCRIPTION'),
							'SORT' => '150',
							),
					),
			'MAIL_TEMPLATES_TEMP' => array(
					),
			'questions' => array(
					'0' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('request_information_questions_0_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'FILE',
							'C_SORT' => '900',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'N',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'FILE',
							'validators' => array(
									'0' => array(
											'ACTIVE' => 'Y',
											'C_SORT' => '100',
											'PARAMS' => array(
													'0' => array(
															'NAME' => 'EXT',
															'VALUE' => 'doc,rtf,pdf,txt',
															),
													'1' => array(
															'NAME' => 'EXT_CUSTOM',
															'VALUE' => 'jpg,png,gif,bmp',
															),
													),
											'NAME' => 'file_type',
											),
									),
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'file',
											'FIELD_WIDTH' => '0',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'1' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('request_information_questions_1_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'TEXT',
							'C_SORT' => '800',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'TEXT',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'textarea',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '3',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'2' => array(
							'ACTIVE' => 'Y',
							'TITLE' => 'E-Mail',
							'TITLE_TYPE' => 'text',
							'SID' => 'EMAIL',
							'C_SORT' => '600',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => GetMessage('EMAIL_COMMENT'),
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'EMAIL',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'email',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'3' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('request_information_questions_4_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'PHONE',
							'C_SORT' => '500',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'N',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'PHONE',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'text',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'4' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('request_information_questions_5_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'ADDRESS',
							'C_SORT' => '400',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'ADDRESS',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'textarea',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '3',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'6' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('request_information_questions_7_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'NAME',
							'C_SORT' => '200',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'NAME',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'text',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					'7' => array(
							'ACTIVE' => 'Y',
							'TITLE' => GetMessage('internet_reception_questions_2_TITLE'),
							'TITLE_TYPE' => 'text',
							'SID' => 'TITLE',
							'C_SORT' => '100',
							'ADDITIONAL' => 'N',
							'REQUIRED' => 'Y',
							'IN_FILTER' => 'N',
							'IN_RESULTS_TABLE' => 'Y',
							'IN_EXCEL_TABLE' => 'Y',
							'FIELD_TYPE' => '',
							'IMAGE_ID' => '',
							'COMMENTS' => '',
							'FILTER_TITLE' => '',
							'RESULTS_TABLE_TITLE' => '',
							'VARNAME' => 'TITLE',
							'arANSWER' => array(
									'0' => array(
											'MESSAGE' => ' ',
											'VALUE' => '',
											'FIELD_TYPE' => 'text',
											'FIELD_WIDTH' => '61',
											'FIELD_HEIGHT' => '0',
											'FIELD_PARAM' => '',
											'C_SORT' => '100',
											'ACTIVE' => 'Y',
											),
									),
							),
					
			),
			'statuses' => array(
				'0' => array(
					'CSS' => 'statusgreen',
					'C_SORT' => '100',
					'ACTIVE' => 'Y',
					'TITLE' => GetMessage('STATE_SEND'),
					'DESCRIPTION' => GetMessage('STATE_SEND_DESC'),
					'DEFAULT_VALUE' => 'Y',
					'HANDLER_OUT' => '',
					'HANDLER_IN' => '',
					'MAIL_TEMPLATE_TMP' => array(
					),
					'tmp_id' => 'tmp_1',
					'MAIL_EVENT_TYPES' => array(
					),
					'arPERMISSION_VIEW_TMP' => array(
						'0' => '0',
					),
					'arPERMISSION_MOVE_TMP' => array(
						'0' => '2',
					),
					'arPERMISSION_EDIT_TMP' => array(
						'0' => '0',
					),
					'arPERMISSION_DELETE_TMP' => array(
						'0' => '0',
					),
				),
				'1' => array(
					'CSS' => 'statusgreen',
					'C_SORT' => '200',
					'ACTIVE' => 'Y',
					'TITLE' => GetMessage('STATE_DRAFT'),
					'DESCRIPTION' => GetMessage('STATE_DRAFT_DESC'),
					'DEFAULT_VALUE' => 'N',
					'HANDLER_OUT' => '',
					'HANDLER_IN' => '',
					'MAIL_TEMPLATE_TMP' => array(
					),
					'tmp_id' => 'tmp_1',
					'MAIL_EVENT_TYPES' => array(
					),
					'arPERMISSION_VIEW_TMP' => array(
						'0' => '0',
					),
					'arPERMISSION_MOVE_TMP' => array(
						'0' => '2',
					),
					'arPERMISSION_EDIT_TMP' => array(
						'0' => '0',
					),
					'arPERMISSION_DELETE_TMP' => array(
						'0' => '0',
					),
				),
			),
		),

);
$alreadyInstalled=COption::GetOptionString("bitrix.gossite", "mobile_installed", "", WIZARD_SITE_ID);
foreach($arrForms as $form)
{
	$rsData = CForm::GetList($by, $order, array("SID"=>$form['SID'], "SID_EXACT_MATCH"=>"Y"), $is_filtered);
	if($arForm=$rsData->GetNext())
	{
		$arrSITE = CForm::GetSiteArray($arForm['ID']);
		if(!in_array(WIZARD_SITE_ID, $arrSITE))
		{			
			$arrSITE[]=WIZARD_SITE_ID;
			$res = CForm::Set(array('arSITE'=>$arrSITE), $arForm['ID']);
		}
	}
	else
	{		
		$form['arSITE']=array(WIZARD_SITE_ID);
		$arrToInstall=$form;
		unset($arrToInstall['questions']);
		unset($arrToInstall['arGROUP_TMP']);		
		unset($arrToInstall['statuses']);
		unset($arrToInstall['MAIL_TEMPLATES_TEMP']);
		unset($arrToInstall['arRESTRICT_STATUS_TMP']);
		unset($arrToInstall['arIMAGE']);
		unset($arrToInstall['MAIL_EVENT_TYPE']);
		unset($arrToInstall['arrMAIL_EVENT_TYPE']);
		$et = new CEventType;
		$em = new CEventMessage;
		foreach($form['arrMAIL_EVENT_TYPE'] as $lang=>$event)
		{
			$et->Add($event);
		}
		$arrToInstall['arMAIL_TEMPLATE']=array();
		foreach($form['MAIL_TEMPLATES_TEMP'] as $template)
		{
			$template['LID']=array(WIZARD_SITE_ID);
			$arrToInstall['arMAIL_TEMPLATE'][] = $em->Add($template);			
		}
		foreach($form['arGROUP_TMP'] as $grSTRING_ID=>$perm)
		{
			if($groupsMacros[$grSTRING_ID])
			{
				$arrToInstall['arGROUP'][$groupsMacros[$grSTRING_ID]]=$perm;
			}
			elseif((int)$grSTRING_ID==1 || (int)$grSTRING_ID==2)
			{
				$arrToInstall['arGROUP'][(int)$grSTRING_ID]=$perm;
			}
		}
		$formId = intval(CForm::Set($arrToInstall, false));
		if($formId)
		{			
			if($form['SID']=='internet_reception_'.WIZARD_SITE_ID)
			{
				COption::SetOptionInt("bitrix.gossite", "internet_reception_form_id", $formId, WIZARD_SITE_ID, WIZARD_SITE_ID);
				CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/new.php", array("internet_reception_form_id" =>  $formId));
			}
			if($form['SID']=='request_information_'.WIZARD_SITE_ID)
			{
				COption::SetOptionInt("bitrix.gossite", "request_information_form_id", $formId, WIZARD_SITE_ID, WIZARD_SITE_ID);
				CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/zapros.php", array("request_information_form_id" =>  $formId));
			}
			$updForm=array();
			foreach($form['questions'] as $question)
			{
				$question['FORM_ID']=$formId;
				$arrToInstall=$question;	
				unset($arrToInstall['validators']);
				$questId= intval(CFormField::Set($question, false, "N"));
				if($form['SID']=='internet_reception_'.WIZARD_SITE_ID && $question['SID'] == 'EMAIL' && $questId)
				{
					COption::SetOptionInt("bitrix.gossite", "internet_reception_form_email", $questId, WIZARD_SITE_ID, WIZARD_SITE_ID);
				}
				
				if($form['SID']=='request_information_'.WIZARD_SITE_ID && $question['SID'] == 'EMAIL' && $questId)
				{
					COption::SetOptionInt("bitrix.gossite", "request_information_form_email", $questId, WIZARD_SITE_ID, WIZARD_SITE_ID);
				}
				CFormValidator::SetBatch($formId , $questId, $question['validators']);									
			}
			foreach($form['statuses'] as $statuse)
			{
				$statuse['FORM_ID']=$formId;
				$arrToInstall=$statuse;
				unset($arrToInstall['MAIL_TEMPLATE_TMP']);
				unset($arrToInstall['MAIL_EVENT_TYPES']);
				unset($arrToInstall['arPERMISSION_VIEW_TMP']);
				unset($arrToInstall['arPERMISSION_MOVE_TMP']);
				unset($arrToInstall['arPERMISSION_EDIT_TMP']);
				unset($arrToInstall['arPERMISSION_DELETE_TMP']);
				foreach($statuse['arPERMISSION_VIEW_TMP'] as $grSTRING_ID)
				{
					if($groupsMacros[$grSTRING_ID])
						$arrToInstall['arPERMISSION_VIEW'][]=$groupsMacros[$grSTRING_ID];	
					elseif((int)$grSTRING_ID==1 || (int)$grSTRING_ID==2  || (int)$grSTRING_ID===0)
						$arrToInstall['arPERMISSION_VIEW'][]=(int)$grSTRING_ID;	
				}
				foreach($statuse['arPERMISSION_MOVE_TMP'] as $grSTRING_ID)
				{
					if($groupsMacros[$grSTRING_ID])
						$arrToInstall['arPERMISSION_MOVE'][]=$groupsMacros[$grSTRING_ID];
					elseif((int)$grSTRING_ID==1 || (int)$grSTRING_ID==2  || (int)$grSTRING_ID===0)
						$arrToInstall['arPERMISSION_MOVE'][]=(int)$grSTRING_ID;			
				}
				foreach($statuse['arPERMISSION_EDIT_TMP'] as $grSTRING_ID)
				{
					if($groupsMacros[$grSTRING_ID])
						$arrToInstall['arPERMISSION_EDIT'][]=$groupsMacros[$grSTRING_ID];	
					elseif((int)$grSTRING_ID==1 || (int)$grSTRING_ID==2  || (int)$grSTRING_ID===0)
						$arrToInstall['arPERMISSION_EDIT'][]=(int)$grSTRING_ID;		
				}
				foreach($statuse['arPERMISSION_DELETE_TMP'] as $grSTRING_ID)
				{
					if($groupsMacros[$grSTRING_ID])
						$arrToInstall['arPERMISSION_DELETE'][]=$groupsMacros[$grSTRING_ID];	
					elseif((int)$grSTRING_ID==1 || (int)$grSTRING_ID==2  || (int)$grSTRING_ID===0)
						$arrToInstall['arPERMISSION_DELETE'][]=(int)$grSTRING_ID;		
				}
				unset($arrToInstall['tmp_id']);
				$statusId = intval(CFormStatus::Set($arrToInstall, false, "N"));
				if($statusId)
				{
					foreach($statuse['MAIL_EVENT_TYPES'] as $event)
					{
						$event['NAME']=str_replace('#FORM_SID#', $form['SID'], $event['NAME']);
						$event['EVENT_NAME'] = 'FORM_STATUS_CHANGE_'.$form['SID'].'_'.$statusId;
						$et->Add($event);
					}
					$updateArr=array();				
					foreach($statuse['MAIL_TEMPLATE_TMP'] as $template)
					{
						$template['LID']=array(WIZARD_SITE_ID);
						$template['EVENT_NAME']='FORM_STATUS_CHANGE_'.$form['SID'].'_'.$statusId;
						$updateArr['arMAIL_TEMPLATE'][] = $em->Add($template);			
					}					
					if($updateArr['arMAIL_TEMPLATE'])
					{
						$statusId = intval(CFormStatus::Set($updateArr, $statusId, "N"));
					}
					if($form['arRESTRICT_STATUS_TMP'][$statuse['tmp_id']])
						$updForm['arRESTRICT_STATUS'][]=$statusId;
				}
				if($updForm['arRESTRICT_STATUS'])
					$formId = intval(CForm::Set($updForm, $formId));		
			}			
		}
	}
}

$rsStatuses = CFormStatus::GetList(
	COption::GetOptionString('bitrix.gossite','internet_reception_form_id',0, WIZARD_SITE_ID),
	$by="s_id",
	$order="desc",
	array(),
	$is_filtered
);
while ($arStatus = $rsStatuses->Fetch())
{
	if ($arStatus['DEFAULT_VALUE']=='Y')
		COption::SetOptionString('bitrix.gossite','internet_reception_default',$arStatus['ID'], WIZARD_SITE_ID, WIZARD_SITE_ID);
	else
		COption::SetOptionString('bitrix.gossite','internet_reception_draft',$arStatus['ID'], WIZARD_SITE_ID, WIZARD_SITE_ID);
}

$rsStatuses = CFormStatus::GetList(
	COption::GetOptionString('bitrix.gossite','request_information_form_id',0, WIZARD_SITE_ID),
	$by="s_id",
	$order="desc",
	array(),
	$is_filtered
);
while ($arStatus = $rsStatuses->Fetch())
{
	if ($arStatus['DEFAULT_VALUE']=='Y')
		COption::SetOptionString('bitrix.gossite','request_information_default',$arStatus['ID'], WIZARD_SITE_ID, WIZARD_SITE_ID);
	else
		COption::SetOptionString('bitrix.gossite','request_information_draft',$arStatus['ID'], WIZARD_SITE_ID, WIZARD_SITE_ID);
}
?>