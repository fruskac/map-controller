<?php include('../config.php') ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        iframe {
            border: none;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>

<iframe src="<?php echo $mapPath ?>" id="map" allowfullscreen></iframe>

<script>
    document.getElementById('map').onload = function () {
        var FruskacMap = document.getElementById('map').contentWindow.fruskac;
        new FruskacMap({
            lang: '<?php echo $lang ?>',
            fullscreen: '<?php echo $fullscreen ?>',
            data: <?php echo json_encode($data) ?>
        });
    };
</script>

</body>
</html>