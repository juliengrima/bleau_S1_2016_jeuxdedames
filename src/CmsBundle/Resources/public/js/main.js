/* Demo purposes only */
$(".hover").mouseleave(
    function () {
        $(this).removeClass("hover");
    }
);

function slideHome(){
    $('#slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        centerMode: true,
        variableWidth: true,
        accessibility: false,
        autoplay: true,
        arrows: false,
        pauseOnFocus: false,
        pauseOnHover: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
}

// Show more and less
function showTexte(showChar) {
    var contentHome = $('.contentHome');
    var ellipsestext = "...";
    var moretext = "Lire la suite";
    var lesstext = "Masquer";

    contentHome.each(function () {
        var content = $(this).html();
        if (content.length > showChar){
            var showContent = content.substr(0, showChar);
            var hideContent = content.substr(showChar, content.length - showChar);

            var html =
                showContent +
                '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span>' +
                '<span class="morecontent">' +
                '<span>' + hideContent + '</span>&nbsp;&nbsp;' +
                '<a href="" class="morelink text-center">' + moretext + '</a>' +
                '</span>';
            $(this).html(html);
        }
    });

    $(".morelink").click(function(e){
        e.preventDefault();
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).prev().fadeToggle();
        $(this).parent().prev().toggle();
    });
}