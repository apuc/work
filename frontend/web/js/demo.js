(function(){

  // handle the swanky navigation/section stuff
  ////////////////////////////////////////////////////////////

  var nav_links = document.querySelectorAll("nav.cmn-overlays-nav a");
    
  /* loop through all nav links */
  [].slice.call(nav_links).forEach(function(el, i) {
    
    /* fetch vars */
    var href = el.getAttribute("href"),
        id = href.substr(1),
        section = document.querySelector(href),
        close = section.querySelector("a.close");

    /* listen for nav clicks */
    el.addEventListener("click", function(e) {
      e.preventDefault();
      if (!classie.has(section, "active")) {
        classie.add(section, "active");
      }
    });

    /* listen for close clicks on the mask */
    section.addEventListener("click", function(e) {
      e.preventDefault();
      if (e.target.tagName == "SECTION") {
        removeModalWindow();
      }
    });

    /* listen for close clicks on the close button */
    close.addEventListener("click", function(e) {
      e.preventDefault();
      removeModalWindow();
      // if (classie.has(section, "active")) {
      //   classie.remove(section, "active");
      //   $('.section_modal').removeClass('active');
      // }
    });

    const removeModalWindow = () => {
      $('.section_modal').removeClass('active');
    };

  });

})();

