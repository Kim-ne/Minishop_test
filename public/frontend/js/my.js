document.addEventListener('DOMContentLoaded', function () {

    // Tooltip
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));

    // Popover (nếu sau này dùng)
    // const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    // [...popoverTriggerList].map(el => new bootstrap.Popover(el));

});
