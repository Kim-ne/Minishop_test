document.addEventListener('DOMContentLoaded', function () {

    // Tooltip
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

    // Popover (nếu sau này dùng)
    // const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    // [...popoverTriggerList].map(el => new bootstrap.Popover(el));

});

    // Tab activation based on query parameter
    $(document).ready(function() {
        var activeTab = "{{ request('tab') }}";

        if (activeTab === 'password') {
            $('a[href="#password"]').tab('show');
        }
    });

    // Toggle password visibility

    $(document).ready(function() {
    $('.toggle-password').click(function() {
        var input = $($(this).data('target'));
        var icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

});


