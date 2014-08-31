describe('EntityCtrl', function(){
    beforeEach(module('prettyAdminApp'));

    it('should return non empty array of entities', inject(function($controller) {
        var scope = {},
            ctrl = $controller('EntityCtrl', { $scope : scope });

        expect(scope.entities);
    }));
});