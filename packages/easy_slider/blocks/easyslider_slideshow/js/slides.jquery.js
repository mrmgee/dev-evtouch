/*
* Slides, A Slideshow Plugin for jQuery
* Intructions: http://slidesjs.com
* By: Nathan Searles, http://nathansearles.com
* Version: 1.1.7
* Updated: May 2nd, 2011
* 
* Edited by Nicola Moretti (http://nicolamoretti.com) - hanicker
* concrete5 package easy_slider http://www.concrete5.org
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
* http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/
(function($){
	$.fn.slides = function( option ) {
		// override defaults with specified option
		option = $.extend( {}, $.fn.slides.option, option );

		return this.each(function(){
			// wrap slides in control container, make sure slides are block level
			$('.' + option.container, $(this)).children().wrapAll('<div class="slides_control"/>');
			
			var elem = $(this),
				control = $('.slides_control',elem),
				total = control.children().size(),
				width = control.children().outerWidth(),
				height = control.children().outerHeight(),
				start = option.start - 1,
				effect = option.effect.indexOf(',') < 0 ? option.effect : option.effect.replace(' ', '').split(',')[0],
				paginationEffect = option.effect.indexOf(',') < 0 ? effect : option.effect.replace(' ', '').split(',')[1],
				next = 0, prev = 0, number = 0, current = 0, loaded, active, clicked, position, direction, imageParent, pauseTimeout, playInterval;
			var playAnimate=function(){
				clearTimeout(elem.data('interval'));
				animate('next', effect);
				playInterval = setTimeout(playAnimate, option.playCustom(option.index,current));
				elem.data('interval',playInterval);
			}			
			// animate slides
			function animate(direction, effect, clicked) {
				if (!active && loaded) {
					active = true;
					// start of animation
					option.animationStart(current + 1);
					switch(direction) {
						case 'next':
							// change current slide to previous
							prev = current;
							// get next from current + 1
							next = current + 1;
							// if last slide, set next to first slide
							next = total === next ? 0 : next;
							// set position of next slide to right of previous
							position = width*2;
							// distance to slide based on width of slides
							direction = -width*2;
							// store new current slide
							current = next;
						break;
						case 'prev':
							// change current slide to previous
							prev = current;
							// get next from current - 1
							next = current - 1;
							// if first slide, set next to last slide
							next = next === -1 ? total-1 : next;								
							// set position of next slide to left of previous
							position = 0;								
							// distance to slide based on width of slides
							direction = 0;		
							// store new current slide
							current = next;
						break;
						case 'pagination':
							// get next from pagination item clicked, convert to number
							next = parseInt(clicked,10);							
							
							// get previous from pagination item with class of current
							prev = $('.' + option.paginationClass + ' li.'+ option.currentClass +' h2', elem).attr('id');	//Orig

							// if next is greater then previous set position of next slide to right of previous
							if (next > prev) {
								position = width*2;
								direction = -width*2;
							} else {
							// if next is less then previous set position of next slide to left of previous
								position = 0;
								direction = 0;
							}
							// store new current slide
							current = next;
						break;
					}

					// fade animation
					if (effect === 'fade') {
						// fade animation with crossfade
						if (option.crossfade) {
							// put hidden next above current
							control.children(':eq('+ next +')', elem).css({
								zIndex: 10
							// fade in next
							}).fadeIn(option.fadeSpeed, option.fadeEasing, function(){
								if (option.autoHeight) {
									// animate container to height of next
									control.animate({
										height: control.children(':eq('+ next +')', elem).outerHeight()
									}, option.autoHeightSpeed, function(){
										// hide previous
										control.children(':eq('+ prev +')', elem).css({
											display: 'none',
											zIndex: 0
										});								
										// reset z index
										control.children(':eq('+ next +')', elem).css({
											zIndex: 0
										});									
										// end of animation
										option.animationComplete(next + 1);
										active = false;
									});
								} else {
									// hide previous
									control.children(':eq('+ prev +')', elem).css({
										display: 'none',
										zIndex: 0
									});									
									// reset zindex
									control.children(':eq('+ next +')', elem).css({
										zIndex: 0
									});									
									// end of animation
									option.animationComplete(next + 1);
									active = false;
								}
							});
						} else {
							// fade animation with no crossfade
							control.children(':eq('+ prev +')', elem).fadeOut(option.fadeSpeed,  option.fadeEasing, function(){
								// animate to new height
								if (option.autoHeight) {
									control.animate({
										// animate container to height of next
										height: control.children(':eq('+ next +')', elem).outerHeight()
									}, option.autoHeightSpeed,
									// fade in next slide
									function(){
										control.children(':eq('+ next +')', elem).fadeIn(option.fadeSpeed, option.fadeEasing);
									});
								} else {
								// if fixed height
									control.children(':eq('+ next +')', elem).fadeIn(option.fadeSpeed, option.fadeEasing, function(){
										// fix font rendering in ie, lame
										if($.browser.msie) {
											$(this).get(0).style.removeAttribute('filter');
										}
									});
								}									
								// end of animation
								option.animationComplete(next + 1);
								active = false;
							});
						}
					// slide animation
					} else {
						// move next slide to right of previous
						control.children(':eq('+ next +')').css({
							left: position,
							display: 'block'
						});
						// animate to new height
						if (option.autoHeight) {
							control.animate({
								left: direction,
								height: control.children(':eq('+ next +')').outerHeight()
							},option.slideSpeed, option.slideEasing, function(){
								control.css({
									left: -width
								});
								control.children(':eq('+ next +')').css({
									left: width,
									zIndex: 5
								});
								// reset previous slide
								control.children(':eq('+ prev +')').css({
									left: width,
									display: 'none',
									zIndex: 0
								});
								// end of animation
								option.animationComplete(next + 1);
								active = false;
							});
							// if fixed height
							} else {
								// animate control
								control.animate({
									left: direction
								},option.slideSpeed, option.slideEasing, function(){
									// after animation reset control position
									control.css({
										left: -width
									});
									// reset and show next
									control.children(':eq('+ next +')').css({
										left: width,
										zIndex: 5
									});
									// reset previous slide
									control.children(':eq('+ prev +')').css({
										left: width,
										display: 'none',
										zIndex: 0
									});
									// end of animation
									option.animationComplete(next + 1);
									active = false;
								});
							}
						}
					// set current state for pagination
					if (option.pagination) {
						// remove current class from all
						$('.'+ option.paginationClass +' li.' + option.currentClass, elem).removeClass(option.currentClass);
						// add current class to next
						$('.' + option.paginationClass + ' li:eq('+ next +')', elem).addClass(option.currentClass);
					}
				}
			} // end animate function
			
			function stop() {
				// clear pause and interval from stored id
				clearTimeout(elem.data('pause'));
				clearTimeout(elem.data('interval'));
			}
			
			function play(){
				// start play interval after pause
				option.play=1;
				playInterval = setTimeout(playAnimate, option.playCustom(option.index,current));
				// store interval id
				elem.data('interval',playInterval);
			}

			function pause() {
				if (option.pause) {
					// clear timeout and interval
					clearTimeout(elem.data('pause'));
					clearTimeout(elem.data('interval'));
					// pause slide show for option.pause amount
					pauseTimeout = setTimeout(function() {
						// clear pause timeout
						clearTimeout(elem.data('pause'));
						// start play interval after pause
						playInterval = setTimeout(playAnimate, option.playCustom(option.index,current));
						// store interval id
						elem.data('interval',playInterval);
					},option.pause);
					// store pause interval
					elem.data('pause',pauseTimeout);
				} else {
					// if no pause, just stop
					stop();
				}
			}
				
			// 2 or more slides required
			if (total < 2) {
				return;
			}
			
			// error corection for start slide
			if (start < 0) {
				start = 0;
			}
			
			if (start > total) {
				start = total - 1;
			}
					
			// change current based on start option number
			if (option.start) {
				current = start;
			}
			
			// randomizes slide order
			if (option.randomize) {
				control.randomize();
			}
			
			// make sure overflow is hidden, width is set
			$('.' + option.container, elem).css({
				overflow: 'hidden',
				// fix for ie
				position: 'relative'
			});
			
			// set css for slides
			control.children().css({
				position: 'absolute',
				top: 0, 
				left: control.children().outerWidth(),
				zIndex: 0,
				display: 'none'
			 });
			
			// set css for control div
			control.css({
				position: 'relative',
				// size of control 3 x slide width
				width: (width * 3),
				// set height to slide height
				height: height,
				// center control to slide
				left: -width
			});
			
			// show slides
			$('.' + option.container, elem).css({
				display: 'block'
			});

			// if autoHeight true, get and set height of first slide
			if (option.autoHeight) {
				control.children().css({
					height: 'auto'
				});
				control.animate({
					height: control.children(':eq('+ start +')').outerHeight()
				},option.autoHeightSpeed);
			}
			
			// checks if image is loaded
			if (option.preload && control.find('img').length) {
				// adds preload image
				$('.' + option.container, elem).css({
					background: 'url(' + option.preloadImage + ') no-repeat 50% 50%'
				});
				
				// gets image src, with cache buster
				var img = control.find('img:eq(' + start + ')').attr('src') + '?' + (new Date()).getTime();
				
				// check if the image has a parent
				if ($('img', elem).parent().attr('class') != 'slides_control') {
					// If image has parent, get tag name
					imageParent = control.children(':eq(0)')[0].tagName.toLowerCase();
				} else {
					// Image doesn't have parent, use image tag name
					imageParent = control.find('img:eq(' + start + ')');
				}

				// checks if image is loaded
				control.find('img:eq(' + start + ')').attr('src', img).load(function() {
					// once image is fully loaded, fade in
					control.find(imageParent + ':eq(' + start + ')').fadeIn(option.fadeSpeed, option.fadeEasing, function(){
						$(this).css({
							zIndex: 5
						});
						// removes preload image
						$('.' + option.container, elem).css({
							background: ''
						});
						// let the script know everything is loaded
						loaded = true;
						// call the loaded funciton
						option.slidesLoaded();
					});
				});
			} else {
				// if no preloader fade in start slide
				control.children(':eq(' + start + ')').fadeIn(option.fadeSpeed, option.fadeEasing, function(){
					// let the script know everything is loaded
					loaded = true;
					// call the loaded funciton
					option.slidesLoaded();
				});
			}
			
			// click slide for next
			if (option.bigTarget) {
				// set cursor to pointer
				control.children().css({
					cursor: 'pointer'
				});
				// click handler
				control.children().click(function(){
					// animate to next on slide click
					animate('next', effect);
					return false;
				});									
			}
			
			// pause on mouseover
			if (option.hoverPause) {
				control.bind('mouseover',function(){
					// on mouse over stop
					stop();
				});
				control.bind('mouseleave',function(){
					// on mouse leave start pause timeout
					if(option.play!=0)
						pause();
				});
			}
			
			// generate next/prev buttons
			if (option.generateNextPrev) {
				$('.' + option.container, elem).after('<a href="#" class="'+ option.prev +'">Prev</a>');
				$('.' + option.prev, elem).after('<a href="#" class="'+ option.next +'">Next</a>');
			}
			
			// next button
			$('.' + option.next ,elem).click(function(e){
				e.preventDefault();
				if (option.play) {
					pause();
				}
				animate('next', effect);
			});
			
			// previous button
			$('.' + option.prev, elem).click(function(e){
				e.preventDefault();
				if (option.play) {
					 pause();
				}
				animate('prev', effect);
			});
			
			// play button
			$('.' + option.playb ,elem).click(function(e){
				e.preventDefault();
				animate('next', effect);
				option.play=1;
				play();
			});	

			// stop button
			$('.' + option.stopb ,elem).click(function(e){
				e.preventDefault();
				option.play=0;
				stop();
			});			
			
			// generate pagination
			if (option.generatePagination) {
				// create unordered list
				if (option.prependPagination) {
					elem.prepend('<ul class='+ option.paginationClass +'></ul>');
				} else {
					elem.append('<ul class='+ option.paginationClass +'></ul>');
				}
				// for each slide create a list item and link
				control.children().each(function(){
// ADD category class
//Current good		$('.' + option.paginationClass, elem).append('<li class="'+ appCat +'"><a href="#'+ number +'">'+ (number+1) +'</a></li>');
					$('.' + option.paginationClass, elem).append('<li class="'+ appCat +'"><h2 id="'+number+'">'+ (number+1) +'</h2></li>');
					
					number++;
				});
			} else {
				// if pagination exists, add href w/ value of item number to links
				$('.' + option.paginationClass + ' li a', elem).each(function(){
					$(this).attr('href', '#' + number);
					number++;
				});
			}
			
			// add current class to start slide pagination
			$('.' + option.paginationClass + ' li:eq('+ start +')', elem).addClass(option.currentClass);





			// click handling
			var numClicked = "";  // lvl0 click a href
			var numDiv = "";  // #main+clickNum  - results: #main3
			var lvlNum = 0;  // parent level for back btn
			var lvlWrap = 0;  // div container for back btn
			var lvlWrapPar = "";  // parent div container for back btn
			var divWrap = "";  // back show/hide div
			var clickPathArr = [];
		
//			$('.' + option.paginationClass + ' li a', elem ).click(function(){	//Orig
			$('.' + option.paginationClass + ' li h2', elem ).click(function(){
				var parentTag = $(this).parent();
				var btnClicked = $(this).closest('ul').attr('id'); // returns paMain	
				lvlNum = 0;

				// pause slideshow
				if (option.play) {
					 pause();
				}

// Check if paMain Plant/Animal ID main nav
				if (btnClicked == "paMain") {
					//if array  is not empty loop thru and hide div ids
					for(var cpl = 0; cpl < clickPathArr.length; cpl++){  // Loop thru thClickOrigArr array
						$(clickPathArr[cpl]).hide();  // Hide previous div in array					
					}
					
					clickPathArr = []; //Empty array
					
					clickNum = $(this).attr('id');  // returns 3
					numDiv = "#main"+clickNum;  // results 	#main3
					
					$(numDiv).show(); //Show category div
					animate('pagination', paginationEffect, 1); // Go to slide 1 after category div shown

					clickPathArr.push(numDiv);  // add lvl0 #main3 to array
					$('.footer').show(); //Show footer back btn
					lvlNum=1;
					
				} else { // normal function
					// get clicked, pass to animate function
					clicked = $(this).attr('id');
					
					// if current slide equals clicked, don't do anything
					if (current != clicked) {
						animate('pagination', paginationEffect, clicked);
					}
					if (clicked == 6) { // MG exception for plants
						$('#shape17').toggle(); //Show plants div #shape17
						animate('pagination', paginationEffect, clicked);
					}
					
					//Tracking
					var track = $(this).attr('id');  // returns id page name passed to array (rest04 Learning by Doing) added above
					var trMsg = pageTitle+': '+pgname[track];
					if (piwikTracker) { //Piwik tracking id="card4" | ref="lagoons_high_tide"
						piwikTracker.trackPageView(trMsg); //ref="lagoons_high_tide"
					}				
				} // END if (btnClicked == "paMain")
			
				return false;
			});
			
			// click handling
			$('a.link', elem).click(function(){
				// pause slideshow
				if (option.play) {
					 pause();
				}
				// get clicked, pass to animate function					
				clicked = $(this).attr('href').match('[^#/]+$') - 1;
				// if current slide equals clicked, don't do anything			
				if (current != clicked) {
					animate('pagination', paginationEffect, clicked);
				}
				return false;
			});

// MG click handling
		
		function ajaxLoadFun(clickNum){
			$.ajaxSetup ({
				cache: false  
			});
			$('#loadCont').empty(); // EMPTYS container div from previous content
			// CCM_BASE_URL passed from parent page
			var ajax_loadCont = CCM_BASE_URL+"/packages/lightboxed_image/blocks/lightboxed_image/css/theme1/images/loading.gif";
			var ajax_load = "<img src='"+ajax_loadCont+"' alt='loading...' />";

			var loadUrlCont = CCM_BASE_URL+"/index.php?cID="+clickNum;
			
			var loadUrl = loadUrlCont;
			$("#loadCont").html(ajax_load).load(loadUrl);
		}
		
		//LEVEL 1 CLICK
			$('.lvl1 li', elem).click(function(){		
				$(clickPathArr[lvlNum]).hide();  // Hide previous div in array
				
				// pause slideshow
				if (option.play) {
					 pause();
				}

				// get clicked, pass to animate function
				clickNum = $(this).attr('id');  // returns cat130 or 189  Duck-like: cat178

				//Test if cat or not to slide or AJAX load item results
				var clickNumSub = clickNum.substr(3); // removes first 3 chars(cat130) returns 130

				if (clickNumSub != 0) {  // More than 3 chars cat130 TRUE | 180 FALSE
					$(clickPathArr[1]).hide();  // Hide previous div in array[0] lvl1 slot			
					numDiv = "#sub"+clickNumSub;  // results 	#sub130
					$(numDiv).show(); //Show category div
					animate('pagination', paginationEffect, 2); // Go to slide 32 after category div shown
					lvlNum = 2;	//Orig
					clickPathArr.splice(1,1,numDiv);  // REMOVE previous lvl1 and ADD lvl1 #sub130 to array
				
	
				} else {  // AJAX load
					ajaxLoadFun(clickNum);
					animate('pagination', paginationEffect, 3); // Go to slide 3 after category div shown
					lvlNum = 2;	//Orig
				}  // END if (clickNumSub != 0)
				
				var track = $(this).attr('class');  // returns Duck-like Birds
				var trMsg = pageTitle+' ID: '+track;
				if (piwikTracker) { //Piwik tracking id="card4" | ref="lagoons_high_tide"
					piwikTracker.trackPageView(trMsg); //ref="lagoons_high_tide"
				}

				return false;
			});


	
	// MG brds level2 click handling
			$('.lvl2 li', elem).click(function(){
				// pause slideshow
				if (option.play) {
					 pause();
				}
				
				clickNumSub = $(this).attr('id');
				clickNum = clickNumSub.substr(1); // removes first 1 chars(#179) returns 179
				numDiv = "#shape"+clickNum;
				clickPathArr.splice(2,1,numDiv);  // REMOVE previous lvl2 and ADD lvl2 #shape199 to array
		
				var track = $(this).attr('class');  // returns Dabbling Ducks
				var trMsg = pageTitle+' ID: '+track;
				if (piwikTracker) { //Piwik tracking id="card4" | ref="lagoons_high_tide"
					piwikTracker.trackPageView(trMsg); //ref="lagoons_high_tide"
				}

			//AJAX load page via cID
				ajaxLoadFun(clickNum);
				animate('pagination', paginationEffect, 3); // Go to slide 3 after category div shown
				lvlNum = 3;

				return false;
			});		
			
	// MG match start btn click handling
			$('.startBtn').click(function(){
				clickNum = $(this).attr('id');	//Returns 1 <div id="1" class="startBtn earth">Start &gt;</div>
				animate('next', paginationEffect, clickNum); // Animate slide back to lvlNum (lvl1=1, lvl2=2)
				return false;
			});
			
	// MG match next btn click handling
			$('.nextBtnInv').click(function(){
			//	clickNum = $(this).attr('id');	//Returns 1 <div id="1" class="startBtn earth">Start &gt;</div>
				animate('next', paginationEffect, clicked); // Animate slide back to lvlNum (lvl1=1, lvl2=2)
				init(1);	//Calls matching reset function in presentation.php
				return false;
			});
		

// MG footer click handling
			$('.footer').click(function(){	 		
				lvlNum = lvlNum-1;

				if (lvlNum == 0) {	// home slide1 #0 no lvlWrap
					$('.footer').hide(); //Hide footer back btn
					arrInd = lvlNum;
				} else {
					arrInd = lvlNum;
					$(clickPathArr[arrInd]).show();
				}

				animate('pagination', paginationEffect, lvlNum); // Animate slide back to lvlNum (lvl1=1, lvl2=2)
				
				return false;
			});


			if (option.play) {
				// set interval
				playInterval = setTimeout(playAnimate, option.playCustom(option.index,current));
				// store interval id
				elem.data('interval',playInterval);
			}
		});
	};
	


	// default options
	$.fn.slides.option = {
		preload: false, // boolean, Set true to preload images in an image based slideshow
		preloadImage: '/themes/evtouch/images/loading.gif', // string, Name and location of loading image for preloader. Default is "/img/loading.gif"
		container: 'slides_container', // string, Class name for slides container. Default is "slides_container"
		generateNextPrev: false, // boolean, Auto generate next/prev buttons
		next: 'next', // string, Class name for next button
		prev: 'prev', // string, Class name for previous button
		stopb: 'stop', // string, Class name for stop button
		playb: 'play',// string, Class name for play button
		pagination: true, // boolean, If you're not using pagination you can set to false, but don't have to
		generatePagination: true, // boolean, Auto generate pagination
		prependPagination: false, // boolean, prepend pagination
		paginationClass: 'pagination', // string, Class name for pagination
		currentClass: 'current', // string, Class name for current class
		fadeSpeed: 350, // number, Set the speed of the fading animation in milliseconds
		fadeEasing: '', // string, must load jQuery's easing plugin before http://gsgd.co.uk/sandbox/jquery/easing/
		slideSpeed: 350, // number, Set the speed of the sliding animation in milliseconds
		slideEasing: '', // string, must load jQuery's easing plugin before http://gsgd.co.uk/sandbox/jquery/easing/
		start: 1, // number, Set the speed of the sliding animation in milliseconds
		effect: 'slide', // string, '[next/prev], [pagination]', e.g. 'slide, fade' or simply 'fade' for both
		crossfade: false, // boolean, Crossfade images in a image based slideshow
		randomize: false, // boolean, Set to true to randomize slides
		play: 0, // number, Autoplay slideshow, a positive number will set to true and be the time between slide animation in milliseconds
		pause: 0, // number, Pause slideshow on click of next/prev or pagination. A positive number will set to true and be the time of pause in milliseconds
		hoverPause: false, // boolean, Set to true and hovering over slideshow will pause it
		autoHeight: false, // boolean, Set to true to auto adjust height
		autoHeightSpeed: 350, // number, Set auto height animation time in milliseconds
		bigTarget: false, // boolean, Set to true and the whole slide will link to next slide on click
		animationStart: function(){}, // Function called at the start of animation
		animationComplete: function(){}, // Function called at the completion of animation
		slidesLoaded: function() {}, // Function is called when slides is fully loaded
		index:0,
		playCustom: function(index,slideindex){ return this.play}
	};
	
	// Randomize slide order on load
	$.fn.randomize = function(callback) {
		function randomizeOrder() { return(Math.round(Math.random())-0.5); }
			return($(this).each(function() {
			var $this = $(this);
			var $children = $this.children();
			var childCount = $children.length;
			if (childCount > 1) {
				$children.hide();
				var indices = [];
				for (i=0;i<childCount;i++) { indices[indices.length] = i; }
				indices = indices.sort(randomizeOrder);
				$.each(indices,function(j,k) { 
					var $child = $children.eq(k);
					var $clone = $child.clone(true);
					$clone.show().appendTo($this);
					if (callback !== undefined) {
						callback($child, $clone);
					}
				$child.remove();
			});
			}
		}));
	};
})(jq15s);