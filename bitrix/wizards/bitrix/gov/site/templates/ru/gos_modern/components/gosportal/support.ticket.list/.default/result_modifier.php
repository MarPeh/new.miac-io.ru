<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult["TICKETS"] as &$arTicket) {
    $rsStatus = CTicketDictionary::GetList($by = "id", $sort = "asc", array("ID" => $arTicket["STATUS_ID"]), $isFiltered);
    if ($status = $rsStatus->GetNext()) {
        $arTicket["STATUS_NAME"] = $status["NAME"];
    }
}

?>