angular.module('app').filter('humanize', function () {
    return function (text) {
        if (text) {
            text.match(/(\w+)/g).forEach(function (word) {
                text = text.replace(word, word.charAt(0).toUpperCase() + word.slice(1))
            });
            return text.replace(/[^a-zA-Z0-9]+/g, ' ');
        }
    };
});