{literal}

<title>U Of M Ballroom Photos</title>

<style type="text/css">
.galleria{list-style:none;width:200px}
.galleria li{display:block;width:80px;height:80px;overflow:hidden;float:left;margin:0 10px 10px 0}
.galleria li a{display:none}
.galleria li div{position:absolute;display:none;top:0;left:180px}
.galleria li div img{cursor:pointer}
.galleria li.active div img,.galleria li.active div{display:block}
.galleria li img.thumb{cursor:pointer;top:auto;left:auto;display:block;width:auto;height:auto}
.galleria li .caption{display:block;padding-top:.5em}
* html .galleria li div span{width:400px} /* MSIE bug */
</style>


<body>

<script type="text/javascript">

// load first image
window.location = String(window.location.href.split('#')[0]+'#{/literal}{$photos[0]}{literal}').replace('##','#');

$(document).ready(function() {

	//prevent anchor browse default
	$('a.browse').click(function(e){e.preventDefault()});
	
 	$('ul.gallery_demo_unstyled li:first-child img').attr('onload','$("#loadingImg").hide()');
 
    $('.gallery_demo_unstyled').addClass('gallery_demo'); // adds new class name to maintain degradability
   
    $('ul.gallery_demo').galleria({
        history   : true, // activates the history object for bookmarking, back-button etc.
        clickNext : true, // helper for making the image clickable
        insert    : '#main_image', // the containing selector for our main image
        onImage   : function(image,caption,thumb) { // let's add some image effects for demonstration purposes
       
            // fade in the image & caption
            if(! ($.browser.mozilla && navigator.appVersion.indexOf("Win")!=-1) ) { // FF/Win fades large images terribly slow
                image.css('display','none').fadeIn(1000);
            }
            caption.css('display','none').fadeIn(1000);
           
            // fetch the thumbnail container
            var _li = thumb.parents('li');
           
            // fade out inactive thumbnail
            _li.siblings().children('img.selected').fadeTo(500,0.3);
           
            image.css('margin-top', ($('#main_image').height()/2 - image.height()/2));
           
            // fade in active thumbnail
            thumb.fadeTo('fast',1).addClass('selected');
           
            // add a title for the clickable image
            image.attr('title','Next image >>');
        },
        onThumb : function(thumb) { // thumbnail effects goes here
           
            // fetch the thumbnail container
            var _li = thumb.parents('li');
           
            // if thumbnail is active, fade all the way.
            var _fadeTo = _li.is
 
('.active') ? '1' : '0.3';
           
            // fade in the thumbnail when finnished loading
            thumb.css({display:'none',opacity:_fadeTo}).fadeIn(1500);
           
            // hover effects
            thumb.hover(
                function() { thumb.fadeTo('fast',1); },
                function() { _li.not('.active').children('img').fadeTo('fast',0.3); } // don't fade out if the parent is active
            )
        }
    });
   
    // initialize scrollable
    $(".scrollable").scrollable({
                            size:9,
                            easing:'swing'
                            }).mousewheel().navigator();
});
</script>
   
<style media="screen,projection" type="text/css">

/* BEGIN DEMO STYLE */
* {
    margin:0;
    padding:0
}



h1,h2 {
    font:bold 80% 'helvetica neue',sans-serif;
    letter-spacing:3px;
    text-transform:uppercase;
}

a {
    color:#348;
    text-decoration:none;
    outline:none;
}

a:hover {
    color:#67a;
}

.caption {
    font-style:italic;
    color:#887;
}

.demo {
    position:relative;
    margin-top:2em;
}

.gallery_demo {
    width:780px;
    margin:0 auto;
}

.gallery_demo li {
    width:68px;
    height:50px;
    border:3px double #111;
    margin: 0 2px;background:#000;
}

.gallery_demo li div {
    left:240px;
}
.gallery_demo li div .caption {
    font:italic 0.7em/1.4 georgia,serif;
}

#main_image {
    margin:0 auto 60px auto;
    height:438px;
    width:700px;
    background:black;
}

#main_image img {
    margin-bottom:10px;
    max-height:438px;
}

.nav {
    padding-top:15px;
    clear:both;
    font:80% 'helvetica neue',sans-serif;
    letter-spacing:3px;
    text-transform:uppercase;
}

.info {
    text-align:left;
    width:700px;
    margin:30px auto;
    border-top:1px dotted #221;
    padding-top:30px;
}

.info p {
    margin-top:1.6em;
}

/*
root element for the scrollable.
when scrolling occurs this element stays still.
*/
div.scrollable {
    /* required settings */
    position:relative;
    overflow:hidden;
    width: 700px;
    height:90px;
}

/*
    root element for scrollable items. Must be absolutely positioned
    and it should have a extremely large width to accomodate scrollable items.
    it's enough that you set width and height for the root element and
    not for this element.
*/
div.scrollable ul.items {
    /* this cannot be too large */
    width:20000em;
    position:absolute;
}
 
/*
    a single item. must be floated in horizontal scrolling.
    typically, this element is the one that *you* will style
    the most.
*/
div.scrollable ul.items div {
    float:left;
}
 
/* you may want to setup some decorations to active the item */
ul.items div.active {
    border:1px inset #ccc;
    background-color:#fff;
}
</style>
{/literal}

<h1>{$galleryTitle}</h1>
<div class="demo" align="center">
<table>
<tr>
<td>
<div id="main_image" align="center">
<img id="loadingImg" src="/data/images/loading.gif" /></div>
</td>
</tr>
<tr>
<td align="center">
<div class="navi"></div>
<div style="float:left; margin:15px 5px 0px 0px; font-weight:bold;"><a href="#" class="prevPage browse left">&lt;&lt;</a></div>
<div class="scrollable" style="float:left;">
<ul class="gallery_demo_unstyled items">

{foreach from=$photos item=photo}
<li><img src="{$photo}"></li>
{/foreach}

</ul>
</div>
<div style="float:left; margin:15px 0px 0px 5px; font-weight:bold;"><a href="#" class="nextPage browse right">&gt;&gt;</a></div>
<p class="nav"><a href="#" onClick="$.galleria.prev(); return false;">&laquo; previous</a> | <a href="#" onClick="$.galleria.next(); return false;">next &raquo;</a></p>
</td>
</tr>
</table>
</div>