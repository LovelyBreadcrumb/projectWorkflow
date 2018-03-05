<html>
    <head>
        <title>Working Title | Project #<?php echo sprintf('%04d', $_GET['id']); ?></title>
        <?php include '/modules/head.php'; ?>
    </head>
    <body class="very-light">
        <?php
            // == INCLUDES START ==
            include 'modules/database.php';
            // == INCLUDES END ==

            $project_id = intval($_GET['id']);


            // == FORM SUBMISSION START ==
            
            // == FORM SUBMISSION END ==


            // == MAIN QUERIES START ==
            
            // == MAIN QUERIES END ==
        ?>
        <?php include "modules/nav.php"; ?>
        <div class="container">

            <!-- @Dec: Put all your code here -->

            <div class="tile white" style="width: 100%">
                
                <div class="accent-border">
                    <a href="project.php?id=' .  $project_id . '">
                        <h2>Test</h2>
                    </a>
                </div>

            </div>


            <!-- == COMMENTS START == -->
            <?php include '/modules/comments.php'; ?>
            <!-- == COMMENTS END == -->

            <div class="footer">
            </div> <!-- footer -->
        </div> <!-- /container -->
    </body>
</html>