angular.module('app', [
    'ui.bootstrap',
    'ngMaterial'
]).constant('CONFIG', {
    map: CONFIG_MAP_PATH
}).config([
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
    'CONFIG',
    function ($scope, $location, $window, CONFIG) {

        var params = $location.search();

        $scope.iframe = CONFIG.map + '?' + Object.keys(params).map(function (i) {
                return params[i] && encodeURIComponent(i) + "=" + encodeURIComponent(params[i]);
            }).join('&');

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