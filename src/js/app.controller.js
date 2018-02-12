angular.module('app').controller('AppCtrl', [
    '$scope',
    '$location',
    '$window',
    function (
      $scope,
      $location,
      $window
    ) {
        document.getElementById('map').onload = function () {
            var FruskacMap = document.getElementById('map').contentWindow.fruskac;

            new FruskacMap({
                lang: CONFIG_LANG,
                fullscreen: CONFIG_FULLSCREEN,
                clustering: CONFIG_CLUSTERING,
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
                    };
                });
            });
        };

        if ($window.innerWidth > 768) {
            $scope.navigationOpen = true;
        }
    }
]);
