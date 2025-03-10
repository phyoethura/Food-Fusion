<?php
// Header of the page
$title = "Renewable Energy Resources";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Renewable Energy Educational Resources</h1>
        <p>Explore downloadable resources, infographics, and videos to learn more about renewable energy.</p>
    </header>
    
    <main>
        <section class="resources">
            <h2>Downloadable Resources</h2>
            <ul>
                <li><a href="downloads/renewable-energy-guide.pdf" download>Renewable Energy Guide (PDF)</a></li>
                <li><a href="downloads/energy-storage-whitepaper.pdf" download>Energy Storage Whitepaper (PDF)</a></li>
                <li><a href="downloads/solar-energy-research-paper.pdf" download>Solar Energy Research Paper (PDF)</a></li>
            </ul>
        </section>

        <section class="infographics">
            <h2>Infographics</h2>
            <div class="infographic">
                <img src="images/solar-infographic.jpg" alt="Solar Energy Infographic">
                <p>Learn about how solar panels work and their efficiency.</p>
            </div>
            <div class="infographic">
                <img src="images/wind-infographic.jpg" alt="Wind Energy Infographic">
                <p>Understand wind energy, wind turbines, and their global impact.</p>
            </div>
        </section>

        <section class="videos">
            <h2>Videos</h2>
            <div class="video-container">
                <video controls>
                    <source src="videos/renewable-energy-overview.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p>Watch an overview of renewable energy technologies and trends.</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Renewable Energy Resources. All rights reserved.</p>
    </footer>

    <script src="js/scripts.js"></script>
</body>
</html>
