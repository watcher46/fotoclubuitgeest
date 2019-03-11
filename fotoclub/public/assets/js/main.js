$(document).ready(function () {
    // $(document).on("contextmenu", function (e) {
    //     return false;
    // });

    $(function () {
        $('.dropdown-toggle').dropdown();
    });

    if(typeof menuActiveSelector === 'undefined') {
        menuActiveSelector = 'nav .home';
    }
    $(menuActiveSelector).addClass('active');
});