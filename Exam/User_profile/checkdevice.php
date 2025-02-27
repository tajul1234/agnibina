<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/saad/logo1.png" type="image/png">
    <title>System Compatibility Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Set background color */
            color: #333;
            padding: 30px;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
            color: #fff;
        }
        .section {
            margin: 15px 0;
            border-bottom: 1px solid #fff;
            padding-bottom: 15px;
        }
        .toggle-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .toggle-button:hover {
            background-color: #45a049;
        }
        .hidden-content {
            display: none;
            margin-top: 15px;
            padding: 12px;
            background-color: #2e2e2e;
            border-radius: 5px;
        }
        .result {
            font-weight: bold;
            color: #ffffff;
        }
        .check-button {
            background-color: #2196F3;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
        }
        .check-button:hover {
            background-color: #0b7dda;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #ffde00;
        }
        .note {
            font-size: 14px;
            color: #f1f1f1;
        }
        /* Loading spinner */
        .loader {
            border: 4px solid #f3f3f3; /* Light grey */
            border-top: 4px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>System Compatibility Check</h1>
        
        <div class="section">
            <button class="toggle-button" onclick="toggleSection('osSection')">Check Operating System</button>
            <div id="osSection" class="hidden-content">
                <p id="osResult" class="result"></p>
                <p class="note">This shows your current Operating System.</p>
            </div>
        </div>

        <div class="section">
            <button class="toggle-button" onclick="toggleSection('browserSection')">Check Browser</button>
            <div id="browserSection" class="hidden-content">
                <p id="browserResult" class="result"></p>
                <p class="note">This shows the browser you're currently using.</p>
            </div>
        </div>

        <div class="section">
            <button class="toggle-button" onclick="toggleSection('speedSection')">Check Internet Speed</button>
            <div id="speedSection" class="hidden-content">
                <p id="speedResult" class="result">Speed result will appear here...</p>
                <button class="check-button" onclick="startSpeedTest()">Start Speed Test</button>
                <div id="loading" class="loader" style="display: none;"></div>
                <p class="note">Testing your internet speed to ensure smooth exam delivery.</p>
            </div>
        </div>

        <div class="section">
            <button class="toggle-button" onclick="toggleSection('deviceSection')">Check Camera and Microphone</button>
            <div id="deviceSection" class="hidden-content">
                <button class="check-button" onclick="checkCameraAndMic()">Test Camera & Microphone</button>
                <p id="deviceResult" class="result"></p>
                <p class="note">Ensure your camera and microphone are functioning properly for online exams.</p>
            </div>
        </div>

        <div class="section">
            <button class="toggle-button" onclick="toggleSection('ramSection')">Check RAM and Processor</button>
            <div id="ramSection" class="hidden-content">
                <p id="ramResult" class="result">RAM and Processor check is a placeholder. Ensure you have at least 4GB of RAM and a modern processor.</p>
            </div>
        </div>

        <div class="section">
            <button class="toggle-button" onclick="toggleSection('resolutionSection')">Check Screen Resolution</button>
            <div id="resolutionSection" class="hidden-content">
                <p id="resolutionResult" class="result">Your screen resolution: <span id="screenRes"></span></p>
                <p class="note">Ensure your screen resolution meets the minimum requirement for the exam.</p>
            </div>
        </div>

    </div>

    <script>
        // Toggle the visibility of content sections
        function toggleSection(sectionId) {
            var section = document.getElementById(sectionId);
            if (section.style.display === "none" || section.style.display === "") {
                section.style.display = "block";
            } else {
                section.style.display = "none";
            }
        }

        // Checking Operating System
        document.getElementById("osResult").innerHTML = "Your operating system: " + navigator.platform;

        // Checking Browser
        document.getElementById("browserResult").innerHTML = "Your browser: " + navigator.userAgent;

        // Start the Internet Speed Test
        function startSpeedTest() {
            const speedResult = document.getElementById("speedResult");
            const loader = document.getElementById("loading");
            speedResult.innerHTML = "Testing speed...";
            loader.style.display = "inline-block"; // Show loading spinner

            // Test speed continuously every second
            setInterval(() => {
                fetchSpeedTest();
            }, 1000); // every second
        }

        // Function to fetch speed
        function fetchSpeedTest() {
            const startTime = Date.now();

            fetch('https://www.google.com', { mode: 'no-cors' })
                .then(() => {
                    const endTime = Date.now();
                    const duration = endTime - startTime; // Time taken for the request

                    // Calculate speed in Mbps
                    const speed = (1000 / duration).toFixed(2); // Speed in Mbps (Approx)

                    // Display the updated speed
                    document.getElementById("speedResult").innerHTML = `Your internet speed is approximately ${speed} Mbps.`;
                    document.getElementById("loading").style.display = "none"; // Hide loader
                })
                .catch(() => {
                    document.getElementById("speedResult").innerHTML = "Error checking internet speed.";
                    document.getElementById("loading").style.display = "none"; // Hide loader
                });
        }

        // Checking Camera and Microphone
        function checkCameraAndMic() {
            navigator.mediaDevices.getUserMedia({ video: true, audio: true })
                .then(function (stream) {
                    document.getElementById("deviceResult").innerHTML = "Camera and Microphone are working!";
                    stream.getTracks().forEach(track => track.stop()); // Stop the stream
                })
                .catch(function (error) {
                    document.getElementById("deviceResult").innerHTML = "Camera or Microphone not detected!";
                });
        }

        // Checking Screen Resolution
        var resolution = window.screen.width + "x" + window.screen.height;
        document.getElementById("screenRes").innerText = resolution;
    </script>

</body>
</html>
