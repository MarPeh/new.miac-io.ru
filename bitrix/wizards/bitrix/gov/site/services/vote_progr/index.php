<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
if (WIZARD_IS_RERUN===true)
	return;	
if(!CModule::IncludeModule("vote"))
	return;
if (!is_object($DB))
	global $DB;
$channelsMocros=array();	
$votesChannels=array(
		Array(
			'VOTES' => '"'.'1'.'"',
			'SYMBOLIC_NAME' => '"'.'VOTE'.'"',
			'C_SORT' => '"'.'1'.'"',
			'FIRST_SITE_ID' => '"'.''.WIZARD_SITE_ID.'"',
			'ACTIVE' => '"'.'Y'.'"',
			'TIMESTAMP_X' =>  '"'.$DB->GetNowFunction().'"',
			'TITLE' => '"'.GetMessage('VOTE_TITLE').'"',
			'VOTE_SINGLE' => '"'.'Y'.'"',
			'USE_CAPTCHA' => '"'.'N'.'"',
            'SID' => "'VOTE_".WIZARD_SITE_ID."'"
			),

);
$voteStartTS = mktime(05,10,10,date('m'),date('d'),date('Y'));
$channelsVotes=
		Array(
			'VOTE' => array(
					'0' => array(
							'QUESTIONS' => '1',
							'LAMP' => 'green',
							'CHANNEL_TITLE' => GetMessage('vote_VOTE_0_CHANNEL_TITLE'),
							'C_SORT' => '1',
							'ACTIVE' => 'Y',
							'DATE_START' => $DB->CharToDateFunction(GetTime($voteStartTS,"FULL")),
							'DATE_END' => $DB->CharToDateFunction(GetTime(strtotime('+1 month',$voteStartTS),"FULL")),
							'COUNTER' => '2',
							'TITLE' => GetMessage('vote_VOTE_0_TITLE'),
							'DESCRIPTION' => '',
							'DESCRIPTION_TYPE' => 'html',
							'IMAGE_ID' => '',
							'EVENT1' => 'vote',
							'EVENT2' => 'NULL',
							'EVENT3' => '',
							'UNIQUE_TYPE' => '18',
							'KEEP_IP_SEC' => '0',
							'DELAY' => '0',
							'DELAY_TYPE' => 'S',
							'TEMPLATE' => 'default.php',
							'RESULT_TEMPLATE' => 'default.php',
							'NOTIFY' => 'N',
							'PERIOD' => '34128000',
							'questions' => array(
									'1' => array(
											'ACTIVE' => 'Y',
											'C_SORT' => '1',
											'COUNTER' => '2',
											'QUESTION' => GetMessage('vote_VOTE_0_questions_1_QUESTION'),
											'QUESTION_TYPE' => 'text',
											'IMAGE_ID' => '',
											'DIAGRAM' => 'Y',
											'REQUIRED' => 'N',
											'DIAGRAM_TYPE' => 'histogram',
											'TEMPLATE' => '',
											'TEMPLATE_NEW' => '',
											'answers' => array(
													'0' => array(
															'ACTIVE' => 'Y',
															'C_SORT' => '100',
															'MESSAGE' => GetMessage('vote_VOTE_0_questions_1_answers_0_MESSAGE'),
															'COUNTER' => '2',
															'FIELD_TYPE' => '0',
															'FIELD_WIDTH' => '0',
															'FIELD_HEIGHT' => '0',
															'FIELD_PARAM' => '',
															'COLOR' => '#81a8ab',
															),
													'1' => array(
															'ACTIVE' => 'Y',
															'C_SORT' => '200',
															'MESSAGE' => GetMessage('vote_VOTE_0_questions_1_answers_1_MESSAGE'),
															'COUNTER' => '0',
															'FIELD_TYPE' => '0',
															'FIELD_WIDTH' => '0',
															'FIELD_HEIGHT' => '0',
															'FIELD_PARAM' => '',
															'COLOR' => '#81a8ab',
															),
													'2' => array(
															'ACTIVE' => 'Y',
															'C_SORT' => '300',
															'MESSAGE' => GetMessage('vote_VOTE_0_questions_1_answers_2_MESSAGE'),
															'COUNTER' => '0',
															'FIELD_TYPE' => '0',
															'FIELD_WIDTH' => '0',
															'FIELD_HEIGHT' => '0',
															'FIELD_PARAM' => '',
															'COLOR' => '#81a8ab',
															),
													'3' => array(
															'ACTIVE' => 'Y',
															'C_SORT' => '400',
															'MESSAGE' => GetMessage('vote_VOTE_0_questions_1_answers_3_MESSAGE'),
															'COUNTER' => '0',
															'FIELD_TYPE' => '0',
															'FIELD_WIDTH' => '0',
															'FIELD_HEIGHT' => '0',
															'FIELD_PARAM' => '',
															'COLOR' => '',
															),
													'4' => array(
															'ACTIVE' => 'Y',
															'C_SORT' => '500',
															'MESSAGE' => GetMessage('vote_VOTE_0_questions_1_answers_4_MESSAGE'),
															'COUNTER' => '0',
															'FIELD_TYPE' => '0',
															'FIELD_WIDTH' => '0',
															'FIELD_HEIGHT' => '0',
															'FIELD_PARAM' => '',
															'COLOR' => '',
															),
													'5' => array(
															'ACTIVE' => 'Y',
															'C_SORT' => '600',
															'MESSAGE' => GetMessage('vote_VOTE_0_questions_1_answers_5_MESSAGE'),
															'COUNTER' => '0',
															'FIELD_TYPE' => '0',
															'FIELD_WIDTH' => '0',
															'FIELD_HEIGHT' => '0',
															'FIELD_PARAM' => '',
															'COLOR' => '',
															),
													),
											),
									),
							),
					),
			);


