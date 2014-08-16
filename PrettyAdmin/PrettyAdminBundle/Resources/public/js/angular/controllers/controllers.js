var prettyAdminApp = angular.module('prettyAdminApp', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

prettyAdminApp.controller('EntityCtrl', function($scope, $http){
    $http.get('/admin/posts.json').success(function(data){
        $scope.entities = data.entities;
        $scope.fields = data.fields;
    });
});