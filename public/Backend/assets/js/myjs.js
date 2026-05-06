$('.show-hide span').click(function () {
    let target = $(this).parent().data('target'); // lấy id input
    let input = $(target);

    if ($(this).hasClass('show')) {
        input.attr('type', 'text');
        $(this).removeClass('show');
    } else {
        input.attr('type', 'password');
        $(this).addClass('show');
    }
});

$('form button[type="submit"]').on('click', function () {
    $('.show-hide span').addClass('show');
    $('.show-hide').each(function () {
        let target = $(this).data('target');
        $(target).attr('type', 'password');
    });
});
