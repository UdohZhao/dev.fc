$(function(){


// var mySwiper = new Swiper('.swiper-container', {
//     speed: 400,
//     spaceBetween: 100
// });   

 $(".swiper-container").swiper(mySwiper)
	var mySwiper = new Swiper('.swiper-container', {
	    // speed: 1000,
	    // spaceBetween: 100,
	    // direction: 'horizontal',
	    // autoplay: 1500,
	    // allowSwipeToPrev: true,
	    // keyboardControl: true,
	    // allowSwipeToNext: true,
	    // noSwiping: true,
	    // noSwipingClass: true,
	    // mode:'vertical', 




      loop:true,//无缝衔接滚动
      autoplay:3000,
      autoplayDisableOnInteraction:false,//用户操作swiper之后不禁止autoplay
      slidesPerView: 'auto',
      centeredSlides: true

	});  


});

function ePass(id,type){

	window.location.href="/recreation/index/id/"+id+"/type/"+type;


}

