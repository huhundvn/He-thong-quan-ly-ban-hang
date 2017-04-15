/**
 * Created by Good on 4/9/2017.
 */
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

var app = angular.module('LaRose', ['angularUtils.directives.dirPagination', 'cleave.js', 'angucomplete-alt'])
    .constant('API', '/larose/public/');