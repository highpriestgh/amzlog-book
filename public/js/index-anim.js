var screenWidth = jQuery(window).innerWidth();
        
jQuery(window).on('resize', function() {
    var screenWidth = jQuery(window).innerWidth();
    if (screenWidth > 768) {
    var morphing = anime({
        targets: '.polymorph',
        points: [
            {value: '215, 110 0, 110 0, 0 47.7, 0 67, 76'},
            {value: '215, 110 0, 110 0, 0 0, 0 67, 76'}
        ],
        easing: 'easeOutQuad',
        duration: 1200,
        delay: 500,
        loop: false,
    })

        setTimeout(function() {
            jQuery(".hide-div").show();
        }, 2000);
    } else {
        setTimeout(function() {
            jQuery(".hide-div").show();
        }, 50);
    }
});

if (screenWidth > 768) {
    var morphing = anime({
        targets: '.polymorph',
        points: [
            {value: '215, 110 0, 110 0, 0 47.7, 0 67, 76'},
            {value: '215, 110 0, 110 0, 0 0, 0 67, 76'}
        ],
        easing: 'easeOutQuad',
        duration: 1200,
        delay: 500,
        loop: false,
    })

    setTimeout(function() {
        jQuery(".hide-div").show();
    }, 2000);
} else {
    setTimeout(function() {
        jQuery(".hide-div").show();
    }, 50);
}