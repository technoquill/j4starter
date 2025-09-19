/**
 * fn element[placeholder]
 */
function setPlaceholder() {
    let placeholder = jQuery("[placeholder]");
    placeholder.focus(function () {
        jQuery(this).data('placeholder', $(this).attr('placeholder'))
        jQuery(this).attr('placeholder', '');
    });
    placeholder.blur(function () {
        jQuery(this).attr('placeholder', $(this).data('placeholder'));
    });
}

/**
 *  fn replace span.Mail class
 *
 *  */
function setEmailReplace() {
    jQuery('span.mail').each(function () {
        let spt = jQuery(this);
        let at = / at /;
        let dot = / dot /g;
        let addr = $(spt).text().replace(at, "@").replace(dot, ".");
        jQuery(spt).after('<a class="mail" href="mailto:' + addr + '"><span>' + addr + '</span></a>');
        jQuery(spt).remove();
    })
}

/**
 *  fn scrollUp
 */

function setScrollUp() {
    let scrollup = '.scrollup';
    jQuery("body").append("<a class='scrollup' href='javascript:void(0);'></a>");
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 100) {
            jQuery(scrollup).fadeIn();
        } else {
            jQuery(scrollup).fadeOut();
        }
    });
    jQuery(scrollup).on('click', function () {
        jQuery("html, body").animate({scrollTop: 0}, 600);
        return false;
    });
}

function setSlideReveal() {
    let slidePanel = jQuery("#sidebar-panel").slideReveal({
        trigger: jQuery("#toggle-sidebar-panel"),
        position: "right",
        width: 320,
        push: true,
        overlay: true,
        overlayColor: "rgba(13, 55, 76, 0.75)",
        show: function (slider, trigger) {
            jQuery("#wrapper").addClass('x-overlay');
            //$("#mmenu a").html('<a href="javascript:void()" id="mmenu-trigger"><i class="fa-solid fa-xmark"></i></a>');
        },
        hidden: function (slider, trigger) {
            jQuery("#wrapper").removeClass('x-overlay')
            //$("#mmenu a").html('<a href="javascript:void()" id="mmenu-trigger"><i class="fa-solid fa-bars"></i></a>');
        }
        // https://nnattawat.github.io/slideReveal/
    });

    jQuery('span.close-panel').on('click', function () {
        slidePanel.slideReveal('hide');
    })
}


/**
 * Side Panel
 */
function setSlideRevealData() {
    let panel_logo = jQuery('#logotype').clone(true);
    let panel_menu = jQuery('#top-menu').clone(true);
    let panel_contacts = jQuery('#address').clone(true);
    let panel_phones = jQuery('#list-of-phones').clone(true);
    panel_logo.appendTo('#sidebar-panel-logo').removeAttr('id');
    panel_menu.appendTo('#sidebar-panel-menu').removeAttr('id');
    panel_contacts.appendTo('#sidebar-panel-address').removeAttr('id');
    panel_phones.appendTo('#sidebar-panel-phones').removeAttr('id').removeAttr('class');
}


jQuery(window).scroll(function () {
    let headerTopBlockHeight = jQuery("#header-top").height();
    if (jQuery(document).scrollTop() >= headerTopBlockHeight) {
        setTimeout(function () {
            jQuery('#header-top').css({
                'display': 'none'
            });
        }, 100)
    } else {
        setTimeout(function () {
            jQuery('#header-top').css({
                'display': 'block'
            });
        }, 100)
    }
});

jQuery(document).ready(function () {
    setPlaceholder();
    setEmailReplace();
    setScrollUp();
    setSlideReveal();
    setSlideRevealData();
});
