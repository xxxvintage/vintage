
<html>
    <head>
        <title>Redirecting...</title>

        <script src="https://track.salesflare.com/flare.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    </head>

    <body style="visibility: hidden;">

        <div class="sf-header">
            <div class="sf-hero">
                <div class="container">
                    <div class="header-container">
                        <h1 class="sf-heading">Want to track your emails using Salesflare as well?</h1>
                    </div>
                    <div style="display:flex; margin-top: 48px;">
                        <a id="trialButton" class="sf-button" href="https://app.salesflare.com/#/signup/?campaign=-trackinglinks-landingpage" title="Free Trial">Try it for free</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var vars = setVars();
            var isValidUrl = isValid();

            function setVars() {

                var vars = [];
                var hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for (var i = 0; i < hashes.length; i++) {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    // Make sure the url is prefixed
                    if (hash[0] === 'u') {
                        vars[hash[0]] = sanitizeURL(hash[1]);
                    }
                    else {
                        vars[hash[0]] = hash[1];
                    }
                }

                return vars;
            };

            function isValid() {

                return vars.t || vars.e || !vars.u;
            }

            // Based on https://github.com/sindresorhus/prepend-http/blob/040579fb1271df6232dd96a7600c9efb1510eb47/index.js
            function sanitizeURL(url) {

                url = decode(url.trim());

                // Ignore custom protocols
                if (/^(?!localhost)\w+:/.test(url)) {
                    return url;
                }

                // Replace relative stuff like `./test.com`
                if (/^\.*\/+/.test(url)) {
                    return url.replace(/^\.*\/+/, 'http://');
                }

                return url.replace(/^(?!(?:\w+:)?\/\/)/, 'http://');
            }

            function decode(string) {

                var decoded;
                // We have old urls encoded using escape which breaks when using multi byte characters like "Ã¨"
                // If the url does not have special chars, `decodeURIComponent` will work
                // If it has something like "Ã¨" it will throw so then we fall back to unescape
                try {
                    decoded = decodeURIComponent(string);
                }
                catch (_) {
                    decoded = unescape(string);
                }

                return decoded;
            }

            window.onerror = function (m, u, l) {
                try {
                    var originalUrl = vars.u;
                    if (originalUrl === undefined) {
                        var trialUrl = 'https://app.salesflare.com/#/signup/?campaign=';
                        var trackingDomains = vars[0]?.split('https://')[1]?.split('.com')[0].split('.to')[0];

                        trialUrl += trackingDomains ? trackingDomains : '';
                        trialUrl += '-trackinglinks-landingpage';

                        var button = document.getElementById("trialButton");
                        if (button) {
                            button.setAttribute('href', trialUrl);
                        }

                        document.body.setAttribute("class", "sf-background");
                        document.body.style.visibility = 'visible';
                        return;
                    }

                    window.location.href = originalUrl;
                }
                catch (_) {
                    window.location.href = vars.u;
                }
            };
            if (!isValidUrl) {
                var domain = window.location.origin; // get the protocol and domain
                if (window.location.pathname.startsWith('/s')) {
                    domain += '/s';
                }
                window.location.href = unescape(Flare.vars.u);
            }
            var flare = new Flare();
            flare.forward();
        </script>
    </body>
    <style>
        body.sf-background {
            background-color: #3cb6e3;
            color: #FFFFFF;
            
            .sf-header {
                margin-top: 250px;
                    
                .sf-hero {                    
                    .container {
                        width: 600px;
                        padding: 0;
                        overflow: visible;
                        margin: 0 auto;

                        .header-container {
                            width: 100%;
                            margin: auto;

                            .sf-heading {
                                width: 100%;
                                font-size: 45px;
                                letter-spacing: -1.4px;
                                font-family: montserrat;
                                text-align: center;
                            }
                        }


                        .sf-button {
                            margin:auto;
                            text-transform: uppercase;
                            text-decoration: none;

                            cursor: pointer;

                            color:  #ffffff;

                            text-align: center;

                            background-color: #e74c3c;

                            width: 180px;
                            font-family: 'Montserrat';
                            font-size: 12px;
                            font-weight: 400;
                            padding: 13px 0 13px 0;
                            letter-spacing: 2px;
                            -webkit-border-radius: 80px;
                            -moz-border-radius: 80px;
                            border-radius: 80px;
                            display: inline-block;
                        }
                    }
                }
            }
        }
    </style>
</html>