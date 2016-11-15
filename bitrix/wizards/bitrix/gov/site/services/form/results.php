<?php
if(!CModule::IncludeModule("form"))
	return;
if (WIZARD_IS_RERUN)
	return;
	
$formID = COption::GetOptionString('bitrix.gossite','internet_reception_form_id',0, WIZARD_SITE_ID);
$arForm = array();
$arQuestions = array();
$arAnswers = array();
$arDropdown = array();
$arMultiselect = array();
$mail = COption::GetOptionString('mail','email_from','mail@example.com', WIZARD_SITE_ID);
CForm::GetDataByID($formID, $arForm, $arQuestions, $arAnswers,$arDropdown,$arMultiselect);
$dir = str_replace('\\','/',__DIR__);
$arResults = array(
	array(
		'form_'.$arAnswers['TITLE'][0]['FIELD_TYPE'].'_'.$arAnswers['TITLE'][0]['ID'] => GetMessage('GS_F_ANSWER_1_TITLE'),
		'form_'.$arAnswers['NAME'][0]['FIELD_TYPE'].'_'.$arAnswers['NAME'][0]['ID'] => GetMessage('GS_F_ANSWER_1_NAME'),
		'form_'.$arAnswers['ADDRESS'][0]['FIELD_TYPE'].'_'.$arAnswers['ADDRESS'][0]['ID'] => GetMessage('GS_F_ANSWER_1_ADDRESS'),
		'form_'.$arAnswers['EMAIL'][0]['FIELD_TYPE'].'_'.$arAnswers['EMAIL'][0]['ID'] => $mail,
		'form_'.$arAnswers['TEXT'][0]['FIELD_TYPE'].'_'.$arAnswers['TEXT'][0]['ID'] => GetMessage('GS_F_ANSWER_1_TEXT'),
		'form_'.$arAnswers['FILE'][0]['FIELD_TYPE'].'_'.$arAnswers['FILE'][0]['ID'] => array(
			'name' => 'cdv_photo_003.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => $dir.'/img/cdv_photo_003.jpg',
            'error' => 0,
            'size' => filesize($dir.'/img/cdv_photo_003.jpg'),
		),
	),
	array(
		'form_'.$arAnswers['TITLE'][0]['FIELD_TYPE'].'_'.$arAnswers['TITLE'][0]['ID'] => GetMessage('GS_F_ANSWER_2_TITLE'),
		'form_'.$arAnswers['NAME'][0]['FIELD_TYPE'].'_'.$arAnswers['NAME'][0]['ID'] => GetMessage('GS_F_ANSWER_2_NAME'),
		'form_'.$arAnswers['ADDRESS'][0]['FIELD_TYPE'].'_'.$arAnswers['ADDRESS'][0]['ID'] => GetMessage('GS_F_ANSWER_2_ADDRESS'),
		'form_'.$arAnswers['EMAIL'][0]['FIELD_TYPE'].'_'.$arAnswers['EMAIL'][0]['ID'] => $mail,
		'form_'.$arAnswers['TEXT'][0]['FIELD_TYPE'].'_'.$arAnswers['TEXT'][0]['ID'] => GetMessage('GS_F_ANSWER_2_TEXT'),
		'form_'.$arAnswers['FILE'][0]['FIELD_TYPE'].'_'.$arAnswers['FILE'][0]['ID'] => array(
			'name' => 'cdv_photo_002.jpg',
			'type' => 'image/jpeg',
			'tmp_name' => $dir.'/img/cdv_photo_002.jpg',
			'error' => 0,
			'size' => filesize($dir.'/img/cdv_photo_002.jpg'),
		),
	),
	array(
		'form_'.$arAnswers['TITLE'][0]['FIELD_TYPE'].'_'.$arAnswers['TITLE'][0]['ID'] => GetMessage('GS_F_ANSWER_3_TITLE'),
		'form_'.$arAnswers['NAME'][0]['FIELD_TYPE'].'_'.$arAnswers['NAME'][0]['ID'] => GetMessage('GS_F_ANSWER_3_NAME'),
		'form_'.$arAnswers['ADDRESS'][0]['FIELD_TYPE'].'_'.$arAnswers['ADDRESS'][0]['ID'] => GetMessage('GS_F_ANSWER_3_ADDRESS'),
		'form_'.$arAnswers['EMAIL'][0]['FIELD_TYPE'].'_'.$arAnswers['EMAIL'][0]['ID'] => $mail,
		'form_'.$arAnswers['TEXT'][0]['FIELD_TYPE'].'_'.$arAnswers['TEXT'][0]['ID'] => GetMessage('GS_F_ANSWER_3_TEXT'),
		'form_'.$arAnswers['FILE'][0]['FIELD_TYPE'].'_'.$arAnswers['FILE'][0]['ID'] => array(
			'name' => 'cdv_photo_001.jpg',
			'type' => 'image/jpeg',
			'tmp_name' => $dir.'/img/cdv_photo_001.jpg',
			'error' => 0,
			'size' => filesize($dir.'/img/cdv_photo_001.jpg'),
		),
	),
);

if ($formID>0) {
	foreach ($arResults as $arValues) {
		CFormResult::Add($formID, $arValues);
	}
}

?>