'use strict';

// if (document.querySelector('.overlay')) {
//   var overlay = document.querySelectorAll('.overlay');
//   for (let i = 0; i < overlay.length; i++) {
//     overlay[i].onclick = function() {
//       let modal = this.closest('.modal-wrap');
//       modal.classList.remove('modal-active');
//     };
//   }
// }
//
// if(document.querySelector('.js-modal-btn')) {
//   let btns = document.querySelectorAll('.js-modal-btn');
//   for (let i = 0; i < btns.length; i++) {
//     let btn = btns[i];
//     btn.onclick = function() {
//       e.preventDefault();
//       let id = btn.dataset.id;
//       let modal = document.getElementById(id).closest('.modal-wrap');
//       modal.classList.add('modal-active');
//       if(this.closest('.js-modal')) {
//         let zIndex = getComputedStyle(this.closest('.modal-wrap')).zIndex;
//         modal.style.zIndex = zIndex + 1;
//       }
//     }
//   }
// }
//
// if (document.querySelector('.js-btn-close')) {
//   let btnModalClose = document.querySelectorAll('.js-btn-close');
//   for (let i = 0; i < btnModalClose.length; i++) {
//     let btn = btnModalClose[i];
//     btn.onclick = function() {
//       let modal = document.querySelector('.modal-active');
//       modal.classList.remove('modal-active');
//     };
//   }
// }
//
// if (document.querySelector('.tab')) {
//   let tabs = document.querySelectorAll('.tab');
//   for (let i = 0; i < tabs.length; i++) {
//     let tab = tabs[i];
//     tab.onclick = function() {
//       let id = this.dataset.id;
//       let target = document.getElementById(id);
//       let tabParent = this.closest('.tabs');
//       let targetParent = target.closest('.tab-content');
//       let tabActive = tabParent.querySelector('.tab-active');
//       let targetActive = targetParent.querySelector('.tab-item-active');
//       if (this !== tabActive) {
//         tabActive.classList.remove('tab-active');
//         this.classList.add('tab-active');
//       }
//       if (target !== targetActive) {
//         targetActive.classList.remove('tab-item-active');
//         target.classList.add('tab-item-active');
//       }
//     }
//   }
// }

