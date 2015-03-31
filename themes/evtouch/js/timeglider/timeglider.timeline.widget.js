/*
 * Timeglider for Javascript / jQuery 
 * http://timeglider.com/jquery
 *
 * Copyright 2011, Mnemograph LLC
 * Licensed under Timeglider Dual License
 * http://timeglider.com/jquery/?p=license
 *
/*

*         DEPENDENCIES: 
                        rafael.js
                        ba-tinyPubSub
                        jquery
                        jquery ui (and css)
                        jquery.mousewheel
                        jquery.ui.ipad
                        
                        TG_Date.js
                        TG_Timeline.js
                        TG_TimelineView.js
                        TG_Mediator.js
                        TG_Org.js
                        Timeglider.css
*
*/




(function($){
	/**
	* The main jQuery widget factory for Timeglider
	*/
	
	var timelinePlayer, 
		MED, 
		tg = timeglider, 
		TG_Date = timeglider.TG_Date;
	
	$.widget( "timeglider.timeline", {
		
		// defaults!
		options : { 
			base_namespace:"tg",
			timezone:"00:00",
			initial_focus:tg.TG_Date.getToday(), 
			editor:'none', 
			min_zoom : 1, 
			max_zoom : 100, 
			show_centerline: true, 
			data_source:"", 
			culture:"en",
			basic_fontsize:12, 
			mouse_wheel: "zoom", // !TODO | pan 
			initial_timeline_id:'',
		//	icon_folder:'js/timeglider/icons/',
			icon_folder:'/themes/evtouch/js/timeglider/icons/',
			show_footer:true,
			display_zoom_level:true,
			event_modal:{href:'', type:'default'},
			event_overflow:"plus"  // plus | scroll 
		},
		
		_create : function () {
		
			this._id = $(this.element).attr("id");
			/*
			Anatomy:
			*
			*  -container: main frame of entire timeline
			*  -centerline
			*  -truck: entire movable (left-right) container
			*  -ticks: includes "ruler" as well as events
			*  -handle: the grabbable part of the truck which 
			*           self-adjusts to center
			*  -slider-container: wrapper for zoom slider
			*  -slider: jQuery UI vertical slider
			*  -timeline-menu
			*
			*  -measure-span: utility div for measuring text lengths
			*
			*  -footer: (not shown) gets added dynamically unless
			*           options indicate otherwise
			*/
			// no need for template here as no data being passed
			var MAIN_TEMPLATE = "<div class='timeglider-container'>"
				+ "<div class='timeglider-loading'>loading</div>"
				+ "<div class='timeglider-centerline'></div>"
				+ "<div class='timeglider-date-display'></div>"
				+ "<div id='studentsLabel'>Students served</div>" //MG
//				+ "<div class='timeglider-truck' id='tg-truck'>"	//Orig
				+ "<div class='timeglider-truck' id='tg-truck'>" //MG
//				+ "<div class='timeglider-ticks'>"	//Orig
//				+ "<div class='timeglider-ticks'><div id='studentsNum'>"	//MG
				+ "<div class='timeglider-ticks'><div id='studentsNumBkg'></div><div id='studentsNum'>"	//MG added opacity0.7 blu bkg
				+ "<h3>1,400</h3><h3>5,100</h3><h3>8,700</h3><h3>12,900</h3><h3>16,900</h3><h3>21,300</h3><h3>26,900</h3><h3>32,900</h3><h3>41,400</h3><h3>49,322</h3><h3>56,897</h3><h3>63,652</h3><h3>70,072</h3><h3>78,139</h3><h3>87,213</h3><h3>96,572</h3><h3>108,063</h3><h3>119,919</h3><h3>131,846</h3><h3>131,941</h3><h3>143,560</h3><h3>154,085</h3><h3>166,667</h3><h3>177,667</h3><h3>188,667</h3><h3>199,667</h3><h3>210,667</h3><h3>221,667</h3><h3>232,667</h3><h3>243,667</h3><h3>254,667</h3><h3>265,667</h3><h3>276,667</h3><h3>287,667</h3><h3>298,667</h3><h3>309,667</h3><h3>320,667</h3><h3>331,667</h3><h3>342,667</h3><h3>353,667</h3></div>"	//MG
				+ "<div class='timeglider-handle'></div>"
//				+ "</div>"	//Orig
				+ "</div>"
				+ "<div class='timeglider-slider-container'>"
				+ "<div class='timeglider-slider-label'>zoom</div>" // MG added zoom
				+ "<div class='timeglider-slider'></div>"
				+ "<div class='timeglider-pan-buttons'>"
				+ "<div class='timeglider-pan-left'></div><div class='timeglider-pan-right'></div>"
				+ "</div>"
				+ "</div>"
				+ "<div class='timeglider-footer'>"
				+ "<div class='timeglider-logo'></div>"                      
				+ "<div class='timeglider-footer-button timeglider-filter-bt'></div>"
				+ "<div class='timeglider-footer-button timeglider-settings-bt'></div>"
				+ "<div class='timeglider-footer-button timeglider-list-bt'></div>"
				+ "</div>"
				+ "<div class='timeglider-event-hover-info'></div>"
				+ "</div><span id='timeglider-measure-span'></span>";
			
			this.element.html(MAIN_TEMPLATE);
		
		}, // eof _create()
		
		/**
		* takes the created template and inserts functionality
		*  from Mediator and View constructors
		*
		*
		*/
		_init : function () {
			
			// validateOptions should come out as empty string
			var optionsCheck = timeglider.validateOptions(this.options);
			
			if (optionsCheck == "") {
			
				tg.TG_Date.setCulture(this.options.culture);
			
			
			
				MED = new tg.TG_Mediator(this.options, this.element);
				timelinePlayer = new tg.TG_PlayerView(this, MED);
				
			
				// after timelinePlayer is created this stuff can be done
				MED.setFocusDate(new TG_Date(this.options.initial_focus));
				MED.loadTimelineData(this.options.data_source);
			
			} else {
				alert("Rats. There's a problem with your widget settings:" + optionsCheck);
			}
		
		},
		
		
		/** 
		*********  PUBLIC METHODS ***************
		*
		*/
		
		
		/* 
		* goTo
		* sends timeline to a specific date and, optionally, zoom
		* @param d {String} ISO8601 date: 'YYYY-MM-DD HH:MM:SS'
		* @param z {Number} zoom level to change to; optional
		*/
		goTo : function (d, z) {
			MED.gotoDateZoom(d,z);
		},
		
		
		resize : function () {
			timelinePlayer.resize();
		},
		
				
		getMediator : function () {
			return MED;
		},
		
		
		getScope : function () {
			return MED.getScope();
		},
		
		
		filterBy : function (type, content) {
			MED.filterBy(type, content);
		},
		
		
		/**
		* zoom
		* zooms the timeline in or out, adding an amount, often 1 or -1
		*
		* @param n {number|string}
		*          numerical: -1 (or less) for zooming in, 1 (or more) for zooming out
		*          string:    "in" is the same as -1, "out" the same as 1
		*/
		zoom : function (n) {
		
			switch(n) {
				case "in": n = -1; break;
				case "out": n = 1; break;
			}
			// non-valid zoom levels
			if (n > 99 || n < -99) { return false; }
			
			MED.zoom(n);
		},
		
		
		/**
		* zoom
		* zooms the timeline in or out, adding an amount, often 1 or -1
		*
		* @param n {number|string}
		*          numerical: -1 (or less) for zooming in, 1 (or more) for zooming out
		*          string:    "in" is the same as -1, "out" the same as 1
		*/
		load : function (src) {
			MED.loadTimelineData(src);
		},
		
		
		
		/**
		*  panButton
		*  sets a pan action on an element for mousedown and mouseup|mouseover
		*  
		*
		*/
		panButton : function (sel, vel) {
			var _vel = 0;
			switch(vel) {
				case "left": _vel = 30; break;
				case "right": _vel = -30; break;
				default: _vel = vel; break;
			}
			timelinePlayer.setPanButton(sel, _vel);
		},
		
		
		/**
		* destroy 
		* wipes out everything
		*/
		destroy : function () {
			$.Widget.prototype.destroy.apply(this, arguments);
			$(this.element).html("");
		}
	
	}); // end widget process

})(jQuery);
