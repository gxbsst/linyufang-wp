(function($) {
    $(document).foundation();
    // $('.datepicker').fdatepicker();

    // Inside of this function, $() will work as an alias for jQuery()
    // and other libraries also using $ will not be accessible under this shortcut
    // $('#dp1').fdatepicker({
    //  format: 'yyyy-mm-dd'
    // });                                                                                                  // $('#dp2').fdatepicker({
    //  format: 'yyyy-mm-dd'
    // });
})(jQuery);

var APP = angular.module('mgApp', ['ngResource', 'ngRoute']);