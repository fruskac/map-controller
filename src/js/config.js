angular.module('app').config([
    '$compileProvider',
    '$mdThemingProvider',
    function ($compileProvider, $mdThemingProvider) {
        $compileProvider.debugInfoEnabled(false);
        $compileProvider.commentDirectivesEnabled(false);
        $compileProvider.cssClassDirectivesEnabled(false);
        $mdThemingProvider.disableTheming();
    }
]);