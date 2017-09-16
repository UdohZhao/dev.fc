$(function(){

    // 初始化幻灯片
    $(".swiper-container").swiper({
        pagination: '.swiper-pagination',
        paginationClickable: true,
        speed: 2000,
        loop: true,
        observer:true,
        observeParents:true,
        autoplayDisableOnInteraction : false,
        autoplay:3000,
        spaceBetween: 30
    });

})