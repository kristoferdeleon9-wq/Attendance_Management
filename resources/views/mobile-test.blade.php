<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Test</title>
</head>

<body>

    <h1>AttendEase Mobile</h1>

    <button onclick="testAPI()">Test API</button>

    <p id="result">Waiting...</p>

    <script>
        async function testAPI() {

            try {

                const response = await fetch(
                    'https://amenities-government-ancient-similarly.trycloudflare.com/api/test'
                );

                const data = await response.json();

                document.getElementById('result').innerText =
                    data.message;

            } catch (error) {

                document.getElementById('result').innerText =
                    'Connection failed: ' + error;

            }

        }
    </script>

</body>
</html>