foreach($votesChannels as $voteChannel)
{
	$channelSymbName=str_replace(array('"',"'"),'', $voteChannel['SYMBOLIC_NAME']);
	$rsVoteChan = CVoteChannel::GetList($by, $order, Array("SITE_ID"=>WIZARD_SITE_ID, 'SITE_ID_EXACT_MATCH' => 'Y',"SYMBOLIC_NAME" => $channelSymbName, 'SYMBOLIC_NAME_EXACT_MATCH' => 'Y'), $is_filtered);
	if ($arVoteChan=$rsVoteChan->GetNext())
	{
		$channelId=$arVoteChan['ID'];
		$arrSITE = CVoteChannel::GetSiteArray($arVoteChan['ID']);
		if(!in_array(WIZARD_SITE_ID, $arrSITE))
		{			
			$DB->Query("INSERT INTO b_vote_channel_2_site (CHANNEL_ID, SITE_ID) VALUES ('".$arVoteChan['ID']."', '".WIZARD_SITE_ID."')", false);
		}
	}
	else
	{
		$toInsert=$voteChannel;
		unset($toInsert['VOTES']);
		unset($toInsert['SID']);		
		$toInsert['FIRST_SITE_ID']="'".WIZARD_SITE_ID."'";		
		$channelId=(int)$DB->Insert("b_vote_channel", $toInsert);	
		$DB->Query("INSERT INTO b_vote_channel_2_site (CHANNEL_ID, SITE_ID) VALUES ('".$channelId."', '".WIZARD_SITE_ID."')", false);
		$channelsMocros[$channelSymbName]=$channelId;
		if($channelId)
		{		
			foreach($channelsVotes[$channelSymbName] as $vote)
			{
				$vote['CHANNEL_ID']=$channelId;
				$toInsert=$vote;
				unset($toInsert['questions']);	
				$voteID = CVote::Add($toInsert);
				if($voteID)
				{
					foreach($vote['questions'] as $question)
					{
						$question['VOTE_ID']=$voteID;
						$toInsert=$question;
						unset($toInsert['answers']);	
						$questionID = CVoteQuestion::Add($toInsert);
						if($questionID)
						{
							foreach($question['answers'] as $answer)
							{
								$answer['QUESTION_ID']=$questionID;
								$bResult = CVoteAnswer::Add($answer);
							}
						}
					}
				}
			}
		}
	}	
}
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("VOTE_ID" => $voteID));

//groups
$DB->Query("DELETE FROM b_vote_channel_2_group WHERE CHANNEL_ID='$voteID'", false);

$rsGroups = CGroup::GetList($by, $order, array());
while ($arGroup = $rsGroups->Fetch())
{
    $arFieldsPerm = array(
        "CHANNEL_ID"	=> "'".intval($voteID)."'",
        "GROUP_ID"		=> "'".intval($arGroup["ID"])."'",
        "PERMISSION"	=> "'2'"
    );
    $DB->Insert("b_vote_channel_2_group", $arFieldsPerm);
}

//Module permisions
$APPLICATION->SetGroupRight("vote", WIZARD_PORTAL_ADMINISTRATION_GROUP, "W");
$APPLICATION->SetGroupRight("vote", WIZARD_PERSONNEL_DEPARTMENT_GROUP, "W");
?>