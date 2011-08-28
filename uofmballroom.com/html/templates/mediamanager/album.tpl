{include file='header.tpl' lightbox=true}

<div id='albumTitle' class='albumBox'>
	<div>Directory</div>
</div>

<div id="albumLeftContainer">
<div class='smallText'>Available Folders</div>
<div id='albumFolders' class="albumBox">
</div>
<div class='smallText'>Current Images</div>


<div id='albumImages' class="albumBox">
</div>

<div class='smallText'>Available Slideshows</div>
<div id='albumSlideshows' class="albumBox">
No available slideshows

</div>

</div>


<div id='albumCloseup' class='albumBox'>
<img id="albumCloseup_img"></img>
</div>








<div id="albumRightSide">
Title of slide show<br/>
<input type='text' id='albumSlideshowName' class="albumBox" ></input>

<div id="albumSlides" class="albumBox "><!--this shows up on the right side of the page-->
Drag image to this section to edit slide show

</div>

<div id="albumTrash" class="albumBox" title='drag images here to remove from slideshow'>
Here is the trash can. Drag images from the slide show to this trash can to delete them.
</div>

</div>

<div id="albumBackdrop" class="hidden">
	<div id="albumBackdropLoading">Album is loading: please be patient. Thank you! :0)</div>
</div>

<div id="albumLiveSlides" class="hidden">
	<div id="albumSlidetools" style="float:right;">
    	<div id="albumStopshow"><img src="" /></div>
    </div>
</div>


{include file='footer.tpl'}