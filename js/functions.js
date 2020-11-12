/* global jQuery */
(function ($) {
    var masthead, menuToggle, siteNavigation, siteHeaderMenu;

    function initMainNavigation(container) {
        // Add dropdown toggle that displays child menu items.
        var dropdownToggle = $('<button />', {
            'class': 'dropdown-toggle',
            'aria-expanded': false,
        });

        container.find('ul ul .menu-item-has-children > a').after(dropdownToggle);

        // Toggle buttons and submenu items with active children menu items.
        container.find('.current-menu-ancestor > button').addClass('toggled-on');
        container.find('.current-menu-ancestor > .children, .current-menu-ancestor > .sub-menu').addClass('toggled-on');

        // Add menu items with submenus to aria-haspopup="true".
        container.find('.menu-item-has-children').attr('aria-haspopup', 'true');

        container.on('click', '.dropdown-toggle', function (e) {
            var _this = $(this);

            e.preventDefault();
            _this.toggleClass('toggled-on');
            _this.next('.children, .sub-menu').toggleClass('toggled-on');

            _this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');
        });
    }

    initMainNavigation($('.main-navigation'));

    masthead = $('#masthead');
    menuToggle = masthead.find('#header-dropdown-toggle');
    siteNavigation = masthead.find('.header-dropdown');

    // Enable menuToggle.
    (function () {
        // Return early if menuToggle is missing.
        if (!menuToggle.length) {
            return;
        }

        // Add an initial values for the attribute.
        menuToggle.add(siteNavigation).attr('aria-expanded', 'false');

        menuToggle.on('click', function () {
            $('body').toggleClass('menu-opened');
            $(this).add(siteNavigation).toggleClass('toggled-on');
            $(this).add(siteNavigation).attr('aria-expanded', $(this).add(siteNavigation).attr('aria-expanded') === 'false' ? 'true' : 'false');
        });

        var focusable = siteNavigation.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'),
            lastFocusable = focusable[focusable.length - 1];

        siteNavigation.on('keydown', function (event) {
            var tabKey = event.keyCode === 9,
                shiftKey = event.shiftKey;
            if(!shiftKey && tabKey && lastFocusable === document.activeElement){
                event.preventDefault();
                menuToggle.focus();
            }
        })

    })();

    $("a").on('click', function (event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 500, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });

    function initFPSlider() {
        var fpSlider = $('#front-page-slider');

        if (!$.fn.slick) {
            return;
        }

        fpSlider.slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            draggable: false,
            fade: Boolean(fpSlider.data('fade')),
            speed: fpSlider.data('speed'),
            autoplay: Boolean(fpSlider.data('autoplay')),
            autoplaySpeed: fpSlider.data('autoplayspeed'),
            dots: false,
            arrows: false,
            rows: 0,
        });

        fpSlider.find('.fp-slider-next').on('click', function () {
            fpSlider.slick('slickNext');
        });

        fpSlider.find('.fp-slider-prev').on('click', function () {
            fpSlider.slick('slickPrev');
        });

        fpSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var cls = 'slick-current slick-active';

            if (nextSlide == 0) {
                setTimeout(function () {
                    $('[data-slick-index="' + slick.$slides.length + '"]').addClass(cls).siblings().removeClass(cls);
                    for (var i = slick.options.slidesToShow - 1; i >= 0; i--) {
                        $('[data-slick-index="' + i + '"]').addClass(cls);
                    }
                }, 1);
            }

            if (nextSlide === slick.$slides.length - 1) {
                setTimeout(function () {
                    $('[data-slick-index="' + nextSlide + '"]').addClass(cls).siblings().removeClass(cls);
                    for (var i = -1; i >= -1 * slick.options.slidesToShow; i--) {
                        $('[data-slick-index="' + i + '"]').addClass(cls);
                    }
                }, 1);
            }
        });
    }

    initFPSlider();

    function subMenuPosition() {
        $('.header-menu-wrapper .sub-menu').each(function () {
            $(this).removeClass('toleft');
            if (($(this).parent().offset().left + $(this).parent().width() - $(window).width() + 200) > 0) {
                $(this).addClass('toleft');
            }
        });
    }

    function prependElement(container, element) {
        if (container.firstChild) {
            return container.insertBefore(element, container.firstChild);
        } else {
            return container.appendChild(element);
        }
    }

    function showButton(element) {
        // classList.remove is not supported in IE11
        element.className = element.className.replace('is-empty', '');
    }

    function hideButton(element) {
        // classList.add is not supported in IE11
        if (!element.classList.contains('is-empty')) {
            element.className += ' is-empty';
        }
    }

    function getAvailableSpace(button, container) {
        return container.offsetWidth - button.offsetWidth - 30;
    }

    function isOverflowingNavivation(list, button, container) {
        return list.offsetWidth > getAvailableSpace(button, container);
    }

    function addItemToVisibleList(toggleButton, container, visibleList, hiddenList) {
        if (getAvailableSpace(toggleButton, container) > breaks[breaks.length - 1]) {
            // Move the item to the visible list
            visibleList.appendChild(hiddenList.firstChild);
            breaks.pop();
            addItemToVisibleList(toggleButton, container, visibleList, hiddenList);
        }
    }


    var navContainer = document.querySelector('.header-menu-wrapper');
    var breaks = [];

    function updateNavigationMenu(container) {

        if (!container.parentNode.querySelector('.header-menu[id]')) {
            return;
        }

        // Adds the necessary UI to operate the menu.
        var visibleList = container.parentNode.querySelector('.header-menu[id]');
        var hiddenList = visibleList.parentNode.nextElementSibling.querySelector('.hidden-links');
        var toggleButton = visibleList.parentNode.nextElementSibling.querySelector('.primary-menu-more-toggle');

        if (isOverflowingNavivation(visibleList, toggleButton, container)) {
            // Record the width of the list
            breaks.push(visibleList.offsetWidth);
            // Move last item to the hidden list
            prependElement(hiddenList, !visibleList.lastChild || null === visibleList.lastChild ? visibleList.previousElementSibling : visibleList.lastChild);
            // Show the toggle button
            showButton(toggleButton);

        } else {

            // There is space for another item in the nav
            addItemToVisibleList(toggleButton, container, visibleList, hiddenList);

            // Hide the dropdown btn if hidden list is empty
            if (breaks.length < 2) {
                hideButton(toggleButton);
            }

        }

        // Recur if the visible list is still overflowing the nav
        if (isOverflowingNavivation(visibleList, toggleButton, container)) {
            updateNavigationMenu(container);
        }

    }

    if (navContainer) {

        document.addEventListener('DOMContentLoaded', function () {

            updateNavigationMenu(navContainer);

            // Also, run our priority+ function on selective refresh in the customizer
            var hasSelectiveRefresh = (
                'undefined' !== typeof wp &&
                wp.customize &&
                wp.customize.selectiveRefresh &&
                wp.customize.navMenusPreview.NavMenuInstancePartial
            );

            if (hasSelectiveRefresh) {
                // Re-run our priority+ function on Nav Menu partial refreshes
                wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {

                    var isNewNavMenu = (
                        placement &&
                        placement.partial.id.includes('nav_menu_instance') &&
                        'null' !== placement.container[0].parentNode &&
                        placement.container[0].parentNode.classList.contains('main-navigation')
                    );

                    if (isNewNavMenu) {
                        updateNavigationMenu(placement.container[0].parentNode);
                    }
                });
            }
        });

        window.addEventListener('load', function () {
            updateNavigationMenu(navContainer);
            subMenuPosition();
        });

        var timeout;

        window.addEventListener('resize', function () {
            function checkMenu() {
                if (timeout) {
                    clearTimeout(timeout);
                    timeout = undefined;
                }

                timeout = setTimeout(
                    function () {
                        updateNavigationMenu(navContainer);
                        subMenuPosition();
                    },
                    100
                );
            }

            checkMenu();
            subMenuPosition();
        });

        updateNavigationMenu(navContainer);
        subMenuPosition();
    }

    function initRoomsSliders() {
        $('.mphb_sc_rooms-wrapper.slider .rooms-wrapper').slick({
            infinite: true,
            slidesToShow: 3,
            fade: false,
            speed: 1000,
            autoplay: true,
            autoplaySpeed: 4000,
            dots: false,
            arrows: false,
            rows: 0,
            swipeToSlide: true,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                },
            ]
        })
    }

    initRoomsSliders();

    $(window).on('elementor/frontend/init', function (e) {
        elementorFrontend.hooks.addAction('frontend/element_ready/image-carousel.default', function ($scope) {
            if (!$scope.hasClass('autowidth-image-carousel')) {
                return;
            }
            elementorFrontend.on('components:init', function () {
                var slider = $scope.find('.elementor-image-carousel-wrapper')[0].swiper;

                slider.params.slidesPerView = 'auto';
                slider.params.loop = false;
                slider.params.freeMode = true;

                $scope.find('.swiper-slide').css('width', 'auto');
                slider.update();
            });
        });
    })


    $('.primary-menu-more-toggle').on('focus blur', function () {
        $(this).parent().toggleClass('opened');
    });

    $('.header-menu-wrapper a').on('focus blur', function () {
        var element = $(this);

        while (!element.hasClass('nav-menu')) {
            // console.log(element);
            if ('li' === element.get(0).tagName.toLowerCase()) {
                element.toggleClass('focus');
            }
            element = element.parent();
        }
    });

}(jQuery));