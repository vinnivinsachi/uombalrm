// JavaScript Document

var bs={};

currentBannerIndex=1;
maxBannerNumber=0;
Event.observe(
			  window,
			  'load',
			  function(){
				  bs.banner=$('banner');
				  bs.bannerImages=$('bannerImageSlide').getElementsByTagName('img');
				  
				  maxBannerNumber=bs.bannerImages.length;
				  
				  hideAllBanners();
				  
			  }
			  );

function hideAllBanners(){
	

	
	//alert('there are '+maxBannerNumber+' banners');	
	
		$A(bs.bannerImages).each(
						 function(value,index){
							 if(index!=0){
							 	Element.hide(value);
							 }
						 }
						 );
		
	Element.removeClassName(bs.banner,'hidden');

	
	var peridocial = new PeriodicalExecuter(bannerSlide, 8);
}


function bannerSlide()
{
	
	
	if(currentBannerIndex< maxBannerNumber)
	{
		$A(bs.bannerImages).each(
								 function(value,index){
									 if(currentBannerIndex!=index)
									 {
										 Element.hide(value);
									 }
								 }
								 );
		
		new Effect.Appear(bs.bannerImages[currentBannerIndex], {duration:2, from:0.0, to:1.0});
		currentBannerIndex++;
	}
	else{
		currentBannerIndex=0;
		$A(bs.bannerImages).each(
								 function(value,index){
									 if(currentBannerIndex!=index)
									 {
										 Element.hide(value);
									 }
								 }
								 );
		new Effect.Appear(bs.bannerImages[currentBannerIndex], {duration:2, from:0.0, to:1.0});

		currentBannerIndex++;
	}
}

