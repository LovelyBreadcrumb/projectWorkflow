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
        <div class="nav very-dark">
            <h1 class="accent-font"><a href="/" style="text-decoration: none; color: inherit;">Working Title</a> <span class="white-font">|</span> <span class="medium-font">Project #<?php echo sprintf('%04d', $project_id); ?></span></h1>
        </div>
        <div class="container">

            <!-- @Dec: Put all your code here -->


            <!-- == COMMENTS START == -->
            <div class="comments">
                <div class="comment_list">
                    <div class="comment">
                        <div class="data system">
                            <span style="background-color: #<?php echo stringToColorCode('GM'); ?>">GM</span> left a comment - 10/02/2018
                        </div>
                        <div class="message">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris turpis tortor, elementum a justo sed, vehicula eleifend odio.
                        </div>
                    </div> <!-- /comment -->

                    <div class="comment">
                        <div class="data system">
                            <span style="background-color: #<?php echo stringToColorCode('GM'); ?>">GM</span> left a comment - 10/02/2018
                        </div>
                        <div class="message">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris turpis tortor, elementum a justo sed, vehicula eleifend odio.
                        </div>
                    </div> <!-- /comment -->
                </div>
                <div class="new_comment">
                    <div class="inputs">
                        <textarea name="message_content"></textarea>
                        <div class="buttons">
                            <button>Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- == COMMENTS END == -->

            <div class="footer">
            </div> <!-- footer -->
        </div> <!-- /container -->
    </body>
</html>