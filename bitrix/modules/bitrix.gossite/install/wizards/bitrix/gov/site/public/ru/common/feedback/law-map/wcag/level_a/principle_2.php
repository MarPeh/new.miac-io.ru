<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Уровень А. Принцип 2. Управляемость");
?>
<h3>Компоненты пользовательского интерфейса и навигации должны быть управляемыми. (уровень А)</h3>
<table class="table table-responsive table-bordered">
	<tr>
		<th width="80">2.1</th>
		<th colspan="2"><b>Доступность управления с клавиатуры</b>
			<p>Предоставьте возможность управления всей функциональностью с клавиатуры</p>
		</th>
	</tr>
	<tr>
		<td>2.1.1</td>
		<td><b>Клавиатура</b>
			<p>Всей функциональностью контента можно управлять с помощью клавиатуры без каких-либо ограничений по времени нажатия на клавишу, за исключением случаев, когда вызываемая функция требует ввода, зависящего от направления движения пользователя, а не только от конечной точки.</p>
			<p>Это исключение относится к вызываемой функции, а не к технике ввода. Например, при вводе текста от руки метод ввода зависит от направления движений пользователя, но сама функция (ввод текста) его не требует.</p>
			<p>Это не запрещает и не должно препятствовать предоставлению возможностей ввода при помощи мыши или другими способами в дополнение к вводу с клавиатуры</p>
		</td>
		<td>Все страницы</td>
	</tr>
	<tr>
		<td>2.1.2</td>
		<td><b>Полное управление с клавиатуры</b>
			<p>Если с помощью клавиатуры можно переместить фокус на один из компонентов страницы, то снять с него фокус можно также с помощью клавиатуры. Если это требует более одного нажатия на клавишу со стрелкой или TAB или использования любого другого стандартного способа выхода, то пользователю предлагается описание метода перемещения фокуса. Этот пункт подразумевает не только реацию элемента при получении фокуса, но и последовательность переходов. Если в коде элементы расположены не в должном порядке, следует использовать атрибут tabindex.</p>
			<p>Контент, не удовлетворяющий этому критерию, может помешать пользователю использовать веб-страницу, поэтому удовлетворять ему должен весь контент веб-страницы (независимо от того, предполагает он выполнение других критериев или нет).</p>
		</td>
		<td>Все страницы</td>
	</tr>
	<tr>
		<th>2.2</th>
		<th colspan="2"><b>Достаточное время</b>
			<p>Предоставьте пользователям достаточно времени для ознакомления и работы с контентом.</p>
		</th>
	</tr>
	<tr>
		<td>2.2.1</td>
		<td><b>Настройка времени</b>
			<p>Для любого ограничения времени, установленного контентом, верно, как минимум, одно из следующих утверждений:</p>
			<p>Выключение — пользователь может выключить ограничение по времени до того, как оно истечет.</p>
			<p>Настройка — пользователь может настроить ограничение по времени до того, как оно истечет, с возможностью увеличения временного лимита минимум в 10 раз.</p>
			<p>Дополнительное время — минимум за 20 секунд пользователь получает уведомление о том, что время истекает, и его можно продлить простым действием (например, «нажмите на клавишу пробела»); пользователь может продлить временной лимит минимум 10 раз подряд.</p>
			<p>Кроме режима реального времени — временное ограничение может быть неотъемлемой частью мероприятия, проходящего в режиме реального времени (например, аукциона), где ограничение по времени нельзя отложить или изменить.</p>
			<p>Кроме случаев особого значения — временное ограничение имеет ключевое значение, а продление времени обесценит цели контента.</p>
			<p>Кроме временного ограничения в 20 и более часов — временное ограничение составляет более 20 часов.</p>
			<p>Выполнение этого положения позволяет пользователю реализовать свои задачи без непредвиденных изменений контента или контекста, вызванных временными ограничениями.</p>
			<p>Относится, в первую очередь, к управлению сессией авторизации.</p>
		</td>
		<td>В демо-версии такой контент не используется</td>
	</tr>
	<tr>
		<td>2.2.2</td>
		<td><b>Пауза, остановка, скрытие</b>
			<p>Для движущихся, мерцающих, прокручивающихся, автоматически обновляющихся элементов верно все нижеследующее:</p>
			<p>Движение, мерцание и прокрутка — для любого движения, мерцания и прокрутки информации, которые (1) начинаются автоматически, (2) длятся более 5 секунд, (3) присутствуют параллельно с другим контентом, пользователю должен быть предоставлен механизм, позволяющий поставить на паузу, остановить или скрыть движение/мерцание/прокрутку элементов, за исключением случаев, где эти действия имеют ключевое значение.</p>
			<p>Автоматическое обновление — для любой автоматически обновляемой информации, которая (1) начинает обновление автоматически и (2) присутствует наряду с другим контентом, пользователю должен быть предоставлен механизм, позволяющий поставить на паузу, остановить, скрыть или изменить частоту обновления. Исключение составляют случаи, когда автоматическое обновление имеет ключевое значение.</p>
			<p>Контент, не удовлетворяющий этому критерию, может помешать пользователю использовать веб-страницу, поэтому удовлетворять ему должен весь контент веб-страницы (независимо от того, предполагает он выполнение других критериев или нет).</p>
			<p>Контент, который обновляется периодически посредством ПО или посылается пользовательскому приложению, не обязательно должен сохранять или отображать информацию, сгенерированную или полученную им в период между паузой и возобновлением отображения. Это может быть технически невозможно, и во многих случаях будет неверно истолковано пользователем.</p>
			<p>Анимация во время загрузки или в подобных ситуациях может иметь ключевое значение, если взаимодействие в этот момент невозможно для пользователя. В этом случае отсутствие отображения индикатора загрузки может быть неверно истолковано им как «зависание» или неисправность программы.</p>
			<p>Управление медиа-контеном (аудио, видео), всевозможными автопросмотрами галерей, автообновлением и т.д.</p>
		</td>
		<td><a href="#SITE_DIR#">Главная</a>
			<br> Прокрутка событий позволяет прокручивать, но на паузу поставить нельзя. Однако, внедрение такого механизма необязательно.
		</td>
	</tr>
	<tr>
		<th>2.3</th>
		<th colspan="2"><b>Требование</b>
			<p>Не используйте заведомо опасные для здоровья элементы дизайна.</p>
		</th>
	</tr>
	<tr>
		<td>2.3.1</td>
		<td><b>Ограничение в три или менее вспышки</b>
			<p>Веб-страницы не содержат элементов, вспыхивающих более трех раз в секунду; или количество вспышек должно быть ниже пороговых величин для вспышек вообще и красных вспышек в частности.</p>
			<p>Контент, не удовлетворяющий этому критерию, может помешать пользователю использовать веб-страницу, поэтому удовлетворять ему должен весь контент веб-страницы (независимо от того, предполагает он выполнение других критериев или нет).</p>
			<p>Требование распространяется и на контент от сторонних поставщиков (реклама)</p>
		</td>
		<td>В демо-версии такой контент не используется</td>
	</tr>
	<tr>
		<th>2.4</th>
		<th colspan="2"><b>Навигация</b>
			<p>Предоставьте пользователям помощь и поддержку в навигации, поиске контента и в определении их текущего положения на сайте.</p>
		</th>
	</tr>
	<tr>
		<td>2.4.1</td>
		<td><b>Пропуск блоков</b>
			<p>Пользователям предоставлен механизм для пропуска блоков контента, которые повторяются на нескольких веб-страницах.</p>
			<p>Этот пункт относится к меню, в котором есть раскрывающиеся пункты. Однако, меню сейчас не полностью функционально, и пока оценивать не имеет смысла.</p>
		</td>
		<td>Все страницы. для меню.</td>
	</tr>
	<tr>
		<td>2.4.2</td>
		<td><b>Заголовок страницы</b>
			<p>Веб-страницы имеют заголовки, описывающие их тематику или цели.</p>
			<p>По требованиям SEO единственный заголовок H1, несколько (2-3) заголовков H2 и некоторое количество (5-6) H3.</p>
		</td>
		<td>Все страницы</td>
	</tr>
	<tr>
		<td>2.4.3</td>
		<td><b>Порядок перемещения фокуса</b>
			<p>Если по веб-странице можно перемещаться последовательно, и эта последовательность влияет на смысл или выполнение задач, то фокус при прочтении должен перемещаться в такой последовательности, при которой сохраняются и смысл, и возможность управления. Помимо контента, выстроенного специальным образом с соответствующей функциональностью (очень часто ознакомительные или обучающие материалы), это относится и к перемещению по элементам форм.</p>
		</td>
		<td>Все страницы: </td>
	</tr>
	<tr>
		<td>2.4.4</td>
		<td><b>Цель ссылки (в контексте)</b>
			<p>Цель каждой ссылки ясна из самого текста ссылки либо из текста ссылки в сочетании с ее программно определенным контекстом. Исключение составляют случаи, когда цель ссылки может быть неоднозначно воспринята разными пользователями. Ссылка представлена текстом либо есть дополнительные элементы, дающие понять, какой контент находится в документе, на который ссылка ведет (всплывающие подсказки, динамические элементы и т.д.).</p>
		</td>
		<td>Все страницы</td>
	</tr>
</table>
<p>
	<noindex>
		<a class="btn btn-dark" href="#SITE_DIR#feedback/law-map/wcag/">
			<i class="icon icon-arrow-white-left"></i> Назад к списку принципов</a>
	</noindex>
</p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
