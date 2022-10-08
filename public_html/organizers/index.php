<?php
include_once "../api/index.php";
include_once "../header.php";
echoRandWallpaper();
?>
<main class="main competition-page analytics">
    <div class="top-site"></div>
    <svg style="margin-bottom: 0; position: relative; transform: translateY(85%); z-index: -1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <svg style="margin-bottom: 0; position: relative; top: 0px; z-index: 1;" xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#151515"></path></svg>
    <div class="dark section no-shadow">
        <h1 class="font size biggest"><i class="fa fa-solid fa-user margin right"></i></i>For organizers</h1>
    </div>
    <div class="light section">
        <h2>How do I get my results on roller results?</h2>
        <div style="max-width: 50rem">
            <p>You want your results to appear on roller results? We want that too. Over the years we perfectioned the process of uploading results and give you the same tools we use for importing results.</p>
            <p>You can find all the tools you need <a href="/tools/import-project.php">Here</a>.</p>
        </div>
    </div>
    <div class="dark section">
        <h2>How do I embed roller results on my Website?</h2>
        <div style="max-width: 50rem">
            <p>Any competition page on roller results can easily be embedded on your Webpage.</p>
            <br>
            <p>Contact us at <span class="code">roller.results@gmail.com</span> explain what youre after and well provide you with an API key.</p>
            <br>
            <p>Find out the competition ID of your competition. You can see it in the url bar of your browser when viewing the competition.</p>
            <br>
            <p>Embed your competition using the following code, your API key and the competition ID:</p>
            <span class="code">
                &lt;iframe src=&quot;https://www.roller-results.com/competition/?id=Your_Competition_ID&amp;apiKey=Your_API_Key&quot;&gt;&lt;/iframe&gt;
            </span>
        </div>
    </div>
    <script>
    </script>
</main>
<?php
include_once "../footer.php";
?>