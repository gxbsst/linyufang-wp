/* SuperSlide1.2 --  Copyright ©2012 大话主席 
*/
(function($){
	$.fn.slide=function(options){
		$.fn.slide.deflunt={
		effect : "fade", 
		autoPlay:false, 
		delayTime : 500, 
		interTime : 7000,
		defaultIndex : 0,
		titCell:".hd li",
		mainCell:".bd",
		trigger: "mouseover",
		scroll:1,
		vis:1,
		titOnClassName:"on",
		autoPage:false,
		prevCell:".prev",
		nextCell:".next"
	};

	return this.each(function() {
		var opts = $.extend({},$.fn.slide.deflunt,options);
		var index=opts.defaultIndex;
		var prevBtn = $(opts.prevCell, $(this));
		var nextBtn = $(opts.nextCell, $(this));
			var navObj = $(opts.titCell, $(this));//导航子元素结合
			var navObjSize = navObj.size();
			var conBox = $(opts.mainCell , $(this));//内容元素父层对象
			var conBoxSize=conBox.children().size();
			var slideH=0;
			var slideW=0;
			var selfW=0;
			var selfH=0;
			var autoPlay = opts.autoPlay;
			var inter=null;//setInterval名称 
			var oldIndex = index;

			if(conBoxSize<opts.vis) return; //当内容个数少于可视个数，不执行效果。

			//处理分页
			if( navObjSize==0 )navObjSize=conBoxSize;
			if( opts.autoPage ){
				var tempS = conBoxSize-opts.vis;
				navObjSize=1+parseInt(tempS%opts.scroll!=0?(tempS/opts.scroll+1):(tempS/opts.scroll)); 
				navObj.html(""); 
				for( var i=0; i<navObjSize; i++ ){ navObj.append("<li>"+(i+1)+"</li>") }
				var navObj = $("li", navObj);//重置导航子元素对象
		}

			conBox.children().each(function(){ //取最大值
				if( $(this).width()>selfW ){ selfW=$(this).width(); slideW=$(this).outerWidth(true);  }
				if( $(this).height()>selfH ){ selfH=$(this).height(); slideH=$(this).outerHeight(true);  }
			});

			switch(opts.effect)
			{
				case "top": conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:'+opts.vis*slideH+'px"></div>').css( { "position":"relative","padding":"0","margin":"0"}).children().css( {"height":selfH} ); break;
				case "left": conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:'+opts.vis*slideW+'px"></div>').css( { "width":conBoxSize*slideW,"position":"relative","overflow":"hidden","padding":"0","margin":"0"}).children().css( {"float":"left","width":selfW} ); break;
				case "leftLoop":
				case "leftMarquee":
				conBox.children().clone().appendTo(conBox).clone().prependTo(conBox); 
				conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:'+opts.vis*slideW+'px"></div>').css( { "width":conBoxSize*slideW*3,"position":"relative","overflow":"hidden","padding":"0","margin":"0","left":-conBoxSize*slideW}).children().css( {"float":"left","width":selfW}  ); break;
				case "topLoop":
				case "topMarquee":
				conBox.children().clone().appendTo(conBox).clone().prependTo(conBox); 
				conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:'+opts.vis*slideH+'px"></div>').css( { "height":conBoxSize*slideH*3,"position":"relative","padding":"0","margin":"0","top":-conBoxSize*slideH}).children().css( {"height":selfH} ); break;
			}

			//效果函数
			var doPlay=function(){
				switch(opts.effect)
				{
					case "fade": case "top": case "left": if ( index >= navObjSize) { index = 0; } else if( index < 0) { index = navObjSize-1; } break;
					case "leftMarquee":case "topMarquee": if ( index>= 2) { index=1; } else if( index<0) { index = 0; } break;
					case "leftLoop": case "topLoop":
					var tempNum = index - oldIndex; 
					if( navObjSize>2 && tempNum==-(navObjSize-1) ) tempNum=1;
					if( navObjSize>2 && tempNum==(navObjSize-1) ) tempNum=-1;
					var scrollNum = Math.abs( tempNum*opts.scroll );
					if ( index >= navObjSize) { index = 0; } else if( index < 0) { index = navObjSize-1; }
					break;
				}
				switch (opts.effect)
				{
					case "fade":conBox.children().stop(true,true).eq(index).fadeIn(opts.delayTime).siblings().hide();break;
					case "top":conBox.stop(true,true).animate({"top":-index*opts.scroll*slideH},opts.delayTime);break;
					case "left":conBox.stop(true,true).animate({"left":-index*opts.scroll*slideW},opts.delayTime);break;
					case "leftLoop":
					if(tempNum<0 ){
						conBox.stop(true,true).animate({"left":-(conBoxSize-scrollNum )*slideW},opts.delayTime,function(){
							for(var i=0;i<scrollNum;i++){ conBox.children().last().prependTo(conBox); }
								conBox.css("left",-conBoxSize*slideW);
						});
					}
					else{
						conBox.stop(true,true).animate({"left":-( conBoxSize + scrollNum)*slideW},opts.delayTime,function(){
							for(var i=0;i<scrollNum;i++){ conBox.children().first().appendTo(conBox); }
								conBox.css("left",-conBoxSize*slideW);
						});
						}break;// leftLoop end

						case "topLoop":
						if(tempNum<0 ){
							conBox.stop(true,true).animate({"top":-(conBoxSize-scrollNum )*slideH},opts.delayTime,function(){
								for(var i=0;i<scrollNum;i++){ conBox.children().last().prependTo(conBox); }
									conBox.css("top",-conBoxSize*slideH);
							});
						}
						else{
							conBox.stop(true,true).animate({"top":-( conBoxSize + scrollNum)*slideH},opts.delayTime,function(){
								for(var i=0;i<scrollNum;i++){ conBox.children().first().appendTo(conBox); }
									conBox.css("top",-conBoxSize*slideH);
							});
						}break;//topLoop end

						case "leftMarquee":
						var tempLeft = conBox.css("left").replace("px",""); 

						if(index==0 ){
							conBox.animate({"left":++tempLeft},0,function(){
								if( conBox.css("left").replace("px","")>= 0){ for(var i=0;i<conBoxSize;i++){ conBox.children().last().prependTo(conBox); }conBox.css("left",-conBoxSize*slideW);}
							});
						}
						else{
							conBox.animate({"left":--tempLeft},0,function(){
								if(  conBox.css("left").replace("px","")<= -conBoxSize*slideW*2){ for(var i=0;i<conBoxSize;i++){ conBox.children().first().appendTo(conBox); }conBox.css("left",-conBoxSize*slideW);}
							});
						}break;// leftMarquee end

						case "topMarquee":
						var tempTop = conBox.css("top").replace("px",""); 
						if(index==0 ){
							conBox.animate({"top":++tempTop},0,function(){
								if( conBox.css("top").replace("px","") >= 0){ for(var i=0;i<conBoxSize;i++){ conBox.children().last().prependTo(conBox); }conBox.css("top",-conBoxSize*slideH);}
							});
						}
						else{
							conBox.animate({"top":--tempTop},0,function(){
								if( conBox.css("top").replace("px","")<= -conBoxSize*slideH*2){ for(var i=0;i<conBoxSize;i++){ conBox.children().first().appendTo(conBox); }conBox.css("top",-conBoxSize*slideH);}
							});
							}break;// topMarquee end


				}//switch end
				navObj.removeClass(opts.titOnClassName).eq(index).addClass(opts.titOnClassName);
				oldIndex=index;
			};
			//初始化执行
			doPlay();

			//自动播放
			if (autoPlay) {
				if( opts.effect=="leftMarquee" || opts.effect=="topMarquee"  ){
					index++; inter = setInterval(doPlay, opts.interTime);
					conBox.hover(function(){if(autoPlay){clearInterval(inter); }},function(){if(autoPlay){clearInterval(inter);inter = setInterval(doPlay, opts.interTime);}});
				}else{
					inter=setInterval(function(){index++; doPlay() }, opts.interTime); 
					$(this).hover(function(){if(autoPlay){clearInterval(inter); }},function(){if(autoPlay){clearInterval(inter); inter=setInterval(function(){index++; doPlay() }, opts.interTime); }});
				}
			}

			//鼠标事件
			var mst;
			if(opts.trigger=="mouseover"){
				navObj.hover(function(){ clearTimeout(mst); index=navObj.index(this); mst = window.setTimeout(doPlay,200); }, function(){ if(!mst)clearTimeout(mst); });
			}else{ navObj.click(function(){index=navObj.index(this);  doPlay(); })  }
			nextBtn.click(function(){ index++; doPlay(); });
			prevBtn.click(function(){  index--; doPlay(); });

    	});//each End

	};//slide End

})(jQuery);

