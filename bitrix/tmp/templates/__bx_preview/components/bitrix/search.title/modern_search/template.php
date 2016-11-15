<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);
?>

<div class="container container-search">
    <div class="content">
        <div class="col col-mb-12" id="<?echo $CONTAINER_ID?>">
	        <form action="<?=$arResult["FORM_ACTION"]?>">
                <div class="search-form-block">
                    <i class="icon icon-search-white"></i>
                    <div class="search-close-button"><i class="icon icon-close"></i></div>
                    <div class="ov-h">
                        <input id="<?echo $INPUT_ID?>" class="search-input" type="text" name="q" autocomplete="off">
                    </div>
                </div>
            </form>
            <div class="search-suggestions">
                <a href="#" class="btn btn-cta">Все результаты</a>
            </div>
        </div>
    </div>
</div>

<script>

function JCTitleSearchModern(arParams)
{
	var _this = this;

	this.arParams = {
		'AJAX_PAGE': arParams.AJAX_PAGE,
		'CONTAINER_ID': arParams.CONTAINER_ID,
		'INPUT_ID': arParams.INPUT_ID,
		'MIN_QUERY_LEN': parseInt(arParams.MIN_QUERY_LEN)
	};
	if(arParams.WAIT_IMAGE)
		this.arParams.WAIT_IMAGE = arParams.WAIT_IMAGE;
	if(arParams.MIN_QUERY_LEN <= 0)
		arParams.MIN_QUERY_LEN = 1;

	this.cache = [];
	this.cache_key = null;

	this.startText = '';
	this.currentRow = -1;
	this.RESULT = null;
	this.CONTAINER = null;
	this.INPUT = null;
	this.WAIT = null;

	this.ShowResult = function(result)
	{
		var suggestions = document.getElementsByClassName('search-suggestions');
		suggestions[0].innerHTML = result;
	}

	this.onKeyPress = function(keyCode)
	{
		var tbl = BX.findChild(_this.RESULT, {'tag':'div','class':'search-result'}, true);
		if(!tbl)
			return false;

		var cnt = tbl.rows.length;

		switch (keyCode)
		{
			case 27: // escape key - close search div
				_this.RESULT.style.display = 'none';
				_this.currentRow = -1;
				_this.UnSelectAll();
				return true;

			case 40: // down key - navigate down on search results
				if(_this.RESULT.style.display == 'none')
					_this.RESULT.style.display = 'block';

				var first = -1;
				for(var i = 0; i < cnt; i++)
				{
					if(!BX.findChild(tbl.rows[i], {'class':'title-search-separator'}, true))
					{
						if(first == -1)
							first = i;

						if(_this.currentRow < i)
						{
							_this.currentRow = i;
							break;
						}
						else if(tbl.rows[i].className == 'title-search-selected')
						{
							tbl.rows[i].className = '';
						}
					}
				}

				if(i == cnt && _this.currentRow != i)
					_this.currentRow = first;

				tbl.rows[_this.currentRow].className = 'title-search-selected';
				return true;

			case 38: // up key - navigate up on search results
				if(_this.RESULT.style.display == 'none')
					_this.RESULT.style.display = 'block';

				var last = -1;
				for(var i = cnt-1; i >= 0; i--)
				{
					if(!BX.findChild(tbl.rows[i], {'class':'title-search-separator'}, true))
					{
						if(last == -1)
							last = i;

						if(_this.currentRow > i)
						{
							_this.currentRow = i;
							break;
						}
						else if(tbl.rows[i].className == 'title-search-selected')
						{
							tbl.rows[i].className = '';
						}
					}
				}

				if(i < 0 && _this.currentRow != i)
					_this.currentRow = last;

				tbl.rows[_this.currentRow].className = 'title-search-selected';
				return true;

			case 13: // enter key - choose current search result
				if(_this.RESULT.style.display == 'block')
				{
					for(var i = 0; i < cnt; i++)
					{
						if(_this.currentRow == i)
						{
							if(!BX.findChild(tbl.rows[i], {'class':'title-search-separator'}, true))
							{
								var a = BX.findChild(tbl.rows[i], {'tag':'a'}, true);
								if(a)
								{
									window.location = a.href;
									return true;
								}
							}
						}
					}
				}
				return false;
		}

		return false;
	}

	this.onTimeout = function()
	{
		_this.onChange(function(){
			setTimeout(_this.onTimeout, 500);
		});
	}

	this.onChange = function(callback)
	{
		if(_this.INPUT.value != _this.oldValue && _this.INPUT.value != _this.startText)
		{
			_this.oldValue = _this.INPUT.value;
			if(_this.INPUT.value.length >= _this.arParams.MIN_QUERY_LEN)
			{
				_this.cache_key = _this.arParams.INPUT_ID + '|' + _this.INPUT.value;
				if(_this.cache[_this.cache_key] == null)
				{
					if(_this.WAIT)
					{
						var pos = BX.pos(_this.INPUT);
						var height = (pos.bottom - pos.top)-2;
						_this.WAIT.style.top = (pos.top+1) + 'px';
						_this.WAIT.style.height = height + 'px';
						_this.WAIT.style.width = height + 'px';
						_this.WAIT.style.left = (pos.right - height + 2) + 'px';
						_this.WAIT.style.display = 'block';
					}

					BX.ajax.post(
						_this.arParams.AJAX_PAGE,
						{
							'ajax_call':'y',
							'INPUT_ID':_this.arParams.INPUT_ID,
							'q':_this.INPUT.value,
							'l':_this.arParams.MIN_QUERY_LEN
						},
						function(result)
						{
							_this.cache[_this.cache_key] = result;
							_this.ShowResult(result);
							_this.currentRow = -1;
							_this.EnableMouseEvents();
							if(_this.WAIT)
								_this.WAIT.style.display = 'none';
							if (!!callback)
								callback();
						}
					);
					return;
				}
				else
				{
					_this.ShowResult(_this.cache[_this.cache_key]);
					_this.currentRow = -1;
					_this.EnableMouseEvents();
				}
			}
			else
			{
				_this.RESULT.style.display = 'none';
				_this.currentRow = -1;
				_this.UnSelectAll();
			}
		}
		if (!!callback)
			callback();
	}

	this.UnSelectAll = function()
	{
		var tbl = BX.findChild(_this.RESULT, {'tag':'div','class':'search-result'}, true);
		if(tbl)
		{
			var cnt = tbl.rows.length;
			for(var i = 0; i < cnt; i++)
				tbl.rows[i].className = '';
		}
	}

	this.EnableMouseEvents = function()
	{
		var tbl = BX.findChild(_this.RESULT, {'tag':'div','class':'search-result'}, true);
		if(tbl)
		{
			var cnt = tbl.rows.length;
			for(var i = 0; i < cnt; i++)
				if(!BX.findChild(tbl.rows[i], {'class':'title-search-separator'}, true))
				{
					tbl.rows[i].id = 'row_' + i;
					tbl.rows[i].onmouseover = function (e) {
						if(_this.currentRow != this.id.substr(4))
						{
							_this.UnSelectAll();
							this.className = 'title-search-selected';
							_this.currentRow = this.id.substr(4);
						}
					};
					tbl.rows[i].onmouseout = function (e) {
						this.className = '';
						_this.currentRow = -1;
					};
				}
		}
	}

	this.onFocusLost = function(hide)
	{
		setTimeout(function(){_this.RESULT.style.display = 'none';}, 250);
	}

	this.onFocusGain = function()
	{
		if(_this.RESULT.innerHTML.length)
			_this.ShowResult();
	}

	this.onKeyDown = function(e)
	{
		if(!e)
			e = window.event;

		if (_this.RESULT.style.display == 'block')
		{
			if(_this.onKeyPress(e.keyCode))
				return BX.PreventDefault(e);
		}
	}

	this.Init = function()
	{
		this.CONTAINER = document.getElementById(this.arParams.CONTAINER_ID);
		this.RESULT = document.body.appendChild(document.createElement("DIV"));
		this.RESULT.className = 'search-suggestions';
		this.INPUT = document.getElementById(this.arParams.INPUT_ID);
		this.startText = this.oldValue = this.INPUT.value;
		BX.bind(this.INPUT, 'focus', function() {_this.onFocusGain()});
		BX.bind(this.INPUT, 'blur', function() {_this.onFocusLost()});

		if(BX.browser.IsSafari() || BX.browser.IsIE())
			this.INPUT.onkeydown = this.onKeyDown;
		else
			this.INPUT.onkeypress = this.onKeyDown;

		if(this.arParams.WAIT_IMAGE)
		{
			this.WAIT = document.body.appendChild(document.createElement("DIV"));
			this.WAIT.style.backgroundImage = "url('" + this.arParams.WAIT_IMAGE + "')";
			if(!BX.browser.IsIE())
				this.WAIT.style.backgroundRepeat = 'none';
			this.WAIT.style.display = 'none';
			this.WAIT.style.position = 'absolute';
			this.WAIT.style.zIndex = '1100';
		}

		BX.bind(this.INPUT, 'bxchange', function() {_this.onChange()});
	}

	BX.ready(function (){_this.Init(arParams)});
}

	BX.ready(function(){
		new JCTitleSearchModern({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'MIN_QUERY_LEN': 2
		});
	});
</script>
