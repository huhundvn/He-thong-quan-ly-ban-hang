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

var app = angular.module('LaRose', ['angucomplete-alt', 'angularUtils.directives.dirPagination', 'cleave.js'])
	.constant('API', 'http://larose-admin.herokuapp.com/api/');
// http://larose-admin.herokuapp.com/api/