jQuery("#focus").slide({ mainCell:".bd ul",effect: "leftLoop",autoPlay:true});
jQuery(".slideTxtBox").slide({effect:"left"});
jQuery(".leftLoop").slide({ mainCell:".bd ul",effect:"leftLoop",vis:4,scroll:4,autoPlay:true});

/*
 * jQuery QuickFlip v2.1.1
 * http://jonraasch.com/blog/quickflip-2-jquery-plugin
 *
 * Copyright (c) 2009 Jon Raasch (http://jonraasch.com/)
 * Licensed under the FreeBSD License:
 * http://dev.jonraasch.com/quickflip/docs#licensing
 *
 */
 (function($){var FALSE=false,NULL=null;$.quickFlip={wrappers:[],opts:[],objs:[],init:function(options,box){var options=options||{};options.closeSpeed=options.closeSpeed||180;options.openSpeed=options.openSpeed||120;options.ctaSelector=options.ctaSelector||'.quickFlipCta';options.refresh=options.refresh||FALSE;options.easing=options.easing||'swing';options.noResize=options.noResize||FALSE;options.vertical=options.vertical||FALSE;var $box=typeof(box)!='undefined'?$(box):$('.quickFlip'),$kids=$box.children();if($box.css('position')=='static')$box.css('position','relative');var i=$.quickFlip.wrappers.length;$kids.each(function(j){var $this=$(this);if(options.ctaSelector){$this.find(options.ctaSelector).click(function(ev){ev.preventDefault();$.quickFlip.flip(i);});}
 	if(j)$this.hide();});$.quickFlip.opts.push(options);$.quickFlip.objs.push({$box:$($box),$kids:$($kids)});$.quickFlip.build(i);if(!options.noResize){$(window).resize(function(){for(var i=0;i<$.quickFlip.wrappers.length;i++){$.quickFlip.removeFlipDivs(i);$.quickFlip.build(i);}});}},build:function(i,currPanel){$.quickFlip.opts[i].panelWidth=$.quickFlip.opts[i].panelWidth||$.quickFlip.objs[i].$box.width();$.quickFlip.opts[i].panelHeight=$.quickFlip.opts[i].panelHeight||$.quickFlip.objs[i].$box.height();var options=$.quickFlip.opts[i],thisFlip={wrapper:$.quickFlip.objs[i].$box,index:i,half:parseInt((options.vertical?options.panelHeight:options.panelWidth)/2),panels:[],flipDivs:[],flipDivCols:[],currPanel:currPanel||0,options:options};$.quickFlip.objs[i].$kids.each(function(j){var $thisPanel=$(this).css({position:'absolute',top:0,left:0,margin:0,padding:0,width:options.panelWidth,height:options.panelHeight});thisFlip.panels[j]=$thisPanel;var $flipDivs=buildFlip(thisFlip,j).hide().appendTo(thisFlip.wrapper);thisFlip.flipDivs[j]=$flipDivs;thisFlip.flipDivCols[j]=$flipDivs.children();});$.quickFlip.wrappers[i]=thisFlip;function buildFlip(x,y){function buildFlipCol(x,y){var $col=$('<div></div>'),$inner=x.panels[y].clone().show();$col.css(flipCss);$col.html($inner);return $col;}
 var $out=$('<div></div>'),inner=x.panels[y].html(),flipCss={width:options.vertical?options.panelWidth:x.half,height:options.vertical?x.half:options.panelHeight,position:'absolute',overflow:'hidden',margin:0,padding:0};if(options.vertical)flipCss.left=0;else flipCss.top=0;var $col1=$(buildFlipCol(x,y)).appendTo($out),$col2=$(buildFlipCol(x,y)).appendTo($out);if(options.vertical){$col1.css('bottom',x.half);$col2.css('top',x.half);$col2.children().css({top:NULL,bottom:0});}
 else{$col1.css('right',x.half);$col2.css('left',x.half);$col2.children().css({right:0,left:'auto'});}
 return $out;}},flip:function(i,nextPanel,repeater,options){function combineOpts(opts1,opts2){opts1=opts1||{};opts2=opts2||{};for(opt in opts1){opts2[opt]=opts1[opt];}
 return opts2;}
 if(typeof i!='number'||typeof $.quickFlip.wrappers[i]=='undefined')return;var x=$.quickFlip.wrappers[i],j=x.currPanel,k=(typeof(nextPanel)!='undefined'&&nextPanel!=NULL)?nextPanel:(x.panels.length>j+1)?j+1:0;x.currPanel=k,repeater=(typeof(repeater)!='undefined'&&repeater!=NULL)?repeater:1;options=combineOpts(options,$.quickFlip.opts[i]);x.panels[j].hide()
 if(options.refresh){$.quickFlip.removeFlipDivs(i);$.quickFlip.build(i,k);x=$.quickFlip.wrappers[i];}
 x.flipDivs[j].show();var panelFlipCount1=0,panelFlipCount2=0,closeCss=options.vertical?{height:0}:{width:0},openCss=options.vertical?{height:x.half}:{width:x.half};x.isanimate=true;x.flipDivCols[j].animate(closeCss,options.closeSpeed,options.easing,function(){if(!panelFlipCount1){panelFlipCount1++;}
 	else{x.flipDivs[k].show();x.flipDivCols[k].css(closeCss);x.flipDivCols[k].animate(openCss,options.openSpeed,options.easing,function(){x.isanimate=false;if(!panelFlipCount2){panelFlipCount2++;}
 		else{x.flipDivs[k].hide();x.panels[k].show();switch(repeater){case 0:case-1:$.quickFlip.flip(i,NULL,-1);break;case 1:break;default:$.quickFlip.flip(i,NULL,repeater-1);break;}}});}});},removeFlipDivs:function(i){for(var j=0;j<$.quickFlip.wrappers[i].flipDivs.length;j++)$.quickFlip.wrappers[i].flipDivs[j].remove();}};$.fn.quickFlip=function(options){this.each(function(){new $.quickFlip.init(options,this);});return this;};$.fn.whichQuickFlip=function(){function compare(obj1,obj2){if(!obj1||!obj2||!obj1.length||!obj2.length||obj1.length!=obj2.length)return FALSE;for(var i=0;i<obj1.length;i++){if(obj1[i]!==obj2[i])return FALSE;}
 return true;}
 var out=NULL;for(var i=0;i<$.quickFlip.wrappers.length;i++){if(compare(this,$($.quickFlip.wrappers[i].wrapper)))out=i;}
 return out;};$.fn.quickFlipper=function(options,nextPanel,repeater){this.each(function(){var $this=$(this),thisIndex=$this.whichQuickFlip();var x=$.quickFlip.wrappers[thisIndex];if(x.isanimate==true){return;}
 	if(thisIndex==NULL){$this.quickFlip(options);thisIndex=$this.whichQuickFlip();}
 	$.quickFlip.flip(thisIndex,nextPanel,repeater,options);});};})(jQuery);

