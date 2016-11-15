<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Уровень А. Принцип 4. Надежность ");
?>
<h3>Контент должен быть надежным в такой степени, которая требуется для его интерпретации широким кругом различных пользовательских приложений, включая ассистивные технологии.</h3>
<table class="table table-responsive table-bordered">
	<tr>
		<th width="80">4.1</th>
		<th colspan="2"><b>Требование</b>
			<p>Обеспечьте максимальную совместимость контента с существующими и разрабатываемыми пользовательскими приложениями, включая ассистивные технологии.</p>
		</th>
	</tr>
	<tr>
		<td>4.1.1</td>
		<td><b>Синтаксис</b>
			<p>В контенте, который использует языки разметки, элементы содержат полные открывающие и закрывающие теги, элементы размещены в соответствии со своей спецификацией, элементы не содержат повторяющихся атрибутов, все идентификаторы уникальны, за исключением случаев, где спецификация допускает иное.</p>
			<p>Фактически – это требование к чистоте кода, применению синтаксически грамотной разметки, недопущению нерекомендованных тэгов и атрибутов и отсутствию ошибок.</p>
		</td>
		<td>Все страницы</td>
	</tr>
	<tr>
		<td>4.1.2</td>
		<td><b>Название, роль, значение</b>
			<p>Для всех компонентов пользовательского интерфейса (включая, но не ограничиваясь: элементы форм, ссылки и компоненты, сгенерированные скриптами) название и роль могут быть определены программно; состояние, характеристики и значения, которые могут быть изменены пользователем, могут быть заданы программно; уведомления об изменения этих параметров доступны пользовательским агентам, включая ассистивные технологии.</p>
			<p>Этот критерий предназначен, главным образом, для веб-авторов, которые разрабатывают или программируют собственные компоненты пользовательского интерфейса. Например, стандартные элементы управления HTML по умолчанию отвечают этому критерию, если используются в соответствии со спецификацией.</p>
			<p>Как минимум, поля форм должны быть подписаны, либо в них есть подсказка, исчезающая при начале работы с полем. У ссылок, роль которых отличается от стандартного (открытие нового документа), должен использоваться атрибут title. Элементы фолрм, Работа с которыми предполагает изменение интерфейса, также должны быть снабжены подсказкой.</p>
		</td>
		<td>Все страницы</td>
	</tr>
</table>
<p>
	<noindex>
		<a class="btn btn-dark" href="/feedback/law-map/wcag/">
			<i class="icon icon-arrow-white-left"></i> Назад к списку принципов</a>
	</noindex>
</p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

