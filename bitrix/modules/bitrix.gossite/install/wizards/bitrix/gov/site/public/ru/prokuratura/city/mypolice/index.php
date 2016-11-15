<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой участковый");
set_time_limit(0);

?>
<blockquote>
Отображается информация об участковых по районам области. Для управления информацией используется раздела
"Контант" - "Мой участковый" в административной части сайта. Информация структурирована по разделам:
"Участковые", "Зона ответственности участковых", "Опорные пункты" и "Подразделения".</blockquote>
<br />
<?


$PODRAZDEL_IBlockID = "#PODRAZDEL_IBLOCK_ID#";
$OPOR_IBlockID = "#OPOR_IBLOCK_ID#";
$UUM_IBlockID = "#UUM_IBLOCK_ID#";
$UUMTERRITORY_IBlockID = "#UUMTERRITORY_IBLOCK_ID#";
$PODR_OPOR_IBlockID = 43;

$ID 	= isset($_GET['ID'])?$_GET['ID']:'';
$PID 	= isset($_GET['PID'])?intval($_GET['PID']):0;
$OID 	= isset($_GET['OID'])?intval($_GET['OID']):0;
$TYPE 	= isset($_GET['TYPE'])?$_GET['TYPE']:''; // Тип выбранного - подразделение или опорный пункт

