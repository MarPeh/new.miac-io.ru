<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/install/wizard_sol/wizard.php");
require_once("scripts/utils.php");

class SelectSiteStep extends CSelectSiteWizardStep
{
    function InitStep()
    {
        parent::InitStep();

        $wizard =& $this->GetWizard();
        $wizard->solutionName = "gosite";

        $this->SetNextStep("select_type");
    }
}

// Тип портала (демо-данные)
class SelectTypeStep extends CWizardStep
{
    function InitStep()
    {
        $this->SetStepID("select_type");
        $this->SetTitle(GetMessage("SELECT_TYPE_TITLE"));
        $this->SetSubTitle(GetMessage("SELECT_TYPE_SUBTITLE"));
        $this->SetPrevStep("init_step");
        $this->SetNextStep("select_theme");
        $this->SetNextCaption(GetMessage("NEXT_BUTTON"));
        $this->SetPrevCaption(GetMessage("PREVIOUS_BUTTON"));
    }

    function OnPostForm()
    {
        $wizard =& $this->GetWizard();

        if ($wizard->IsNextButtonClick())
        {
            $typeID = $wizard->GetVar("typeID");

            if (strlen($typeID) == 0) {
                $_SESSION['gsTypeID'] = null;
                $this->SetError(GetMessage("wiz_type"));
            } else {
                $_SESSION['gsTypeID'] = $typeID;
            }
        }
    }

    function ShowStep()
    {
        $wizard =& $this->GetWizard();

        $this->content .= GetMessage("SELECT_TYPE_TEXT");

        $arDemoTypes = array(
            "demo_mo"          => array("title" => GetMessage("SELECT_TYPE_MO"), "description" => GetMessage("SELECT_TYPE_MO_D")),
            "demo_po"          => array("title" => GetMessage("SELECT_TYPE_PO"), "description" => GetMessage("SELECT_TYPE_PO_D")),
            "demo_zso"         => array("title" => GetMessage("SELECT_TYPE_ZSO"), "description" => GetMessage("SELECT_TYPE_ZSO_D")),
            "demo_gd"          => array("title" => GetMessage("SELECT_TYPE_GD"), "description" => GetMessage("SELECT_TYPE_GD_D")),
            "demo_progr"       => array("title" => GetMessage("SELECT_TYPE_PROGR"), "description" => GetMessage("SELECT_TYPE_PROGR_D")),
            "demo_prokuratura" => array("title" => GetMessage("SELECT_TYPE_PROKURATURA"), "description" => GetMessage("SELECT_TYPE_PROKURATURA_D")),
            "demo_zags"        => array("title" => GetMessage("SELECT_TYPE_ZAGS"), "description" => GetMessage("SELECT_TYPE_ZAGS_D")),
            "demo_dep"         => array("title" => GetMessage("SELECT_TYPE_DEP"), "description" => GetMessage("SELECT_TYPE_DEP_D")),
            "demo_pov"         => array("title" => GetMessage("SELECT_TYPE_POV"), "description" => GetMessage("SELECT_TYPE_POV_D")),
        );

        $siteID = WizardServices::GetCurrentSiteID($wizard->GetVar("siteID"));
        $defaultTypeId = COption::GetOptionString('bitrix.gossite', 'demo_type', false, $siteID);
        if (empty($defaultTypeId) || !array_key_exists($defaultTypeId, $arDemoTypes)) {
            $defaultTypeId = current(array_keys($arDemoTypes));//"demo_mo";
        }
        $wizard->SetDefaultVar("typeID", $defaultTypeId);

        foreach ($arDemoTypes as $typeId => $type) {
            $arRadioParams = array("id" => $typeId, "style" => "float:left;margin-top:5px;");
            if ($typeId == $defaultTypeId) {
                $arRadioParams['checked'] = 'checked';
            }

            $this->content .= "<label style=\"display:block; margin-bottom:8px;padding:12px 16px;\" class=\"inst-title-label inst-module-cell\" for=\"" . $typeId . "\">";

            $this->content .= $this->ShowRadioField("typeID", $typeId, $arRadioParams);
            $this->content .= "<div style=\"margin-left:30px;\">" . $type["title"] . "<br><small>" . $type["description"] . "</small></div>";
            $this->content .= "</label>";
        }
    }
}

