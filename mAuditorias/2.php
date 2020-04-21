<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <iframe src="http://suriutl.com/abmcalif/calificaciones.php" id="frame" frameborder="0"></iframe>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    $("#frame").on("load", function () {
    // do something once the iframe is loaded
    var iframe = document.getElementById("frame"); // or some other selector to get the iframe
    alert("asdasdas");
alert(iframe.contentWindow.document.getElementById("sidebar1"));
});
    /* $(document).ready(function(e) {
        var iframe = document.getElementById("frame"); // or some other selector to get the iframe
        var elmnt = "asdasd";
         //elmnt = iframe.contentWindow.document.getElementsByTagName("h1")[0];
        //var texto = $(iframe).contents().find("#contenedor").html();
        //alert($(iframe).html());
        alert(iframe.contentWindow.document.getElementById("sidebar1"));
    }); */
    </script>
</body>

</html>