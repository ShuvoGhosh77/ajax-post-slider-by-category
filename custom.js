(function ($) {
    $(document).ready(function () {



        // 	blog slider with ajax 	
        function loadPosts(category) {
            $.ajax({
                url: ajax_object.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_blog_posts',
                    category: category,
                },
                beforeSend: function () {
                    $('#ecom-blog-posts').html('<div class="loading"></div>');
                },
                success: function (response) {
                    $('#ecom-blog-posts').html(response);

                    $('.ecom-blog-slider').slick({
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        arrows: true,
                        dots: false,
                        infinite: false,
                        cssEase: 'linear',
                        prevArrow: '<button type="button" class="slick-prev">&#10094;</button>',
                        nextArrow: '<button type="button" class="slick-next">&#10095;</button>',
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    slidesToShow: 2,
                                }
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1,
                                }
                            }
                        ]
                    });
                }
            });
        }

        // Load default category on page load
        $(document).ready(function () {
            if (typeof defaultCategory !== 'undefined') {
                loadPosts(defaultCategory);
            }
            $(document).on('click', '.category-btn', function (e) {
                e.preventDefault();
                $('.category-btn').removeClass('active');
                $(this).addClass('active');
                var categoryId = $(this).data('id');
                loadPosts(categoryId);
            });
        });

    });
})(jQuery);









