<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/bitrix.gossite/include.php');
?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=SITE_CHARSET?>">
        <title><?=GetMessage("COAT_POPUP_TITLE")?></title>
        <style type="text/css">

            html {height:100%;}

            body
            {
                background:#fff;
                margin:0;
                padding:0;
                font-family: Arial, Verdana, Helvetica, sans-serif;
                font-size:82%;
                height:100%;
                color:black;
                box-sizing:border-box;
                -moz-box-sizing:border-box;
            }

            table {font-size:100.01%;}

            a {color:#2676b9}

            h3 {font-size:120%;}

            #container
            {
                padding-top:6px;
                height:100%;
                box-sizing:border-box;
                -moz-box-sizing:border-box;
            }

            #main-table
            {
                height:100%;
                border-collapse:collapse;
            }

            #main-table td {padding:0;}

            #step-title
            {
                color:#cd4d3e;
                margin: 20px;
                padding-bottom:20px;
                border-bottom:1px solid #d9d9d9;
                font-weight:bold;
                font-size:120%;
            }


        </style>
    </head>
    <body>
    <?$SID = htmlspecialcharsbx($_GET['SID'])?>
    <?CGovernment::InitNames();?>

    <script type="text/javascript">
        function setCoat(str)
        {
            window.opener.document.getElementById('site-coat-image').src = str;
            window.opener.document.getElementById('site-coat-src').value = str.replace('/bitrix/wizards/bitrix/gov/images/', '/upload/');
            window.close();
        }
    </script>

    <div id="container">

        <table id="main-table" align="center">
            <tr>
                <td colspan="3" height="100%" style="background:white">

                    <table>
                        <tr class="heading">
                            <td valign="top" colspan="2" align="center"><div id="step-title"><?=GetMessage("COAT_POPUP_CITY")?></div></td>
                        </tr>

                        <tr>
                            <td valign="top" colspan="2">
                                <? CGovernment::showCoats('/upload/coats/city/', 'city',$SID); ?>
                            </td>
                        </tr>

                        <tr class="heading">
                            <td valign="top" colspan="2" align="center"><div id="step-title"><?=GetMessage("COAT_POPUP_REGION")?></div></td>
                        </tr>

                        <tr>
                            <td valign="top" colspan="2">
                                <? CGovernment::showCoats('/upload/coats/region/', 'region',$SID); ?>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>
    </div>

    </body>
    </html>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>