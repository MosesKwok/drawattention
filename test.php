<html>
<head>
    <style>
        .google-maps {
            position: relative;
            padding-bottom: 75%; // This is the aspect ratio
            height: 0;
            overflow: hidden;
        }
        .google-maps iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>
<body>
    <button id = "find-me">Show my location</button><br/>
    <p id = "status"></p>
    <a id = "map-link" target="_blank"></a>
    <div class="mapouter">
        <div class="gmap_canvas">
            <div class="google-maps">
                <iframe width="500" height="500" id="gmap_canvas" src="" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
            <a href="https://www.embedgooglemap.net/blog/namecheap-promo-code/"></a>
        </div>
        <style>.mapouter{position:relative;text-align:right;height:500px;width:500px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:500px;}</style>
    </div>
</body>
<script>
        function geoFindMe() {

            const status = document.querySelector('#status');
            const mapLink = document.querySelector('#map-link');
            const mapframe = document.querySelector('#gmap_canvas');

            mapLink.href = '';
            mapLink.textContent = '';

            function success(position) {
                const latitude  = position.coords.latitude;
                const longitude = position.coords.longitude;

                status.textContent = '';
                mapLink.href = `https://www.openstreetmap.org/#map=18/${latitude}/${longitude}`;
                mapLink.textContent = `Latitude: ${latitude} °, Longitude: ${longitude} °`;
                mapframe.src = `https://maps.google.com/maps?q=${latitude}%2C${longitude}&t=&z=17&ie=UTF8&iwloc=&output=embed`
            }

            function error() {
                status.textContent = 'Unable to retrieve your location';
            }

            if (!navigator.geolocation) {
                status.textContent = 'Geolocation is not supported by your browser';
            } else {
                status.textContent = 'Locating…';
                navigator.geolocation.getCurrentPosition(success, error);
            }

        }

        document.querySelector('#find-me').addEventListener('click', geoFindMe);
    </script>
</html>