if ($('.home__slider').length > 0) {
  $('.home__slider').slick({
    verticalSwiping: true,
    vertical: true,
    arrows: false,
    slidesToShow: 2,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [{
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
}

if ($('.home__form-select-js').length > 0) {
  $('.home__form-select-js').select2({
    placeholder: "Вакансии",
    minimumResultsForSearch: Infinity
  });
}

$(document).ready(function () {
  if ($('#sidebar').length > 0 && window.innerWidth > 993) {
    var stickySidebar = new StickySidebar('#sidebar', {
      topSpacing: 0,
      bottomSpacing: 20,
      containerSelector: '.v-content-bottom',
      innerWrapperSelector: '.sidebar-inner'
    });
  }

  if ($('#sidebar-vr').length > 0 && window.innerWidth > 993) {
    var stickySidebar = new StickySidebar('#sidebar-vr', {
      topSpacing: 0,
      bottomSpacing: 0,
      containerSelector: '.container-for-sidebar',
      innerWrapperSelector: '.sidebar-inner'
    });
  }

  if ($('#sidebar-single').length > 0 && window.innerWidth > 993) {
    var _stickySidebar = new StickySidebar('#sidebar-single', {
      topSpacing: 20,
      bottomSpacing: 20,
      containerSelector: '.single-block-slider',
      innerWrapperSelector: '.sidebar-inner'
    });
  }

  // $('.jsOpenCheck').next().hide();
  $('.jsOpenCheck').click(function () {
    stickySidebar.updateSticky();
    if ($(this).hasClass("open-services-mob")) {
      $(this).removeClass('open-services-mob').next().slideDown();
      $(this).find('.jsBtnPlus').toggleClass('btn-active');
      $(this).find('.jsBtnMinus').toggleClass('btn-active');
    } else {
      // $('.jsOpenCheck.open-services-mob').not(this).removeClass('open-services-mob').next().slideUp();
      $(this).addClass(' open-services-mob').next().slideUp();
      $(this).find('.jsBtnPlus').toggleClass('btn-active');
      $(this).find('.jsBtnMinus').toggleClass('btn-active');
    }
    if (window.innerWidth > 993) {
      stickySidebar.updateSticky();
    }
  });

  $('.jsShowContacts').click(function () {
    $('.jsOpenContacts').toggleClass('active-single-contacts');
    $('.jsHeaderIndex').css({ 'z-index': '3', 'transition': 'all ease .1s' });
  });
  $('.jsHideContacts').click(function () {
    $('.jsOpenContacts').removeClass('active-single-contacts');
    $('.jsHeaderIndex').css({ 'z-index': '8', 'transition': 'all ease 6s' });
    // $('.jsShowContactsFlag').css({'display': ('flex')});
  });

  $('.jsShowFilter').click(function () {
    $('.jsOpenFilter').addClass('active-filter');
    $('.jsFilterOverlay').addClass('active-filter-overlay').css({ 'transition': 'all ease 1s' });
    $('.jsShowFilter').css({ 'display': 'none', 'transition': 'all ease 0s' });
  });
  $('.jsHideFilter').click(function () {
    $('.jsOpenFilter').removeClass('active-filter');
    $('.jsFilterOverlay').removeClass('active-filter-overlay').css({ 'transition': 'all ease 0s' });
    $('.jsShowFilter').css({ 'display': 'block', 'transition': 'all ease 1s' });
  });
  $('.jsFilterOverlay').click(function () {
    $('.jsOpenFilter').removeClass('active-filter');
    $('.jsFilterOverlay').removeClass('active-filter-overlay').css({ 'transition': 'all ease 0s' });
    $('.jsShowFilter').css({ 'display': 'block', 'transition': 'all ease 1s' });
  });

  $('.jsLogin').click(function () {
    $('.jsModal').fadeIn();
    $('.jsModalLogin').fadeIn();
    $('body').addClass('body-overflow');
  });
  $('.jsRegForm').click(function () {
    $('.jsModalLogin').fadeOut(1);
    $('.jsModalReg').fadeIn();
  });
  $('.jsLoginForm').click(function () {
    $('.jsModalReg').fadeOut(1);
    $('.jsModalLogin').fadeIn();
  });
  $('.jsSendMessage').click(function () {
    $('.jsModal').fadeIn();
    $('.jsModalMessage').fadeIn();
    $('body').addClass('body-overflow');
  });
  $('.jsModalClose').click(function () {
    $('.jsModal').fadeOut();
    $('.jsModalLogin').fadeOut(1);
    $('.jsModalReg').fadeOut();
    $('.jsModalMessage').fadeOut();
    $('.jsBtn').prop('disabled', true);
    $('body').removeClass('body-overflow');
  });

  var nameTest = /^([A-Z])(.+)/;
  var mailTest = /^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/;
  var passTest = /^([A-Z])(.+)/;

  $('.jsModalLoginForm input').on('input', function () {
    var mail = $('.jsModalLoginForm .jsMail').val();
    var pass = $('.jsModalLoginForm .jsPass').val();
    if (mailTest.test(mail) && passTest.test(pass)) {
      $('.jsBtnLogin').prop('disabled', false);
    }
  });
  $('.jsModalRegForm input').on('input', function () {
    var name = $('.jsModalRegForm .jsName').val();
    var surname = $('.jsModalRegForm .jsSurname').val();
    var mail = $('.jsModalRegForm .jsMail').val();
    var pass = $('.jsModalRegForm .jsPass').val();
    if (mailTest.test(mail) && passTest.test(pass) && nameTest.test(name) && nameTest.test(surname)) {
      $('.jsBtnReg').prop('disabled', false);
    }
  });

  $('.jsOpenMenu').mouseenter(function () {
    $('.jsShowMenu').fadeIn().css('display', 'flex');
  });

  // $('.jsShowMenu').mouseleave(function () {
  //   $('.jsShowMenu').fadeOut();
  // });

  $('.jsMenu').mouseleave(function (e) {
    if (!$('.jsShowMenu').is(e.target) || !$('.jsOpenMenu').is(e.target)) {
      $('.jsShowMenu').fadeOut();
    }
  });

  $('.jsOpenNavMenu').click(function () {
    $('.jsOpenNavMenu').toggleClass('activeBtn');
    $('.jsNavMenu').toggleClass('active-nav');
    if ($('.jsNavOverlay').hasClass('active-filter-overlay')) {
      $('.jsNavOverlay').removeClass('active-filter-overlay').css('display', 'none');
    } else {
      $('.jsNavOverlay').addClass('active-filter-overlay').css('display', 'block');
    }
  });

  $('.jsNavOverlay').click(function () {
    $('.jsOpenNavMenu').toggleClass('activeBtn');
    $('.jsNavMenu').toggleClass('active-nav');
    $('.jsNavOverlay').toggleClass('active-filter-overlay').css('display', 'none');
  });
});

if ($('.jsCitiesSelect').length > 0) {
  $('.jsCitiesSelect').select2();
}
//# sourceMappingURL=script.js.map
