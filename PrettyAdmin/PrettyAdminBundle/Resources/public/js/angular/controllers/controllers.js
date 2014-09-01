var prettyAdminApp = angular.module('prettyAdminApp', [], function($interpolateProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

prettyAdminApp.controller('EntityCtrl', function($scope, $http){
    setEntities();

    // TODO: replace these hardcoded values with real onces
    $scope.menu = [
        { route: '/admin/posts', label: 'Posts' },
        { route: '/admin/comments', label: 'Comments' }
    ];

    $scope.deleteEntity = function(url, index){
        $http.post(url).success(function(data){
            $scope.entities.splice(index, 1);
        });
    };

    function setEntities(){
        $http.get(location.href + '.json').success(function(data){
            $scope.entities = data.entities;
            $scope.fields = data.fields;
        });
    }
});
