<?php

require 'User-Header.php';

?>
<body>

    <canvas id="CANVAS" name="CANVAS" style="align-items: center;width: 15%;height: 15%;">Your browser does not support Canvas.</canvas>


    <div id="container" name='cont' class="container-fluid no-padding ">
        <video autoplay="true" id="videoElement" name='vid'>

        </video>
    </div>

    <a id="download" download="meter.jpg"></form>
        <button onclick="myFunction(); download();" style="margin: 20px 250px auto;align-items: center; " class="btn btn-primary dropdown-toggle" type="button">capture</button></a>

    <script>
        function download() {
            var download = document.getElementById("download");
            var image = document.getElementById("CANVAS").toDataURL("image/png")
                .replace("image/jpg", "image/octet-stream");
            download.setAttribute("href", image);
            //download.setAttribute("download","archive.png");
        }





        var video = document.querySelector("#videoElement");

        if (navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    video.srcObject = stream;
                })
                .catch(function(err0r) {
                    console.log("Something went wrong!");
                });
            var i = 0;

            function myFunction() {
                var x = document.getElementById("CANVAS");
                var ctx = x.getContext("2d");
                ctx.fillStyle = "#FF0000";

                ctx.drawImage(video, 0, 0, 400, 350);

                //ctx.fillRect(20, 20, 150, 100);

                if (i < 10) {
                    document.body.appendChild(x);
                    i = i + 1;
                };


            }

        }
    </script>


</body>

</html>
<?php
?>