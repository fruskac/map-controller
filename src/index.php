<?php include('../config.php') ?><!DOCTYPE html>
<html ng-app="app" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ФRuŠKać</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/paper/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="app.css">

</head>

<body ng-controller="AppCtrl">

<iframe src="<?php echo $mapPath ?>" id="map"></iframe>

<div id="header">
    <a ng-click="navigationOpen=!navigationOpen" class="btn pull-right"
       ng-class="{'btn-link':navigationOpen,'btn-default':!navigationOpen}">
        <i class="material-icons">menu</i>
    </a>
</div>

<div id="navigation-overlay" ng-class="{'in':navigationOpen}" ng-click="navigationOpen=false"></div>
<div id="navigation" ng-class="{'in':navigationOpen}">
    <div ng-hide="ready" class="panel panel-default">
        <div class="panel-body">
            Loading...
        </div>
    </div>
    <div ng-if="ready" class="panel-group">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <!--<div class="col-xs-5">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       ng-checked="clustering()"
                                       ng-click="clustering(!clustering())">
                                Clustering
                            </label>
                        </div>
                    </div>-->
                    <div class="col-xs-6">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"
                                       ng-checked="type()==='satellite'"
                                       ng-click="type(type()==='terrain'?'satellite':'terrain')">
                                Satellite
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div ng-repeat="item in ::data" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a ng-if="::item.children" ng-click="$parent.open=!$parent.open"
                       ng-init="$parent.open=item.getVisible()" class="pull-right">
                        <i class="material-icons" ng-style="{'transform':$parent.open?'rotate(90deg)':'none'}">chevron_right</i>
                    </a>
                    <md-switch md-no-ink ng-click="item.setVisible(!item.getVisible());open=item.getVisible()"
                               ng-checked="item.getVisible()">
                        {{ ::item.id | humanize }}
                    </md-switch>
                </h3>
            </div>
            <ul ng-if="::item.children&&item.categories" ng-show="open" class="nav nav-tabs nav-justified">
                <li ng-class="{'active':tab===1}">
                    <a ng-click="$parent.tab=1">Objects</a>
                </li>
                <li ng-class="{'active':tab===2}">
                    <a ng-click="$parent.tab=2">Activity</a>
                </li>
            </ul>
            <div ng-if="::item.children" ng-show="open" class="panel-body" ng-init="$parent.tab=1">
                <div ng-show="$parent.tab===1" class="row">
                    <div class="col-xs-6" ng-repeat="child in ::item.children">
                        <div class="checkbox" ng-class="'checkbox-' + child.id">
                            <label>
                                <input ng-attr-type="{{ child.type !== 'FRUSKAC_TYPE_TRACK' ? 'checkbox' : 'radio' }}"
                                       ng-click="item.getVisible()&&(child.type !== 'FRUSKAC_TYPE_TRACK'?child.setVisible(!child.getVisible()):child.focus())"
                                       ng-checked="child.getVisible()"
                                       ng-disabled="!item.getVisible()">
                                {{ ::child.id | humanize }}
                            </label>
                        </div>
                    </div>
                </div>
                <div ng-show="$parent.tab===2" class="row">
                    <div class="col-xs-6" ng-repeat="category in item.categories">
                        <div class="checkbox" ng-class="'checkbox-' + child.id">
                            <label>
                                <input type="radio"
                                       ng-attr-name="{{item.id}}"
                                       ng-checked="item.highlightedCategory===category"
                                       ng-click="highlight(item, item.highlightedCategory===category ? null : category)"
                                >
                                {{ ::category | humanize }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="loading" ng-class="{'loaded':loaded}"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-aria.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-messages.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap-tpls.min.js"></script>

<script>
    var CONFIG_LANG = '<?php echo $lang ?>';
    var CONFIG_FULLSCREEN = '<?php echo $fullscreen ?>';
    var CONFIG_DATA = <?php echo json_encode($data) ?>;
</script>

<script src="app.js"></script>

</body>

</html>