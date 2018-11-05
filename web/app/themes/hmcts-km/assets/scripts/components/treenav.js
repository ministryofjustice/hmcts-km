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
