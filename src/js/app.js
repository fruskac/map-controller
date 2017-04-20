angular.module('app', [
    'ui.bootstrap',
    'ngMaterial'
]).config([
    '$compileProvider',
    '$mdThemingProvider',
    function ($compileProvider, $mdThemingProvider) {
        $compileProvider.debugInfoEnabled(false);
        $compileProvider.commentDirectivesEnabled(false);
        $compileProvider.cssClassDirectivesEnabled(false);
        $mdThemingProvider.disableTheming();
    }
]).filter('humanize', function () {
    return function (text) {
        if (text) {
            text.match(/(\w+)/g).forEach(function (word) {
                text = text.replace(word, word.charAt(0).toUpperCase() + word.slice(1))
            });
            return text.replace(/[^a-zA-Z0-9]+/g, ' ');
        }
    };
}).controller('AppCtrl', [
    '$scope',
    '$location',
    '$window',
    function ($scope, $location, $window) {

        document.getElementById('map').onload = function () {
            var FruskacMapAPI = document.getElementById('map').contentWindow.fruskac;

            new FruskacMapAPI({
                lang: CONFIG_LANG,
                fullscreen: CONFIG_FULLSCREEN,
                data: CONFIG_DATA
            }).ready(function () {

                var self = this;

                $scope.$apply(function () {
                    $scope.ready = true;
                    $scope.data = self.getData();
                    $scope.clustering = self.clustering;
                    $scope.type = self.type;

                    $scope.loaded = true;

                    $scope.highlight = function (item, category) {
                        item.highlightedCategory = category;
                        item.highlight(category);
                    }

                })
            });
        };

        if ($window.innerWidth > 768) {
            $scope.navigationOpen = true;
        }

    }
]);