//link starting the signin
jQuery(document).ready(function() {

	jQuery(".signin").click(function(e) {          
		e.preventDefault();
		jQuery("div#signin_menu").toggle(100);
		jQuery(".signin").toggleClass("menu-open");
	});
	
	jQuery("div#signin_menu").mouseup(function() {
		return false
	});
	jQuery(document).mouseup(function(e) {
		if(jQuery(e.target).parent("a.signin").length==0) {
			jQuery(".signin").removeClass("menu-open");
			jQuery("div#signin_menu").hide(200);
		}
	});			
	
});

//link starting the tooltip
this.tooltip = function(){	
	/* CONFIG */		
	xOffset = 25;
	yOffset = 10;		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result		
		/* END CONFIG */		
		jQuery("a.tooltip").hover(function(e){											  
			this.t = this.title;
			this.title = "";									  
			jQuery("body").append("<p id='tooltip'>"+ this.t +"</p>");
			jQuery("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");		
		},
		function(){
			this.title = this.t;		
			jQuery("#tooltip").remove();
		});	
		jQuery("a.tooltip").mousemove(function(e){
			jQuery("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
		});			
	};



// starting the script on page load
jQuery(document).ready(function(){
	tooltip();
});

//link starting the tabs

(function(jQuery) {
	jQuery(function() {
		jQuery('div.tabs').each(function() {
			jQuery(this).find('a').each(function(i) {
				jQuery(this).click(function(){
					jQuery(this).addClass('current').siblings().removeClass('current')
					.parents('div.sidebar_l').find('div.box').hide().end().find('div.box:eq('+i+')').fadeIn(1500);
				});
			});
		});

	})
})(jQuery)


jQuery(document).ready(function(){
	
	//Sidebar Accordion Menu:
	
		jQuery(".main-nav li ul").hide(); // Hide all sub menus
		jQuery(".main-nav li a.current").parent().find("ul").slideToggle("slow"); // Slide down the current menu item's sub menu
		
		jQuery(".main-nav li a.nav-top-item").click( // When a top menu item is clicked...
			function () {
				jQuery(this).parent().siblings().find("ul").slideUp("normal"); // Slide up all sub menus except the one clicked
				jQuery(this).next().slideToggle("normal"); // Slide down the clicked sub menu
				return false;
			}
			);
		
		jQuery(".main-nav li a.no-submenu").click( // When a menu item with no sub menu is clicked...
			function () {
				window.location.href=(this.href); // Just open the link instead of a sub menu
				return false;
			}
			); 

    // Sidebar Accordion Menu Hover Effect:
    
    jQuery(".main-nav li a").hover(
    	function () {
    		jQuery(this).stop().animate({ paddingRight: "35px" }, 50);
    	}, 
    	function () {
    		jQuery(this).stop().animate({ paddingRight: "15px" });
    	}
    	);

});
