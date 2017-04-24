angular.module('app').filter('translate', function () {
    return function (id, namespace) {

        if (!namespace) {
            namespace = 'inline';
        }

        if (id) {

            if (CONFIG_TRANSLATION && CONFIG_TRANSLATION[namespace] && CONFIG_TRANSLATION[namespace][id]) {
                return CONFIG_TRANSLATION[namespace][id];
            }


        }

        return id;

    };
});