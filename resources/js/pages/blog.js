import 'owl.carousel'
var Blog = {
  init() {
    this.blogOwl()
  },
  blogOwl() {
    $('.blog-owl').owlCarousel({
      lazyLoad: true,
      startPosition: 0,
      items: 1,
      loop: true,
      margin: 25,
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
          items: 3,
        },
        1000: {
          items: 4,
        },
      },
    })
  },
}
export default Blog