if(CModule::IncludeModule('iblock'))
{
	if ($ID)
	{				
		$res = CIBlockElement::GetList(Array("NAME"=>"ASC"), array("CODE"=>$ID));
		$ar_fields = $res->GetNext();
		
			if (substr($ar_fields["NAME"], -2) === "ий" ) $rgn = " район";
			echo "<h3>Опорные пункты - {$ar_fields["NAME"]}{$rgn}</h3>";
			
			$APPLICATION->AddChainItem($ar_fields["NAME"]);
			
			$OpItemsList  = CIBlockElement::GetList(
												Array("SORT"=>"ASC", "CODE"=>"ASC", "NAME"=>"ASC"), 
												Array(
													'IBLOCK_ID' => $OPOR_IBlockID, 
													'ACTIVE'=>'Y',
													'PROPERTY_DEPARTMENT' => $ar_fields['ID']
													)
											);
			while($OpItems = $OpItemsList->GetNext())
			{
        $ItemsList  = CIBlockElement::GetList(
                          Array("SORT"=>"ASC", "CODE"=>"ASC", "NAME"=>"ASC"), 
                          Array(
                            'IBLOCK_ID' => $OPOR_IBlockID, 
                            'ACTIVE'=>'Y',
                            'ID' => $OpItems['ID']
                            ),
                          false,
                          false,
                          array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'DATE_ACTIVE_FROM', 'DATE_ACTIVE_TO', 
                            'PROPERTY_SUBDIV_NAME', 
                            'PROPERTY_OPOR_TOWNTYPE', 
                            'PROPERTY_OPOR_TOWNTYPE', 
                            'PROPERTY_OPOR_TOWNNAME', 
                            'PROPERTY_OPOR_STREETTYPE', 
                            'PROPERTY_OPOR_STREETNAME', 
                            'PROPERTY_OPOR_HOUSE', 
                            'PROPERTY_KORP',
                            'PROPERTY_OPOR_ADDINFO',
                            'PROPERTY_OPOR_INDEX',
                            'PROPERTY_PODR_INDEX',
                            'PROPERTY_OPOR_TELCODE',
                            'PROPERTY_OPOR_TELNUMBER',
                            'PROPERTY_UUM_INFO',
                            'PROPERTY_DEPARTMENT'
                            )
                        );
        while($item = $ItemsList->GetNext())
        {
          $res = CIBlockElement::GetList(Array("NAME"=>"ASC"), array("ID"=>$item["PROPERTY_DEPARTMENT_VALUE"]));
          $ar_fields = $res->GetNext();
          echo "<br /><h3>".$ar_fields["NAME"]." - ".$item["NAME"]."</h3>";
          if (strlen($item['PROPERTY_OPOR_TOWNNAME_VALUE'])>2) echo "<b>Населенный пункт:</b> " . $item['PROPERTY_OPOR_TOWNNAME_VALUE'] . "<br>";
          if ($item['PROPERTY_OPOR_STREETNAME_VALUE']) echo "<b>Адрес:</b> " . $item['PROPERTY_OPOR_STREETNAME_VALUE'] . ", " . $item['PROPERTY_OPOR_HOUSE_VALUE'] . "<br>";
          if ($item['PROPERTY_KORP_VALUE']) echo " корп. " . $item['PROPERTY_KORP_VALUE'] . "<br>";
          if (strlen(trim($item['PROPERTY_OPOR_TELNUMBER_VALUE'])) > 3) 
            echo "<b>Телефон:</b> (" . $item['PROPERTY_OPOR_TELCODE_VALUE'] . ") " . $item['PROPERTY_OPOR_TELNUMBER_VALUE'] . "<br>";
          echo "<hr>";
            $ItemsList2  = CIBlockElement::GetList(
                              Array("SORT"=>"ASC", "CODE"=>"ASC", "NAME"=>"ASC"), 
                              Array(
                                'IBLOCK_ID' => $UUM_IBlockID, 
                                'ACTIVE'=>'Y',
                                'PROPERTY_OPOR' => $OpItems['ID']
                                ),
                              false,
                              false,
                              array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'DATE_ACTIVE_FROM', 'DATE_ACTIVE_TO', 
                                'PROPERTY_UUM_UUCH', 
                                'PROPERTY_UUM_SURNAME', 
                                'PROPERTY_UUM_NAME', 
                                'PROPERTY_UUM_MIDDLENAME', 
                                'PROPERTY_STATUS', 
                                'PROPERTY_UUM_TELCODE', 
                                'PROPERTY_UUM_TELNUMBER', 
                                'PROPERTY_TERRITORY_INFO'
                                )
                            );
            $iii = 0;
            while($item2 = $ItemsList2->GetNext())
            {
              if ($iii++ > 0) {
              
              echo "<hr>";
              }
              echo "Номер участка: " . $item2['PROPERTY_UUM_UUCH_VALUE'] . "<br>";
              echo $item2['PROPERTY_STATUS_VALUE'] . " " . $item2['PROPERTY_UUM_SURNAME_VALUE'] . " " . $item2['PROPERTY_UUM_NAME_VALUE'] . " " . $item2['PROPERTY_UUM_MIDDLENAME_VALUE'] . "<br>";
              if (strlen(trim($item2['PROPERTY_UUM_TELNUMBER_VALUE'])>3)) echo "Телефон: (" . $item2['PROPERTY_UUM_TELCODE_VALUE'] . ") " . $item2['PROPERTY_UUM_TELNUMBER_VALUE'] . "<br>";
              echo "<br>Зона ответственности:<br>";
                $ItemsList3  = CIBlockElement::GetList(
                                Array("SORT"=>"ASC", "CODE"=>"ASC", "NAME"=>"ASC"), 
                                Array(
                                  'IBLOCK_ID' => $UUMTERRITORY_IBlockID, 
                                  'ACTIVE'=>'Y',
                                  'PROPERTY_UCH' => $item2['ID']
                                  ),
                                false,
                                false,
                                array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'DATE_ACTIVE_FROM', 'DATE_ACTIVE_TO', 
                                  'PROPERTY_UUMTERRITORY', 
                                  'PROPERTY_UUM_STREETTYPE', 
                                  'PROPERTY_UUM_STREETNAME', 
                                  'PROPERTY_HOUSES'
                                  )
                              );
              
                while($item3 = $ItemsList3->GetNext())
                {
                  echo "<br>".$item3['PROPERTY_UUM_STREETNAME_VALUE'];
                  if ($item3['PROPERTY_HOUSES_VALUE']) echo " (дома - " . $item3['PROPERTY_HOUSES_VALUE'] . ") ";
                }
            }
        }
			}

		echo "<hr><br><a href='#SITE_DIR#city/mypolice/'>Назад, к списку районов</a>";
	}
	elseif ($OID)
	{
		$ItemsList  = CIBlockElement::GetList(
											Array("SORT"=>"ASC", "CODE"=>"ASC", "NAME"=>"ASC"), 
											Array(
												'IBLOCK_ID' => $OPOR_IBlockID, 
												'ACTIVE'=>'Y',
												'ID' => $OID
												),
											false,
											false,
											array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'DATE_ACTIVE_FROM', 'DATE_ACTIVE_TO', 
												'PROPERTY_SUBDIV_NAME', 
												'PROPERTY_OPOR_TOWNTYPE', 
												'PROPERTY_OPOR_TOWNTYPE', 
												'PROPERTY_OPOR_TOWNNAME', 
												'PROPERTY_OPOR_STREETTYPE', 
												'PROPERTY_OPOR_STREETNAME', 
												'PROPERTY_OPOR_HOUSE', 
												'PROPERTY_KORP',
												'PROPERTY_OPOR_ADDINFO',
												'PROPERTY_OPOR_INDEX',
												'PROPERTY_PODR_INDEX',
												'PROPERTY_OPOR_TELCODE',
												'PROPERTY_OPOR_TELNUMBER',
												'PROPERTY_UUM_INFO',
												'PROPERTY_DEPARTMENT'
												)
										);
		while($item = $ItemsList->GetNext())
		{
			$res = CIBlockElement::GetList(Array("NAME"=>"ASC"), array("ID"=>$item["PROPERTY_DEPARTMENT_VALUE"]));
			$ar_fields = $res->GetNext();
			echo "<h3>".$ar_fields["NAME"]." - ".$item["NAME"]."</h3><br>";
			if (strlen($item['PROPERTY_OPOR_TOWNNAME_VALUE'])>2) echo "<b>Населенный пункт:</b> " . $item['PROPERTY_OPOR_TOWNNAME_VALUE'] . "<br>";
			if ($item['PROPERTY_OPOR_STREETNAME_VALUE']) echo "<b>Адрес:</b> " . $item['PROPERTY_OPOR_STREETNAME_VALUE'] . ", " . $item['PROPERTY_OPOR_HOUSE_VALUE'] . "<br>";
			if ($item['PROPERTY_KORP_VALUE']) echo " корп. " . $item['PROPERTY_KORP_VALUE'] . "<br>";
			if (strlen(trim($item['PROPERTY_OPOR_TELNUMBER_VALUE'])) > 3) 
				echo "<b>Телефон:</b> (" . $item['PROPERTY_OPOR_TELCODE_VALUE'] . ") " . $item['PROPERTY_OPOR_TELNUMBER_VALUE'] . "<br>";
			echo "<hr>";

			echo "<h3>Участковые:</h3>";
				$ItemsList2  = CIBlockElement::GetList(
													Array("SORT"=>"ASC", "CODE"=>"ASC", "NAME"=>"ASC"), 
													Array(
														'IBLOCK_ID' => $UUM_IBlockID, 
														'ACTIVE'=>'Y',
														'PROPERTY_OPOR' => $OID
														),
													false,
													false,
													array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'DATE_ACTIVE_FROM', 'DATE_ACTIVE_TO', 
														'PROPERTY_UUM_UUCH', 
														'PROPERTY_UUM_SURNAME', 
														'PROPERTY_UUM_NAME', 
														'PROPERTY_UUM_MIDDLENAME', 
														'PROPERTY_STATUS', 
														'PROPERTY_UUM_TELCODE', 
														'PROPERTY_UUM_TELNUMBER', 
														'PROPERTY_TERRITORY_INFO'
														)
												);
				
				while($item2 = $ItemsList2->GetNext())
				{
					echo "Номер участка: " . $item2['PROPERTY_UUM_UUCH_VALUE'] . "<br>";
					echo $item2['PROPERTY_STATUS_VALUE'] . " " . $item2['PROPERTY_UUM_SURNAME_VALUE'] . " " . $item2['PROPERTY_UUM_NAME_VALUE'] . " " . $item2['PROPERTY_UUM_MIDDLENAME_VALUE'] . "<br>";
					if (strlen(trim($item2['PROPERTY_UUM_TELNUMBER_VALUE'])>3)) echo "Телефон: (" . $item2['PROPERTY_UUM_TELCODE_VALUE'] . ") " . $item2['PROPERTY_UUM_TELNUMBER_VALUE'] . "<br>";
					echo "<br>Зона ответственности:<br>";
						$ItemsList3  = CIBlockElement::GetList(
														Array("CODE"=>"ASC", "NAME"=>"ASC"), 
														Array(
															'IBLOCK_ID' => $UUMTERRITORY_IBlockID, 
															'ACTIVE'=>'Y',
															'PROPERTY_UCH' => $item2['ID']
															),
														false,
														false,
														array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PREVIEW_TEXT', 'DETAIL_TEXT', 'DATE_ACTIVE_FROM', 'DATE_ACTIVE_TO', 
															'PROPERTY_UUMTERRITORY', 
															'PROPERTY_UUM_STREETTYPE', 
															'PROPERTY_UUM_STREETNAME', 
															'PROPERTY_HOUSES'
															)
													);
					
						while($item3 = $ItemsList3->GetNext())
						{
							echo "<br>".$item3['PROPERTY_UUM_STREETNAME_VALUE'];
							if ($item3['PROPERTY_HOUSES_VALUE']) echo " (дома - " . $item3['PROPERTY_HOUSES_VALUE'] . ") ";
						}
					echo "<hr>";
				}
			echo "<br><a href='javascript:history.back()'>К списку опорных пунктов</a>";
		}
	}
	else if ($KID)
	{
		$PODR_OPOR_Element = CIBlockElement::GetList(
											Array("SORT"=>"ASC", "CODE"=>"ASC", "NAME"=>"ASC"), 
											Array(
												'IBLOCK_ID' => $PODR_OPOR_IBlockID, 
												'ACTIVE'=>'Y'
												)
											);
		while($item = $PODR_OPOR_Element->GetNext())
		{
			$name_arr = array("г. Киров - Первомайский", "г. Киров - Октябрьский", "г. Киров - Ленинский", "г. Киров - Нововятский");
			if (in_array($item['NAME'], $name_arr))
				echo "<a href='#SITE_DIR#city/mypolice/?ID=".$item['ID']."'>".$item['NAME'].'</a><br>';
		}
	}
	else
	{
		$PODR_OPOR_Element = CIBlockElement::GetList(
			Array("SORT"=>"ASC", "NAME"=>"ASC", "CODE"=>"ASC"), 
			Array(
				'IBLOCK_ID' => $PODRAZDEL_IBlockID, 
				'ACTIVE'=>'Y'
			)
		);
		
		$tr = 0;
		while($item = $PODR_OPOR_Element->GetNext())
		{
					$townlist[] = "<a href='#SITE_DIR#city/mypolice/?ID=".$item['CODE']."'>".$item['NAME'].'</a><br>';
		}
		echo "<ul>";
		for ($z=0; $z<round(count($townlist)/2)+1; $z++)
			echo "<li>".$townlist[$z]."</li>";
		echo "</ul>";
		unset($z);
		
		echo "<ul>";
		for ($z=round(count($townlist)/2)+1; $z<count($townlist); $z++)
			echo "<li>".$townlist[$z]."</li>";
		echo "</ul>";
		
	}
}
?> 
<br />
<br />
<br />
<br />
<br />


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>