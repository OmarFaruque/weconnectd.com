
if($('.owl-carousel1').length){
    var owl = $('.owl-carousel1');
    owl.owlCarousel({
        items:1,
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true
    });
    $('.play').on('click',function(){
        owl.trigger('play.owl.autoplay',[3000])
    })
    $('.stop').on('click',function(){
        owl.trigger('stop.owl.autoplay')
    })
}


if($('.owl-carousel2').length){
    var owl = $('.owl-carousel2');
    owl.owlCarousel({
        items:1,
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:4000,
        nav: false,
        dots: false,
        autoplayHoverPause:true
    });
    $('.play').on('click',function(){
        owl.trigger('play.owl.autoplay',[4000])
    })
    $('.stop').on('click',function(){
        owl.trigger('stop.owl.autoplay')
    })    
}




var fb_login = function(){
    FB.getLoginStatus(function(response) {
        FB.api('/me?fields=name,email', function(meResponse) {
            var data = {
                action: 'fb_login',
                fb_data: meResponse
            };

            $.ajax({
                url: local.root_url + "functions/ajax.php",
                method: "POST",
                data: data,
                dataType: "json",
                cache: false,
                success: function(data){
                    if(data.login && data.login == 'success'){
                        location.reload();
                    }
                }, 
                error: function(error){
                    console.log('this is error: ', error);
                }
            });
        });
    });
}
