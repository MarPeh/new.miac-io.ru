<?
$sMenu = "";
if (count($arMENU)>0) {
	foreach ($arMENU as $el) {
		if ($el['SELECTED']) {
			$sMenu.='<li><b>'.$el['TEXT'].'</b></li>';
		} else {
			$sMenu.='<li><a href="'.$el['LINK'].'">'.$el['TEXT'].'</a></li>';
		}
		
	}
	$sMenu ='<ul style="padding-left: 20px;">'.$sMenu.'</ul>';
	$sMenu = "<table width='100%'><tr><td align='left' valign='middle'>"
		."<img height='37' width=38 src='#SITE_DIR#feedback/icon2.gif'/>"
		."</td><td align='left' valign='top'>$sMenu</td></tr></table>";
	$sMenu = '<div class="support-right-div">'.$sMenu.'</div>';
}

?> 
