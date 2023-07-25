<!DOCTYPE html>
<html>

<head>
    <title>{{ config('idoc.title') }}</title>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        http-equiv="Content-Security-Policy"
        content="upgrade-insecure-requests"
    >
    <style>
        @import url(//fonts.googleapis.com/css?family=Roboto:400,700);

        body {
            margin: 0;
            padding: 0;
            font-family: Verdana, Geneva, sans-serif;
        }

        #container .menu-content img {
            padding: 30px 0px;
        }

        .-depth0 {
            font-weight: 600;
            color: rgb(47 195 121) !important;
        }
    </style>
    <link
        rel="icon"
        type="image/png"
        href="/favicon.ico"
    >
    <link
        rel="apple-touch-icon-precomposed"
        href="/favicon.ico"
    >
    <link
        href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700|Roboto:300,400,700"
        rel="stylesheet"
    >

</head>

<body>

    <div id="container"></div>
    {{-- <script src="https://cdn.redoc.ly/redoc/latest/bundles/redoc.standalone.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@redoc/redoc-pro@2.1.5/dist/redocpro-standalone.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@redoc/redoc-pro@1.0.0-beta.38/dist/redocpro-standalone.min.js"></script>
    <script defer>
        RedocPro.init(
            // Redoc.init(
            "{{ config('idoc.output') . '/openapi.json' }}", {
                "showConsole": true,
                "showObjectSchemaExamples": true,
                "pathInMiddlePanel": true,
                "redocExport": "RedocPro",
                "layout": {
                    "scope": "section"
                },
                "unstable_externalDescription": '{{ route('app.idoc') }}',
                "hideDownloadButton": {{ config('idoc.hide_download_button') ?: 0 }}
            },
            document.getElementById("container")
        );
    </script>
    <script defer>
        const targetElement = document.getElementById('container');

        const observer = new MutationObserver((mutationsList) => {
            const hasChildJS = targetElement.children.length > 0;
            if (hasChildJS) {
                const section = document.querySelectorAll('[data-item-id="section/Authentication"]');

                if (section.length > 0) {
                    section[0].style.display = "none";
                }

                const tag = document.getElementById('section/Authentication')

                if (tag) {
                    tag.style.display = "none";
                }
            }
        });

        observer.observe(targetElement, {
            childList: true,
            subtree: true
        });
    </script>
</body>

</html>
