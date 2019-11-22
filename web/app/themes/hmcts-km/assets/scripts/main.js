/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

  function TreeNav(options) {
    this.tree = $(options.tree);
    this.animateSpeed = (typeof options.animateSpeed === 'number') ? options.animateSpeed : 5000;

    this.init();
  }

  TreeNav.prototype = {
    init: function() {
      this.closeAllBranches();
      this.showActiveBranches();
      this.bindEvents();
      this.removeNoJsClasses();
    },
    removeNoJsClasses: function() {
      this.tree.removeClass('tree-no-js');
      this.tree.find('.has-active').removeClass('has-active');
    },
    closeAllBranches: function() {
      var _this = this;
      $(this.getAllBranches()).each(function(i, branch) {
        _this.closeBranch(branch);
      });
    },
    bindEvents: function() {
      var _this = this;
      $(this.getAllBranches()).each(function(i, branch) {
        $(branch).find('> .toggle-children')
            .on('click', function(e) {
              e.preventDefault();
              _this.toggleBranch(branch);
            });
      });
    },
    getBranches: function(rootBranch) {
      return $(rootBranch).find('li.has-children');
    },
    getAllBranches: function() {
      return this.getBranches(this.tree);
    },
    toggleBranch: function(branch) {
      var expanded = $(branch).attr('aria-expanded') === 'true';
      if (expanded) { this.closeBranchRecursively(branch, true); }
      else { this.openBranch(branch, true); }
    },
    openBranch: function(branch, animate) {
      var parent = $(branch),
          children = parent.find('> ul');
      animate = animate || false;

      parent.attr('aria-expanded', true).addClass('expanded');
      children.attr('hidden', false).removeClass('hidden');
      if (animate) { children.hide().slideDown(this.animateSpeed); }
    },
    closeBranch: function(branch, animate, oncomplete) {
      var parent = $(branch),
          children = parent.find('> ul');
      animate = animate || false;

      parent.attr('aria-expanded', false).removeClass('expanded');

      var hide = function() {
        children.attr('hidden', true).addClass('hidden');
        if (typeof oncomplete !== 'undefined') { oncomplete(); }
      };

      if (animate) { children.slideUp(this.animateSpeed, hide); }
      else { hide(); }
    },
    showActiveBranches: function() {
      var _this = this;
      var active = this.tree.find('.active');
      active.each(function(i, li) {
        _this.openBranchUpwards(li);
      });
    },
    openBranchUpwards: function(childBranch) {
      var _this = this;
      var parents = $(childBranch).parentsUntil(this.tree, 'li');
      this.openBranch(childBranch);
      parents.each(function(i, branch) {
        _this.openBranch(branch);
      });
    },
    closeBranchRecursively: function(parentBranch) {
      var _this = this;
      var children = this.getBranches(parentBranch);
      this.closeBranch(parentBranch, true, function() {
        children.each(function(i, branch) {
          _this.closeBranch(branch);
        });
      });
    }
  };

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        new TreeNav({
          tree: $('.tree'),
          animateSpeed: 150
        });

        $('.sidebar-toggle').on('click', function(e) {
          e.preventDefault();
          $(this).toggleClass('open');
          $('.sidebar').toggleClass('visible');
          $('body').toggleClass('no-scroll');
        });
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
