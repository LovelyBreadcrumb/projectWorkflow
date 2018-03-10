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
         <div class="search_menu">
            <div class="search">
                <!-- Search by title -->
                <form method="post">
                    <button id="search_button" class="button accent" action="submit"><i class="far fa-save fa-2x" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
        <div class="container">

            <!-- @Dec: Put all your code here -->

            <div class="tile white" style="width: 100%">
                
                <div class="accent-border" style="width: 100%; height: 2em; border-bottom: 1px solid #cecece">

                    <div style="width:1em; height: 100%; background: #a5a5a5; margin-left: -1em; float: left;">
                        
                        <img style="height: 50%; position: relative; transform: translateY(50%);" src="https://d30y9cdsu7xlg0.cloudfront.net/png/344330-200.png">

                    </div>

                    <a href="project.php?id=' .  $project_id . '">
                        <h2 style="font-size: 1.2em; line-height: 0.2em; margin-left: 0.5em;">Test</h2>
                    </a>
                </div>

                <table style="height: 5em; width: 100%;" >
                <tbody>
                <tr>
                <td style="width: 40%; border-right: 1px solid #cecece;">&nbsp;</td>
                <td style="width: 15%; border-right: 1px solid #cecece;">&nbsp;</td>
                <td style="border-right: 1px solid #cecece;">
                    <select name="select2" multiple="multiple">
                        <option value="11">eleven</option>
                        <option value="12">twelve</option>
                        <option value="13">thirette</option>
                        <option value="14">fourteen</option>
                        <option value="15">fifteen</option>
                        <option value="16">sixteen</option>
                        <option value="17">seventeen</option>
                        <option value="18">eighteen</option>
                        <option value="19">nineteen</option>
                        <option value="20">twenty</option>
                      </select> 
                </td>
                <td>&nbsp;</td>
                </tr>
                </tbody>
                </table>

            </div>

            <div class="tile white" style="height: 20em; width: 100%">
                
                <div class="accent-border" style="width: 100%; height: 2em; border-bottom: 1px solid #969696;">

                <table style="height: 1.5em; width: 100%;" >
                    <tbody>
                    <tr>
                    <td style="width: 55%; border-right: 1px solid #cecece;">      
                        <a href="project.php?id=' .  $project_id . '">
                        <h2 style="font-size: 1.2em; line-height: 1.4em; margin: 0 0 0 0.5em;">Brief</h2>
                        </a>
                    </td>

                    <td style="width: 6.5%;">
                        <a>
                        <h2 style="font-size: 1.2em; line-height: 1.4em; margin: 0 0.5em 0 0.5em;">Preset:</h2>
                        </a>
                    </td>

                    <td style="width: 20.5%; border-right: 1px solid #cecece;">

                    <form style="margin: 0;" action="/test.php">
                              <select style="width: 15em;" name="preset">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                              </select>
                              <input type="submit">
                            </form>

                    </td>

                    <td style="width: 9%; border-right: 1px solid #cecece;">
                        
                    </td>

                    <td style="width: 9%;">&nbsp;</td>
                    </tr>
                    </tbody>
                </table>

                </div>

                <div>

                <textarea id="brief_markdown" style="width: 100%; height: 21.5em; border: none; resize: none; display: none">### test</textarea>
                
                <div id="brief_html" style="width: 100%; height: 19em; border: none; overflow-y: auto; display: block">
                    <img src="http://via.placeholder.com/350x150" onload="convert('brief_markdown', 'brief_html')">
                </div>

                <a id="edit_link" onclick="
                    document.getElementById('brief_markdown').style.display = 'block';
                    document.getElementById('brief_html').style.display = 'none';
                    document.getElementById('edit_link').style.display = 'none';
                    document.getElementById('preview_link').style.display = 'block'"
                    >Edit</a>
                <a id="preview_link" style="display: none" onclick="
                    document.getElementById('brief_markdown').style.display = 'none';
                    document.getElementById('brief_html').style.display = 'block';
                    document.getElementById('preview_link').style.display = 'none';
                    document.getElementById('edit_link').style.display = 'inline-block';
                    convert('brief_markdown', 'brief_html');">Preview</a>
                    

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