;(function($){
	$.fn.jcContact = function(options) {
		var defaults = {
            speed:400,                   //璁剧疆鍔ㄧ敾鏃堕棿锛坢m锛�
			position:'center',           //澶栧眰妗嗘灦鍨傜洿浣嶇疆锛屾彁渚�"top","center","bottom"
			posOffsetY : 0,              //寰皟璁剧疆澶栧眰妗嗘灦鍨傜洿浣嶇疆
			btnPosition : 'center',      //鎸夐挳鍨傜洿浣嶇疆锛屾彁渚�"top","center","bottom"
			btnPosoffsetY : 0 ,          //寰皟璁剧疆鎸夐挳鍨傜洿浣嶇疆
			float:'left',                //妗嗘灦浣嶇疆锛屾彁渚�"left","right"
			Event : "click"              //璁剧疆灞曞紑妗嗘灦浜嬩欢锛屾彁渚�"mouseover","lick"
		};
		var options = $.extend(defaults,options);
		return this.each(function() {
			$("body").css("overflow-x","hidden");
			var $this = $(this),
			    _self = this,
				wrapTop = 0,
				BtmTop = 0,
				_width = 0,
				$window = $(window),
				winWidth = $window.width(),
				winHeight = $window.height(),
				$Con = $this.children(":eq(0)"),
				nConWidth = $Con.width(),
				nConHeight = $Con.height(),
				$btn = $this.children(":eq(1)"),
				nbtnWidth = $btn.width(),
				nbtnHeight = $btn.height(),
				//鏂板缓鍙傛暟绫�
				fnMode = function(){
					this.left = setWrapPos;
					this.right = setWrapPos;
					this.top = setWrapTop;
					this.center = setWrapTop;
					this.bottom = setWrapTop;
					this.btntop = setBtnTop;
					this.btncenter = setBtnTop;
					this.btnbottom = setBtnTop;
				};
			fnMode.prototype.Mode = function(mode,btnPos,wrapPos){
				this[mode](mode);
				this[wrapPos](wrapPos);
				this[btnPos](btnPos);
			};
			//鍒濆鍖栦綅缃�
			var o = new fnMode,
			    speed = Math.round(options.speed*0.5);
			o.Mode(options.float,"btn"+options.btnPosition,options.position);
			//婊氬姩浜嬩欢
			$(window).scroll(function(){
				var nScrollTop = $(this).scrollTop();
				setAnimate(nScrollTop,setWrapTop);
			});
			$btn.bind(options.Event,function(e){
				var obool = null;
				if(options.float == "left"){
					_width = 0;
					obool = parseInt($this.css("left")) < _width;
				} else if(options.float == "right"){
					_width = winWidth - nConWidth;
					obool = parseInt($this.css("left")) > _width;
				};
				if(obool){
					$this.animate({"left": _width},speed);
				};
			})
			$this.bind("mouseleave",function(){
				if(options.float == "left"){
					_width = -nConWidth;
				} else if(options.float == "right"){
					_width = winWidth;
				};
				$this.animate({"left": _width},speed);
			});
			//鍔熻兘鏂规硶
			function setBtnTop(pos){
				var setPos;
				if(pos == "btntop"){
					setPos = 0;
				} else if(pos == "btncenter") {
					setPos = (nConHeight-nbtnHeight)/2;
				} if(pos == "btnbottom") {
					setPos = nConHeight-nbtnHeight;
				};
				BtmTop = setPos+options.btnPosoffsetY;
				$btn.css("top",BtmTop);
				return false;
			};
            function setWrapTop(pos){
				var _st,setVal;
				if(pos == "top"){
					_st = $(window).scrollTop();
					setVal = 0;
				} else if(pos == "center") {
					_st = $(window).scrollTop();
					setVal = (winHeight-nConHeight)/2;
				} else if(pos == "bottom") {
					_st = $(window).scrollTop();
					setVal = winHeight-nConHeight;
				};
				setWrapTop = setVal + options.posOffsetY;
				setAnimate(_st,setWrapTop);
				return false;
			};
			function setWrapPos(sPos){
				var wrapLeft,btnLeft;
				if(sPos == "left"){
			        wrapLeft = -nConWidth;
			        btnLeft = nConWidth;
				} else if(sPos == "right"){
			        wrapLeft = winWidth;
			        btnLeft =-nbtnWidth;
				};
				
				$btn.css("left",btnLeft-10);
				$this.css("left",wrapLeft).show();
				return false;
			};
			function setAnimate(st,val){
				$this.stop().animate({"top":val+st},options.speed);
				return false;
			};
			return false;
		});
	};
})(jQuery)