// JavaScript Document

var vi={};

Event.observe(
			  window,
			  'load',
			  function(){
				  vi.videos=$$('a.lightwindow');
				  modifyLightWindowAnchor();
			  }
			 );

function modifyLightWindowAnchor(){
	
	$A(vi.videos).each(function(value,index){
								value.setAttribute("params",'lightwindow_width=853,lightwindow_height=505,lightwindow_loading_animation=false');
								}
								);
}