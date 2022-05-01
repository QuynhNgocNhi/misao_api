import 'owl.carousel'
var CarDetail = {
  init() {
    this.carMediaHover()
  },
  carMediaHover(){
    $(".image-thumbs .item").hover(function(){
      var src = $(this).find('img').attr("src");
      // $(this).addClass("active").siblings().removeClass("active");
      $(".js-image-main").attr("src",src);
    });

    $('.js-scroll-left').on('click', function (){
      event.preventDefault();
      $('.image-thumbs').animate({
        scrollLeft: "-=100px"
      });
    });
    $('.js-scroll-right').on('click', function (){
      event.preventDefault();
      $('.image-thumbs').animate({
        scrollLeft: "+=100px"
      });
    });
  }
}
export default CarDetail
