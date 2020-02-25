import $ from 'jquery';
import Clipboard from 'clipboard';
import './scss/global.scss';
import logoImg from './images/banner.png';
import xiavicBadgeImg from './images/xiavic_badge.gif';
import sleipnirImg from './images/sleipnir.png';
import secretImg from './images/secret-33853503-500-750.jpg'; 
import arrowImg from './images/arrow.png';

var slideshowIndex = 0;
$(document).ready(function() {
    setLandingImg();

    $('.landing > header > .banner > #logo').attr('src', logoImg);
    $('.landing > .introduction #xiavic-badge').attr('src', xiavicBadgeImg);
    $('.sleipnir').attr('src', sleipnirImg);
    $('.secret-img').attr('src', secretImg);
    $('.arrow-img').attr('src', arrowImg);

    $('a[href^="#"]').click(function(e) {
        e.preventDefault();
        let id = $(this).attr('href');
        scrollToAnchor(id);
    });

    $('.landing .slideshow-controls a.control').click(function(e) {
        e.preventDefault();
        if (!$('.landing > .landing-img').data('animating')) {
            if ($(this).is('.left')) {
                slideshowIndex--;
            } else if ($(this).is('.right')) {
                slideshowIndex++;
            }
            setLandingImg(slideshowIndex);
        }
    });

    new Clipboard('.server-addr');
    $('.server-addr').click(function() {
        $(this).children('.copy-alert').clearQueue().fadeIn().delay(3000).fadeOut();
    });

    $('.secret-trigger').hover(function() {
        $('.secret-img').clearQueue().delay(1000).fadeIn();
    }, function() {
        $('.secret-img').clearQueue().fadeOut();
    });
});

function scrollToAnchor(aid){
    let aTag = $(aid);
    $('html,body').animate({scrollTop: aTag.offset().top}, 'slow');
}

function setLandingImg(index) {
    let min = 1;
    let max = 10;
    if (index === undefined) {
        slideshowIndex = Math.round(Math.random() * (max - min) + min);
    } 
    else if (index < min) { slideshowIndex = max; }
    else if (index > max) { slideshowIndex = min; }
    else { slideshowIndex = index; }
    let l = $('.landing > .landing-img');
    let classes = l[0].className.split(' ').pop();
    if (index !== undefined) {
        l.data('animating', true)
            .animate({opacity: 0},'slow', function() { 
                l.removeClass(classes)
                    .addClass('l'+ slideshowIndex)
                    .animate({opacity: 1}, 'slow', function() {
                        l.data('animating', false);
                    });
            });
    } else {
        l.removeClass(classes).addClass('l'+ slideshowIndex);
    }
}

