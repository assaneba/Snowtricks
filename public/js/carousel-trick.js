/*
    Carousel
*/
$('#carousel-example').on('slide.bs.carousel', function (e) {

    alert('test');
   /* var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 4;
    var totalItems = $('.carousel-item1').length + $('.carousel-item2').length;*/

    /*if (idx >= totalItems-(itemsPerSlide-1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i=0; i<it; i++) {
            // append slides to end
            if (e.direction === "left") {
                $('.carousel-item1').eq(i).appendTo('.carousel-inner');
                $('.carousel-item2').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('.carousel-item1').eq(0).appendTo('.carousel-inner');
                $('.carousel-item2').eq(0).appendTo('.carousel-inner');
            }
        }
    }*/
});
