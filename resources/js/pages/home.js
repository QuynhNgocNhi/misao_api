import 'owl.carousel'
var Home = {
  init() {
    this.bannerOwl()
  },
  bannerOwl() {
    $('.banner-owl').owlCarousel({
      lazyLoad: true,
      startPosition: 0,
      loop: true,
      autoplay: false,
      autoplayTimeout: 6000,
      autoplayHoverPause: false,
      nav: true,
      dots: true,
      responsive: {
        0: {
          items: 1,
        },
        600: {
          items: 2,
        },
        1000: {
          items: 2,
        },
      },
    })
  },
}
export default Home
