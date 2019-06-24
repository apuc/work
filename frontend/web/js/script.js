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
    arrows: true,
    prevArrow: '<button type="button" class="prevSlickHome"><img src="/images/arrow-down.svg"></button>',
    nextArrow: '<button type="button" class="nextSlickHome"><img src="/images/arrow-up.svg"></button>',
    slidesToShow: 3,
    autoplay: true,
    autoplaySpeed: 2000,
    responsive: [{
      breakpoint: 1500,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 992,
      settings: {
        arrows: false,
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 576,
      settings: {
        arrows: false,
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

if ($('.jsModalSelectResume').length > 0) {
  $('.jsModalSelectResume').select2({
    placeholder: "Выберите вакансию",
    minimumResultsForSearch: Infinity
  });
}

if ($('.jsModalSelectVacancy').length > 0) {
  $('.jsModalSelectVacancy').select2({
    placeholder: "Выберите резюме",
    minimumResultsForSearch: Infinity
  });
}

$(document).ready(function () {

  if ($('#sidebar').length > 0 && window.innerWidth > 993) {
    let stickySidebar = new StickySidebar('#sidebar', {
      topSpacing: 0,
      bottomSpacing: 20,
      containerSelector: '.v-content-bottom',
      innerWrapperSelector: '.sidebar-inner',
      resizeSensor: true
    });
  }

  if ($('#sidebar-vr').length > 0 && window.innerWidth > 993) {
    let stickySidebar = new StickySidebar('#sidebar-vr', {
      topSpacing: 0,
      bottomSpacing: 0,
      containerSelector: '.container-for-sidebar',
      innerWrapperSelector: '.sidebar-inner',
      resizeSensor: true
    });
  }

  if ($('#sidebar-single').length > 0 && window.innerWidth > 993) {
    let stickySidebar = new StickySidebar('#sidebar-single', {
      topSpacing: 20,
      bottomSpacing: 20,
      containerSelector: '.single-block-slider',
      innerWrapperSelector: '.sidebar-inner',
      resizeSensor: true
    });
  }

  $('.jsOpenCheck').click(function () {
    if ($(this).hasClass("open-services-mob")) {
      $(this).removeClass('open-services-mob').next().slideDown();
      let qw = $(this).find('.jsBtnPlus');
      let qwe = $(this).find('.jsBtnMinus');
      setTimeout(function () {
        qw.toggleClass('btn-active');
      },250);
      setTimeout(function () {
        qwe.toggleClass('btn-active');
      },250);
    } else {
      $(this).addClass(' open-services-mob').next().slideUp();
      let qw = $(this).find('.jsBtnPlus');
      let qwe = $(this).find('.jsBtnMinus');
      setTimeout(function () {
        qw.toggleClass('btn-active');
      },250);
      setTimeout(function () {
        qwe.toggleClass('btn-active');
      },250);
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
  var modalActive = $('.jsActive');
  if(modalActive.length>0){
    $('.jsModal').fadeIn();
    $('.jsModalSuccess').fadeIn();
    $('body').addClass('body-overflow');
  }
  $('.jsRegForm').click(function () {
    $('.jsModalLogin').fadeOut(1);
    $('.jsModalReg').fadeIn();
  });
  $('.jsLoginForm').click(function () {
    $('.jsModalReg').fadeOut(1);
    $('.jsModalLogin').fadeIn();
  });
  $('.jsSendMessage').click(function () {
    var resume_id=$(this).attr('data-id');
    if(resume_id!==undefined)
      $("input[name=resume_resume_id]").val(resume_id);
    $('.jsModal').fadeIn();
    $('.jsModalMessage').fadeIn();
    $('body').addClass('body-overflow');
  });
  $('.jsVacancyModal').click(function () {
    var vacancy_id=$(this).attr('data-id');
    if(vacancy_id!==undefined)
      $("input[name=vacancy_vacancy_id]").val(vacancy_id);
    $('.jsModal').fadeIn();
    $('.jsModalMessageVacancy').fadeIn();
    $('body').addClass('body-overflow');
  });
  $('.jsModalClose').click(function () {
    $('.jsModal').fadeOut();
    $('.jsModalLogin').fadeOut(1);
    $('.jsModalReg').fadeOut();
    $('.jsModalMessage').fadeOut();
    $('.jsModalMessageVacancy').fadeOut();
    $('.jsModalSuccess').fadeOut();
    $('body').removeClass('body-overflow');
  });

  if(window.innerWidth > 1251) {
    $('.jsOpenMenu').mouseenter(function () {
      $('.jsShowMenu').fadeIn().css('display', 'flex');
    });

    $('.jsMenu').mouseleave(function (e) {
      if (!$('.jsShowMenu').is(e.target) || !$('.jsOpenMenu').is(e.target)) {
        $('.jsShowMenu').fadeOut();
      }
    });
  }

  $('.jsOpenNavMenu').click(function () {
    $('.jsOpenNavMenu').toggleClass('activeBtn');
    $('.jsNavMenu').toggleClass('active-nav');
    if($('.jsNavOverlay').hasClass('active-filter-overlay')) {
      $('.jsNavOverlay').removeClass('active-filter-overlay').css('display', 'none');
      $('.jsNavMenu').removeClass('active-nav');
      $('.jsShowMenu').removeClass('active-nav-drop');
    } else {
      $('.jsNavOverlay').addClass('active-filter-overlay').css('display', 'block');
    }
  });

  if(window.innerWidth < 1250) {
    $('.jsOpenMenu').click(function () {
      $('.jsNavMenu').toggleClass('active-nav');
      $('.jsShowMenu').toggleClass('active-nav-drop');
    });
  }

  $('.jsMenuPrev').click(function () {
    $('.jsNavMenu').toggleClass('active-nav');
    $('.jsShowMenu').toggleClass('active-nav-drop');
  });

  $('.jsNavOverlay').click(function () {
    $('.jsOpenNavMenu').removeClass('activeBtn');
    $('.jsNavMenu').removeClass('active-nav');
    $('.jsShowMenu').removeClass('active-nav-drop');
    $('.jsNavOverlay').removeClass('active-filter-overlay').css('display', 'none')
  });
  if($('#jsInitialTab').val()==='login'){
    $('.jsLogin').click();
  }
  if(window.innerWidth < 575 && $('.scroll').length > 0 && window.pageYOffset < 300) {
    $('html, body').animate({
      scrollTop: $(".scroll").offset().top-50
    }, 2000);
  }
});

if ($('.jsCitiesSelect').length > 0) {
  $('.jsCitiesSelect').select2();
}
//# sourceMappingURL=script.js.map
