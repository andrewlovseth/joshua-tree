(function ($, window, document, undefined) {
    $(document).ready(function ($) {
        // rel="external"
        $('a[rel="external"]').click(function () {
            window.open($(this).attr("href"));
            return false;
        });

        // Nav Trigger
        $(".js-nav-trigger").click(function () {
            $("body").toggleClass("nav-overlay-open");
            return false;
        });

        // Search Trigger
        $(".js-search-trigger").click(function () {
            $("body").toggleClass("search-overlay-open");
            return false;
        });

        // Smooth Scroll Links
        $(".smooth").smoothScroll();

        // Mobile Nav Dropdown Toggle
        $(".mobile-nav .dropdown .section-header").on("click", function () {
            let subnav = $(this).attr("href");
            let dropdown = $(this).closest(".dropdown");

            $(subnav).slideToggle(400).toggleClass("active");
            $(dropdown).toggleClass("active");

            return false;
        });

        // Tab Links
        $(".tab-links a").on("click", function () {
            $(".tab-links a").removeClass("active");
            $(this).addClass("active");

            var tab_target = $(this).attr("href");
            $(".tab").removeClass("active");
            $(tab_target).addClass("active");

            return false;
        });

        // Our Work Nav
        $(".link-our-work").on("click", function () {
            const headerHeight = $(".site-header").outerHeight();
            $(".work-nav").css("min-height", `calc(100vh - ${headerHeight}px)`);
            $(".work-nav").toggleClass("active");
            $("body").toggleClass("overflow-hidden");

            return false;
        });

        // Homepage / Featured Projects Slider
        $(".js-featured-projects-slider").slick({
            dots: true,
            arrows: true,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 10000,
            adaptiveHeight: false,
        });

        if ($(".js-featured-projects-slider").length > 0) {
            const arrows = $(".slick-arrow"),
                slide = $(".js-featured-projects-slider .project:first-of-type .photo");

            let slideHeight = slide.height();

            $(arrows).css("height", slideHeight);
        }

        // Markets / Featured Projects Slider
        $(".projects-slider").slick({
            dots: true,
            arrows: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 6000,
        });

        $(".news-slider").slick({
            dots: true,
            arrows: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 6000,
        });

        $(".testimonial__slider").slick({
            dots: true,
            arrows: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 8000,
        });

        // Markets / More Projects Slider
        $(".more-projects-slider").slick({
            dots: false,
            arrows: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: false,
            mobileFirst: true,
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                    },
                },
            ],
        });

        // Leadership Slider
        $(".js-leadership-gallery").slick({
            dots: false,
            arrows: true,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 6000,
        });

        // JEDI Slider
        $(".js-jedi-gallery").slick({
            dots: false,
            arrows: true,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 6000,
            slidesToShow: 3,
            slidesToScroll: 1,
        });

        // Markets / More Projects Slider
        $(".services-gallery-slider").slick({
            dots: false,
            arrows: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: false,
        });

        // Emerging Tech / Case Studies Slider
        (function () {
            const $slider = $(".case-study-slider");
            if (!$slider.length) return;

            const $title = $(".et-case-studies-slide-title");
            const $counter = $(".et-case-studies-header-counter .counter-number");
            const $dotsHost = $(".et-case-studies-header-nav");

            const syncHeader = function (idx) {
                const $slide = $slider.find('.case-study-slide[data-slick-index="' + idx + '"]');
                if ($slide.length) {
                    $title.text($slide.attr("data-title") || "");
                }
                $counter.text(idx + 1);
            };

            $slider.on("init", function (e, slick) {
                syncHeader(slick.currentSlide);
            });

            $slider.on("afterChange", function (e, slick, currentSlide) {
                syncHeader(currentSlide);
            });

            $slider.slick({
                dots: true,
                arrows: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                adaptiveHeight: true,
                fade: false,
                appendDots: $dotsHost,
            });
        })();
        +(
            //JEDI: Tabs
            $(".jedi-tabs__link").on("click", function () {
                let section = $(this).attr("href");

                $(".jedi-tab-sections__item").removeClass("active");
                $(section).addClass("active");

                $(".jedi-tabs__link").removeClass("active");
                $(this).addClass("active");

                return false;
            })
        );

        //Clients: Tabs
        $(".client-tabs a").on("click", function () {
            let section = $(this).attr("href");

            $(".client-type").removeClass("active");
            $(section).addClass("active");

            $(".client-tabs a").removeClass("active");
            $(this).addClass("active");

            return false;
        });

        // Clients: Projects Toggle
        $(".client.has-projects .name").on("click", function () {
            let projects = $(this).siblings(".projects");
            $(projects).toggle();

            $(this).toggleClass("active");
        });

        let clearBtn = document.getElementById("alm-filters-reset-button");
        $(clearBtn).on("click", function (e) {
            almfilters.reset();
            $(".alm-filter--select select option").prop("selected", function () {
                return this.defaultSelected;
            });
        });

        // JEDI timeline
        $(".js-progress-timeline").slick({
            dots: true,
            arrows: false,
            infinite: false,
            speed: 600,
            adaptiveHeight: true,
            variableWidth: false,
            slidesToShow: 1,
            slidesToScroll: 1,
        });

        // Cat Nav
        $(".cat-nav__dropdown-target").on("click", function () {
            $(".cat-nav__dropdown").toggleClass("active");

            return false;
        });

        // Services List Live Search Filter
        $("#services-filter").on("input", function () {
            const searchTerm = $(this).val().toLowerCase().trim();
            const $items = $(".service-item");
            const $noResults = $("#services-no-results");
            let visibleCount = 0;

            $items.each(function () {
                const title = $(this).data("title");
                const matches = title.includes(searchTerm);

                if (matches) {
                    $(this).removeAttr("hidden");
                    visibleCount++;
                } else {
                    $(this).attr("hidden", "");
                }
            });

            // Show/hide no results message
            if (visibleCount === 0 && searchTerm !== "") {
                $noResults.removeAttr("hidden");
            } else {
                $noResults.attr("hidden", "");
            }
        });
    });

    // Sticky-header compact-state toggle.
    // Hysteresis (add at 40% vh, remove at 25% vh) prevents flip-flop at the
    // threshold because the compact header is shorter, which shifts document
    // flow and can re-cross a single threshold mid-transition.
    (function () {
        var $body = $("body");
        var ADD_RATIO = 0.4;
        var REMOVE_RATIO = 0.25;
        var viewportHeight = $(window).height();
        var isCompact = false;
        var ticking = false;

        function update() {
            ticking = false;
            var scroll = window.pageYOffset;
            if (!isCompact && scroll >= ADD_RATIO * viewportHeight) {
                $body.addClass("show-top-btn");
                isCompact = true;
            } else if (isCompact && scroll < REMOVE_RATIO * viewportHeight) {
                $body.removeClass("show-top-btn");
                isCompact = false;
            }
        }

        function onScroll() {
            if (!ticking) {
                window.requestAnimationFrame(update);
                ticking = true;
            }
        }

        $(window).on("scroll", onScroll);
        $(window).on("resize", function () {
            viewportHeight = $(window).height();
        });
        update();
    })();

    $(document).mouseup(function (e) {
        var menu = $(".mobile-nav, .js-nav-trigger, .search-nav");

        if (!menu.is(e.target) && menu.has(e.target).length === 0) {
            $("body").removeClass("nav-overlay-open search-overlay-open");
        }

        var work_nav = $(".work-nav, .link-our-work");
        if (!work_nav.is(e.target) && work_nav.has(e.target).length === 0) {
            $(".work-nav").removeClass("active");
            $(".work-nav").css("min-height", "auto");
            $("body").removeClass("overflow-hidden");
        }

        var cat_nav = $(".cat-nav__dropdown, .cat-nav__dropdown-target");
        if (!cat_nav.is(e.target) && cat_nav.has(e.target).length === 0) {
            $(".cat-nav__dropdown").removeClass("active");
        }
    });

    $(document).keyup(function (e) {
        if (e.keyCode == 27) {
            $("body").removeClass("nav-overlay-open search-overlay-open overflow-hidden");
            $(".work-nav").removeClass("active");
            $(".work-nav").css("min-height", "auto");
            $(".cat-nav__dropdown").removeClass("active");
        }
    });

    $(window).resize(function () {
        if ($(".js-featured-projects-slider").length > 0) {
            const arrows = $(".slick-arrow"),
                slide = $(".js-featured-projects-slider .project:first-of-type .photo");

            let slideHeight = slide.height();

            $(arrows).css("height", slideHeight);
        }
    });
})(jQuery, window, document);
