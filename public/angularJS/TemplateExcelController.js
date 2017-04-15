/**
 * Created by Good on 4/14/2017.
 */

app.controller('TemplateExcelController', function($scope, $http, API) {

    /**
     * Load danh sách template
     */
    $scope.loadTemplate = function () {
        $http.get(API + 'template-excel').then(function (response) {
            $scope.templates = response.data;
        });
    };
    $scope.loadTemplate();

    /**
     * Tìm thông tin template
     */
    $scope.searchTemplate = function () {
        if ($scope.term == '') {
            $scope.loadTemplate();
        } else {
            $http.get(API + 'template-excel/search/' + $scope.term).then(function (response) {
                $scope.templates = response.data;
            });
        }
    };

    $scope.readTemplate = function (template) {
        $http.get(API + 'template-excel/' + template.id).then(function (response) {
            $scope.selected = response.data;
        });
    };

    $scope.downTemplate = function () {
        $http.get(API + 'template-excel/download/' + $scope.selected.id).then(function (response) {
            $("[data-dismiss=modal]").trigger({ type: "click" });
        });
    };

    $scope.deleteTemplate = function () {
        $http({
            method : 'DELETE',
            url : API + 'template-excel/' + $scope.selected.id,
            cache : false,
            header : {'Content-Type':'application/x-www-form-urlencoded'}
        }).then(function (response) {
            if(response.data.success) {
                toastr.success(response.data.success);
                $("[data-dismiss=modal]").trigger({ type: "click" });
                $scope.loadTemplate();
            } else
                toastr.error(response.data[0]);
        });
    };
});

$('#createTemplate').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
});