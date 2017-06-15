<?php include('config.php') ?><!DOCTYPE html>
<html ng-app="app" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>
    
    <meta name="description" property="og:description" content="<?php echo $teaser ?>" />
	<link rel="image_src" href="<?php echo $social_img ?>"/>
	<link rel="publisher" href="https://plus.google.com/109303824210403522789"/>
	<link rel="apple-touch-icon" href="/sites/default/files/default/apple-touch.png"/>
	
	<!-- fb -->
	<meta property="og:site_name" content="Fruškać" />
	<meta property="og:title" content="<?php echo $title ?>" />
	<meta property="og:url" content="<?php echo $url ?>" />
	<meta property="og:locale" content="<?php echo $language_tag ?>"/>
	<meta property="fb:admins" content="1008229337"/>
	<meta property="og:type" content="website" />
	<meta property="fb:app_id" content="162794040527270" />
	<meta property="og:image" content="<?php echo $social_img ?>" />
	
	<!-- twitter -->
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:site" content="@fruskac" />
	<meta name="twitter:creator" content="@fruskac" />
	<meta name="twitter:title" content="<?php echo $title ?>" />
	<meta name="twitter:description" content="<?php echo $teaser ?>" />
	<meta name="twitter:image:src" content="<?php echo $social_img ?>" />
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/paper/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="app.css" inline>

    <style><?php

            function printColorStyle($itemId, $childId = '', $color) {
                echo 'input[class*="color-' . $itemId . '-' . $childId . '"]:checked:after{background:' . $color . '!important;border-color:' . $color . '!important;}';
            }

            foreach ($color as $itemId => $itemColor) {
                if (is_array($itemColor)) {
                    foreach ($itemColor as $childId => $childColor) {
                        printColorStyle($itemId, $childId, $childColor);
                    }
                } else {
                    printColorStyle($itemId, '', $itemColor);
                }
            }

    ?></style>

</head>

<body ng-controller="AppCtrl">

<iframe src="<?php echo $mapPath ?>" id="map"></iframe>

<div id="header">
    <a ng-click="navigationOpen=!navigationOpen" class="btn pull-right"
       ng-class="{'btn-link':navigationOpen,'btn-default':!navigationOpen}">
        <i class="material-icons">menu</i>
    </a>
</div>

<div id="alert">
    <div ng-hide="hideAlert" class="alert alert-default">
        <span class="hidden-xs">{{ 'alert_text' | translate }}</span>
        <a class="alert-link" href="#" target="_blank">{{ 'alert_link' | translate }}</a>
        <a class="close" ng-click="hideAlert=true">
            <i class="material-icons">clear</i>
        </a>
    </div>
    <a ng-show="hideAlert" ng-click="hideAlert=false" class="hidden-xs">
        <i class="material-icons">speaker_notes</i>
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
                <div class="column-list">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   ng-checked="clustering()"
                                   ng-click="clustering(!clustering())">
                            {{ 'clustering' | translate }}
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"
                                   ng-checked="type()==='satellite'"
                                   ng-click="type(type()==='terrain'?'satellite':'terrain')">
                            {{ 'satellite' | translate }}
                        </label>
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
                        {{ ::item.id | translate:'item' }}
                    </md-switch>
                </h3>
            </div>
            <ul ng-if="::item.children&&item.categories" ng-show="open" class="nav nav-tabs nav-justified">
                <li ng-class="{'active':tab===1}">
                    <a ng-click="$parent.tab=1">
                        {{ 'objects' | translate }}
                    </a>
                </li>
                <li ng-class="{'active':tab===2}">
                    <a ng-click="$parent.tab=2">
                        {{ 'activity' | translate }}
                    </a>
                </li>
            </ul>
            <div ng-if="::item.children" ng-show="open" class="panel-body" ng-init="$parent.tab=1">
                <div ng-show="$parent.tab===1" class="column-list">
                    <div ng-repeat="child in ::item.children" class="checkbox">
                        <label>
                            <input ng-attr-type="{{ child.type !== 'FRUSKAC_TYPE_TRACK' ? 'checkbox' : 'radio' }}"
                                   ng-click="item.getVisible()&&(child.type !== 'FRUSKAC_TYPE_TRACK'?child.setVisible(!child.getVisible()):child.focus())"
                                   ng-checked="child.getVisible()"
                                   ng-disabled="!item.getVisible()"
                                   ng-class="'color-'+item.id+'-'+child.id"
                            >
                            {{ ::child.id | translate:'child' }}
                        </label>
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
                                {{ ::category | translate:'category' }}
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
    var CONFIG_CLUSTERING = <?php echo $clustering ? 'true' : 'false' ?>;
    var CONFIG_DATA = <?php echo json_encode($data) ?>;
    var CONFIG_TRANSLATION = <?php echo json_encode($translation) ?>;
</script>

<script src="app.js" inline></script>
<script type="text/javascript">
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-35425272-1', 'auto');
        ga('send', 'pageview');
</script>
</body>

</html>