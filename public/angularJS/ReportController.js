/**
 * Created by Good on 5/3/2017.
 */
app.controller('ReportController', function($scope, $http, API, $interval) {
    $http.get(API + 'top-product').then(function (response) {
        $scope.topProducts = response.data;
    });

    $scope.labels = [1, 2];

    $scope.data = [65, 59, 100];
});