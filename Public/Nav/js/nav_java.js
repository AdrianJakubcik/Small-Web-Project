jQuery(document).ready(function($) {
    var secondaryNav = $('.cd-secondary-nav');
    //on mobile - open/close secondary navigation clicking/tapping the .cd-secondary-nav-trigger
    $('.cd-secondary-nav-trigger').on('click', function(event) {
        event.preventDefault();
        $(this).toggleClass('menu-is-open');
        secondaryNav.find('ul').toggleClass('is-visible');
    });

    //on mobile - open/close primary navigation clicking/tapping the menu icon
    $('.cd-primary-nav').on('click', function(event) {
        if ($(event.target).is('.cd-primary-nav')) $(this).children('ul').toggleClass('is-visible');
    });
});