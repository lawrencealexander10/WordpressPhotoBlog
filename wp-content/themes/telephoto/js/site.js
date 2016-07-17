$(document).ready(function() {
  $("#site-navigation").sticky({
    topSpacing: 0
  });
  $('#site-navigation').on('sticky-start', function() {
    $('#small-logo').css('display', 'inline-block');
    $('#site-navigation').addClass('responsive-head');
  });
  $('#site-navigation').on('sticky-end', function() {
    $('#small-logo').css('display', 'none');
    $('#site-navigation').removeClass('responsive-head');
  });
  $('.menu-link').bigSlide();
  $('#mobile-xc').bigSlideXC();
  $('.first-row').click(function() {
    $('#nav-search-left').toggle();
  });

  $('.popup').click(function(event) {
    var width = 575,
      height = 400,
      left = ($(window).width() - width) / 2,
      top = ($(window).height() - height) / 2,
      url = this.href,
      opts = 'status=1' +
      ',width=' + width +
      ',height=' + height +
      ',top=' + top +
      ',left=' + left;

    window.open(url, 'twitter', opts);

    return false;
  });


});


$(window).load(function() {
      setTimeout(function() {
      $('#loading').fadeOut(1000);
      $(".sticky-footer-wrapper").animate({
        opacity: 1
        }, 1200);
    },200);
});