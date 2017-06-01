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

var app = angular.module('LaRose', ['angucomplete-alt', 'angularUtils.directives.dirPagination', 'cleave.js', 'chart.js'])
	.constant('API', 'http://larose-admin.herokuapp.com/api/');
    // .config(['ChartJsProvider', function (ChartJsProvider) {
    //     // Configure all charts
    //     ChartJsProvider.setOptions({
    //         chartColors: ['#803690', '#00ADF9', '#DCDCDC', '#46BFBD', '#FDB45C', '#949FB1', '#4D5360'],
    //         responsive: true
    //     });
    //     // Configure all line charts
    //     ChartJsProvider.setOptions('line', {
    //         showLines: true
    //     });
    // }]);
// http://larose-admin.herokuapp.com/api/