class SelectThemeStep extends CSelectThemeWizardStep {
    function InitStep() {
        parent::InitStep();

        $wizard =& $this->GetWizard();
        $this->SetPrevStep("init_step");
        $wizard->SetVar("templateID", "gos_modern");

        $wizard->solutionName = "gossite";
    }
}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
    function InitStep()
    {
        $wizard =& $this->GetWizard();
        $wizard->solutionName = "gossite";
        parent::InitStep();

        $templateID = $wizard->GetVar("templateID");
        $themeID = $wizard->GetVar($templateID."_themeID");

//        $siteLogo = $this->GetFileContentImgSrc(WIZARD_SITE_PATH."includes/logo.php", "/bitrix/wizards/bitrix/edusite/site/templates/gos_modern/themes/".$themeID."/logo.png");
//        if (!file_exists(WIZARD_SITE_PATH."include/logo.png"))
//            $siteLogo = "/bitrix/wizards/bitrix/edusite/site/templates/gos_modern/themes/".$themeID."/logo.png";

        $siteName = COption::GetOptionString("bitrix.gossite", "text1", "", $wizard->GetVar("siteID"));

        $wizard->SetDefaultVars(Array(
//            "siteLogo"          => $siteLogo,
            "siteCoat"        => COption::GetOptionString("bitrix.gossite", "coat",  "/upload/coats/unknown.png", $wizard->GetVar("siteID")),
//            "siteCity"          => COption::GetOptionString("bitrix.gossite", "map_city", GetMessage("WIZ_COMPANY_CITY_DEF"), $wizard->GetVar("siteID")),
            "siteName"          => $siteName ?: $this->GetFileContent(WIZARD_SITE_PATH . "includes/title.php",
                GetMessage("WIZ_COMPANY_NAME_DEF")),
            "siteTopAddress"    => $this->GetFileContent(WIZARD_SITE_PATH . "includes/top-address.php",
                GetMessage("WIZ_COMPANY_T_ADDR_DEF")),
            "siteTopPhone"      => $this->GetFileContent(WIZARD_SITE_PATH . "includes/top-phone.php",
                GetMessage("WIZ_COMPANY_T_PHONE_DEF")),
            "siteCopy"          => $this->GetFileContent(WIZARD_SITE_PATH . "includes/copyright.php",
                GetMessage("WIZ_COMPANY_COPY_DEF")),
        ));
    }

    function OnPostForm()
    {
//        $this->SaveFile("siteLogo", Array("extensions" => "gif,jpg,jpeg,png", "max_height" => 139, "max_width" => 139, "make_preview" => "Y"));
        $this->SaveFile("siteCoatUser", Array("extensions" => "gif,jpg,jpeg,png", "max_height" => 139, "max_width" => 139, "make_preview" => "N"));
    }

    function ShowStep()
    {
        $wizard =& $this->GetWizard();

        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_NAME").'</div>';
        $this->content .= $this->ShowInputField("text", "siteName", Array("id" => "site-name", "class" => "wizard-field"))."</div>";

        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_T_ADDR").'</div>';
        $this->content .= $this->ShowInputField("text", "siteTopAddress", Array("id" => "site-t-address", "class" => "wizard-field"))."</div>";

        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_T_PHONE").'</div>';
        $this->content .= $this->ShowInputField("text", "siteTopPhone", Array("id" => "site-t-phone", "class" => "wizard-field"))."</div>";

//        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_CITY").'</div>';
//        $this->content .= $this->ShowInputField("text", "siteCity", Array("id" => "siteCity", "class" => "wizard-field"));
//        $this->content .= "<div class=\"inst-note-block inst-note-block-yellow\">".GetMessage("WIZ_COMPANY_CITY_DESC")."</div>"."</div>";

//        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_LOGO").'</div>';
//        $this->content .= CFile::ShowImage($wizard->GetVar("siteLogo", true), 139, 139, "border=0 vspace=15");
//        $this->content .= "<br />".$this->ShowFileField("siteLogo", Array("show_file_info" => "N", "id" => "site-logo"))."</div>";

        $coatFilename = COption::GetOptionString("bitrix.gossite", "coat", "",$wizard->GetVar("siteID"));
        if (strlen($coatFilename) > 0) {
            $wizard->SetVar("siteCoat", $coatFilename);
        }
        else {
            $wizard->SetVar("siteCoat", "/upload/coats/unknown.png");
        }
        $siteCoat = $wizard->GetVar("siteCoat");

        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("WIZ_COMPANY_LOGO").'</div>';

        $this->content .= '<a href="/bitrix/wizards/bitrix/gov/coat-popup.php?SID='.$wizard->GetVar("siteID").'" onclick="popup(this);return false;" style="cursor:pointer;">'.CFile::ShowImage($siteCoat, 48, 56, "border=0 id='site-coat-image' style='vertical-align:middle;margin:0 6px 0 0;'", "", false). GetMessage("wiz_select_coat").'</a>';
        $this->content .= $this->ShowHiddenField("siteCoatSrc", $siteCoat, Array("id" => "site-coat-src"));
        $this->content .= '</div>';

        $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("wiz_site_coat_download").'</div>';
        $this->content .= $this->ShowFileField("siteCoatUser", Array("show_file_info" => "N", "id" => "site-coat-user"));
        $this->content .= '</div>';

        if($wizard->GetVar("WIZARD_IS_RERUN")!==true)
        {
            $this->content .= '<div class="inst-cont-title-wrap"><div class="inst-cont-title">' . $this->ShowCheckboxField("installSupport", "Y", Array("id" => "install-support", "onchange" => "OnChangeSupport(this)")) . "<label for=\"install-support\">&nbsp;".GetMessage("wiz_demo_support_install")."</label></div></div>";

            $this->content .= "<div id=\"support-container\" style=\"display:none;\">";

            $this->content .= "<div class=\"inst-note-block inst-note-block-red\">".GetMessage("wiz_demo_support_warning")."</div>";

            $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("wiz_demo_support_server").'</div>';
            $this->content .= $this->ShowInputField("text", "supportServer", Array("id" => "support-server", "class" => "wizard-field"))."</div>";

            $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("wiz_demo_support_port").'</div>';
            $this->content .= $this->ShowInputField("text", "supportPort", Array("id" => "support-port", "class" => "wizard-field"))."</div>";

            $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("wiz_demo_support_email").'</div>';
            $this->content .= $this->ShowInputField("text", "supportEMail", Array("id" => "support-email", "class" => "wizard-field"))."</div>";

            $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("wiz_demo_support_login").'</div>';
            $this->content .= $this->ShowInputField("text", "supportLogin", Array("id" => "support-login", "class" => "wizard-field"))."</div>";

            $this->content .= '<div class="wizard-upload-img-block"><div class="wizard-catalog-title">'.GetMessage("wiz_demo_support_password").'</div>';
            $this->content .= $this->ShowInputField("text", "supportPassword", Array("id" => "support-password", "class" => "wizard-field"))."</div>";


            $this->content .= "</div>";
        }

        $this->content .= '
      <script type="text/javascript">
      function popup(a)
      {
        settings = {
          width:      800,
          height:     480,
          toolbar:    0,
          scrollbars: 1,
          status:     0,
          resizable:  0,
          left:       200,
          top:        200,
          center:     0,
          createnew:  0,
          location:   0,
          menubar:    0
        };

        parameters = "location=" + settings.location + ",menubar=" + settings.menubar + ",height=" + settings.height + ",width=" + settings.width + ",toolbar=" + settings.toolbar + ",scrollbars=" + settings.scrollbars  + ",status=" + settings.status + ",resizable=" + settings.resizable + ",left=" + settings.left  + ",screenX=" + settings.left + ",top=" + settings.top  + ",screenY=" + settings.top;

        window.open(a.href, "coat_selector", parameters).focus();
      }
            function OnChangeSupport(checkbox)
            {
                if (!checkbox.checked) {
                     document.getElementById("support-container").style.display = "none";
                }
                else {
                     document.getElementById("support-container").style.display = "";
                }
            }
			</script>';
    }
}


class DataInstallStep extends CDataInstallWizardStep
{
}

class FinishStep extends CFinishWizardStep
{
}
?>