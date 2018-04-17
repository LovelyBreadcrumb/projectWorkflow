<!-- List of tasks -->
<html>
    <head>
        <title>Tile | Task 0</title>
        <?php include '/modules/head.php'; ?>
        <script src="modules/showdown.min.js"></script>
    </head>
    <body class="white">
        <div class="nav black">
            <h1 class="grey-text"><span class="red-text">Tile</span> Project Planner</h1>
        </div>
        <div class="container">
            <div class="content">
                <div class="top">
                    <a href="index.php">
                        <div class="button red" title="Back" style="float: left;">
                            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a href="#">
                        <div class="button red" title="New task" style="float: right;">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a href="#">
                        <div class="button red" title="New related task" style="float: right;">
                            <i class="fa fa-link" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
                <hr />
                <div class="title grey">
                    <table>
                        <tr>
                            <td style="width: 3em"><h3>#1</h3></td>
                            <td><h2><input name="task_name" type="text" /></h2></td>
                        </tr>
                    </table>
                </div> 
                <hr />
                <div class="body">
                    BODY
                </div>
                <div class="attachments">
                    <ul>
                        <li><a href="http://via.placeholder.com/350x250&text=Placeholder" download>Attachment_001.png</a></li>
                    </ul>
                    <div class="button red" title="Add attachment" style="float: right;">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </div>
                </div>
                <hr />
                <div class="controls grey">
                    <form name="options" method="post">
                        <table>
                            <tr>
                                <td>Progress</td>
                                <td>Due date</td>
                                <td rowspan="2" class="border"></td>
                                <td>Assigned</td>
                                <td rowspan="2" class="border"></td>
                                <td style="width: 40%">Tags</td>
                            </tr>
                            <tr>
                                <td>
                                    <select name="progress">
                                        <option value="0">Not started</option>
                                        <option value="25">25%</option>
                                        <option value="50">50%</option>
                                        <option value="75" selected>75%</option>
                                        <option value="100">Complete</option>
                                    </select>
                                </td>
                                <td><input name="due" type="date" value="2018-01-22"/></td>
                                <td>
                                    Gareth M.
                                    <div class="button red" title="Assign users" style="float: right;">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                    </div>
                                </td>
                                <td class="tags">
                                    <span><i class="fa fa-tag" aria-hidden="true" style="color:#2600B2;"></i> Image</span>
                                    <div class="button red" title="Edit tags" style="float: right;">
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            <div> <!-- /content -->
        </div> <!-- /container -->
        <script>
            function toggle(element_1, element_2) {
                // console.log('e1_visibility=' + e1_visibility + ', e2_visibility=' + e2_visibility)
                if (document.getElementById(element_1).style.display == 'none') {
                    document.getElementById(element_1).style.display = 'block';
                    document.getElementById(element_2).style.display = 'none';
                } else {
                    document.getElementById(element_1).style.display = 'none';
                    document.getElementById(element_2).style.display = 'block';
                }
            }
        </script>
    </body>
</html>