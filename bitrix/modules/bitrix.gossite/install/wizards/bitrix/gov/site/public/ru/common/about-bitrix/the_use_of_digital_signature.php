<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Применение Электронно-цифровой подписи (ЭЦП)");
$APPLICATION->AddChainItem("Применение Электронно-цифровой подписи (ЭЦП)", "");
?> 
<script>
	function HideAll() {
        if(document.getElementById("TBXLoginAuto"))
            document.getElementById("TBXLoginAuto").style.display = "none";
        if(document.getElementById("TBXLoginManual"))
            document.getElementById("TBXLoginManual").style.display = "none";
        if(document.getElementById("TBXDocsAuto"))
            document.getElementById("TBXDocsAuto").style.display = "none";
        if(document.getElementById("TBXDocsManual"))
            document.getElementById("TBXDocsManual").style.display = "none";
	}
	function ChangeVisibility(elementID) {
		var element = document.getElementById(elementID);
		if (element.style.display == "none")
			element.style.display = "";
		else
			element.style.display = "none";

	}
</script>
      
<div>Технология <b>ЭЦП </b>значительно повышает безопасность корпоративных порталов и официальных сайтов государственных и частных компаний, которые используются в качестве хранилищ или средств публикации документов официального характера.  Интеграция технологии ЭЦП в интернет-портал рассматривается как базовый элемент построения систем юридически значимого документооборота. Теперь технология ЭЦП поддерживается в программных продуктах компании &laquo;1С-Битрикс&raquo;. 
  <br />
 
  <br />
 <noindex><a href="http://www.trusted.ru" target="_blank" rel="nofollow" >Компания &quot;Цифровые технологии&quot;</a></noindex> предлагает компелксное решение по ЭЦП аутентификации на сайте, составной частью которого является модуль для платформы 1С-Битрикс, представленный в <a href="http://marketplace.1c-bitrix.ru" target="_blank" >1С-Битрикс: Маркетплейс</a>. 
  <br />
 
  <br />
 Модуль <b>TrustedBitrixLogin</b> позволяет безопасно передавать необходимую информацию (организуется защищенный канал с передачей данных по TLS-протоколу с использованием ГОСТ-алгоритмов шифрования) и автоматически обеспечить проверку подлинности как клиента, так и сервера. 
  <br />
 
  <br />
 
  <div style="text-align: center;"><img id="bxid_349707" border="0" class="border" title="Модуль TrustedBitrixLogin" alt="Модуль TrustedBitrixLogin" src="http://www.1c-bitrix.ru/images/anons/tblogin.png"  /> 
    <br />
   </div>
 
  <br />
  Требуемое программное обеспечение (ПО): на сервере &ndash; <noindex><a id="bxid_957888" href="/bitrix/redirect.php?event1=news&event2=trusted&event3=&goto=http%3A//www.trusted.ru/products/trusted-tls/" target="_blank" rel="nofollow" >Trusted TLS</a></noindex>, &laquo;<noindex><a id="bxid_174498" href="/bitrix/redirect.php?event1=news&event2=trusted&event3=&goto=http%3A//www.trusted.ru/products/cryptoarm/" target="_blank" rel="nofollow" >КриптоАРМ</a></noindex>&raquo;, &laquo;КриптоПро CSP&raquo;, на клиенте: &laquo;КриптоПро CSP&raquo;.
  <br />
 
  <br />
<a href="http://marketplace.1c-bitrix.ru/solutions/trusted.tbstart/#tab-install-link" target="_blank" >Подробнее</a>
  <br />
   
<script>
		HideAll();
</script>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>