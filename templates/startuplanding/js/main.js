/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

jQuery(function ($) {

    // Stikcy Header
    if ($('body').hasClass('sticky-header')) {
        var header = $('#sp-header');

        if($('#sp-header').length) {
            var headerHeight = header.outerHeight();
            var stickyHeaderTop = header.offset().top;
            header.before('<div class="nav-placeholder"></div>');
            var stickyHeader = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > stickyHeaderTop) {
                    header.addClass('header-sticky');
                    $('.nav-placeholder').height(headerHeight);
                } else {
                    if (header.hasClass('header-sticky')) {
                        header.removeClass('header-sticky');
                        $('.nav-placeholder').height('inherit');
                    }
                }
            };
            stickyHeader();
            $(window).scroll(function () {
                stickyHeader();
            });
        }

        if ($('body').hasClass('layout-boxed')) {
            var windowWidth = header.parent().outerWidth();
            header.css({"max-width": windowWidth, "left": "auto"});
        }
    }

    // go to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.sp-scroll-up').fadeIn();
        } else {
            $('.sp-scroll-up').fadeOut(400);
        }
    });

    $('.sp-scroll-up').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    // Preloader
    $(window).on('load', function () {
        $('.sp-preloader').fadeOut(500, function() {
            $(this).remove();
        });
    });

    //mega menu
    $('.sp-megamenu-wrapper').parent().parent().css('position', 'static').parent().css('position', 'relative');
    $('.sp-menu-full').each(function () {
        $(this).parent().addClass('menu-justify');
    });

    // Offcanvs
    $('#offcanvas-toggler').on('click', function (event) {
        event.preventDefault();
        $('.offcanvas-init').addClass('offcanvas-active');
    });

    $('.close-offcanvas, .offcanvas-overlay').on('click', function (event) {
        event.preventDefault();
        $('.offcanvas-init').removeClass('offcanvas-active');
    });
    
    $(document).on('click', '.offcanvas-inner .menu-toggler', function(event){
        event.preventDefault();
        $(this).closest('.menu-parent').toggleClass('menu-parent-open').find('>.menu-child').slideToggle(400);
    });

    // Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"], .hasTooltip'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            html: true
        });
    });

    // Article Ajax voting
    $('.article-ratings .rating-star').on('click', function (event) {
        event.preventDefault();
        var $parent = $(this).closest('.article-ratings');

        var request = {
            'option': 'com_ajax',
            'template': template,
            'action': 'rating',
            'rating': $(this).data('number'),
            'article_id': $parent.data('id'),
            'format': 'json'
        };

        $.ajax({
            type: 'POST',
            data: request,
            beforeSend: function () {
                $parent.find('.fa-spinner').show();
            },
            success: function (response) {
                var data = $.parseJSON(response);
                $parent.find('.ratings-count').text(data.message);
                $parent.find('.fa-spinner').hide();

                if(data.status)
                {
                    $parent.find('.rating-symbol').html(data.ratings)
                }

                setTimeout(function(){
                    $parent.find('.ratings-count').text('(' + data.rating_count + ')')
                }, 3000);
            }
        });
    });

    //  Cookie consent
    $('.sp-cookie-allow').on('click', function(event) {
        event.preventDefault();
        
        var date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();               
        document.cookie = "spcookie_status=ok" + expires + "; path=/";

        $(this).closest('.sp-cookie-consent').fadeOut();
    });

    $(".btn-group label:not(.active)").click(function()
    {
        var label = $(this);
        var input = $('#' + label.attr('for'));
        
        if (!input.prop('checked')) {
            label.closest('.btn-group').find("label").removeClass('active btn-success btn-danger btn-primary');
            if (input.val() === '') {
                label.addClass('active btn-primary');
            } else if (input.val() == 0) {
                label.addClass('active btn-danger');
            } else {
                label.addClass('active btn-success');
            }
            input.prop('checked', true);
            input.trigger('change');
        }
        var parent = $(this).parents('#attrib-helix_ultimate_blog_options'); 
        if( parent ){ 
            showCategoryItems( parent, input.val() )
        }
    });
    $(".btn-group input[checked=checked]").each(function()
    {
        if ($(this).val() == '') {
            $("label[for=" + $(this).attr('id') + "]").addClass('active btn btn-primary');
        } else if ($(this).val() == 0) {
            $("label[for=" + $(this).attr('id') + "]").addClass('active btn btn-danger');
        } else {
            $("label[for=" + $(this).attr('id') + "]").addClass('active btn btn-success');
        }
        var parent = $(this).parents('#attrib-helix_ultimate_blog_options'); 
        if( parent ){
            parent.find('*[data-showon]').each( function() {
                $(this).hide();
            })
        }
    });


    function showCategoryItems(parent, value){
        var controlGroup = parent.find('*[data-showon]'); 
        controlGroup.each( function() {
            var data = $(this).attr('data-showon')
            data = typeof data !== 'undefined' ? JSON.parse( data ) : []
            if( data.length > 0 ){
                if(typeof data[0].values !== 'undefined' && data[0].values.includes( value )){
                    $(this).slideDown();
                }else{
                    $(this).hide();
                }
            }
        })
    }

    $(window).on('scroll', function(){
        var scrollBar = $(".sp-reading-progress-bar");
        if( scrollBar.length > 0 ){
            var s = $(window).scrollTop(),
                d = $(document).height(),
                c = $(window).height();
            var scrollPercent = (s / (d - c)) * 100;
            const postition = scrollBar.data('position')
            if( postition === 'top' ){
                // var sticky = $('.header-sticky');
                // if( sticky.length > 0 ){
                //     sticky.css({ top: scrollBar.height() })
                // }else{
                //     sticky.css({ top: 0 })
                // }
            }
            scrollBar.css({width: `${scrollPercent}%` })
        }
            
    })    

    // template related code

    //articles reading time for articles addon
    if($('.sl-addon-articles').length>0){
        $(".sppb-addon-article").each(function(){
            let totalWords = $(this).attr("data-total-words");
            let readingTimeInMinutes = (Math.floor(totalWords / 200)) < 1 ? 1 : (Math.floor(totalWords / 200));
            $(this).find(".reading-time .time-length").append(readingTimeInMinutes);
        });
    }

    //articles reading time for articles listing

    //articles reading time for article details
    if($('.com-content').length>0){
        if($('.article').length>0){
            $(".article").each(function(){
                let totalWords = $(this).attr("data-reading-time");
                $(this).find(".reading-time").append(totalWords);
            });
        }
        if($('.view-article').length>0){
            let articleDetails =  $('.article-details-content')[0].textContent;
            let wordCount = articleDetails.replace( /[^\w ]/g, "" ).split( /\s+/ ).length;
            let readingTimeInMinutes = (Math.floor(wordCount / 200)) < 1 ? 1 : (Math.floor(wordCount / 200));
            $(this).find(".article-info-wrap .reading-time").append(readingTimeInMinutes);
        }
    };

    $portfolioDesc = $('.sp-simpleportfolio-description');
    if($portfolioDesc.length>0){
        $builderAvaiable = $portfolioDesc.find('#sp-page-builder').length;
        if($builderAvaiable){
            $portfolioDesc.addClass("has-builder");
        }
    };

    if($('.sl-no-shadows').length>0){
        $('.sl-no-shadows').each(function(){
            $(this).closest('.sp-module-content').addClass("sl-no-shadows-wrap")
        })
    };

    $(document).ready(function(){
        if($('.view-article .pager.pagenav').length>0) {
            let previousArticle = $('.view-article .pager.pagenav .previous>a');
            let nextArticle = $('.view-article .pager.pagenav .next>a');
            let prevData = previousArticle.attr('data-bs-original-title');
            let nextData = nextArticle.attr('data-bs-original-title');
            previousArticle.html(`<span class="text">${prevData}</span> <span class="icon fas fa-arrow-left"></span>`);
            nextArticle.html(`<span class="text">${nextData}</span> <span class="icon fas fa-arrow-right"></span>`);
        } 
    });
});
