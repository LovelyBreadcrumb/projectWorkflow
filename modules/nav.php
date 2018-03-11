<?php 

    // Comment @mentions
    $mention_array = $db->query('SELECT PROJECT_ID, COMMENT_DATE, COMMENT_CONTENT FROM comments WHERE (COMMENT_CONTENT LIKE("%@' . $my_username . '%") OR COMMENT_CONTENT LIKE("%@' . $my_name . '%")) AND COMMENT_DISMISSED="FALSE"');
    $mention_count = 0;
    while ( $mention = $mention_array->fetchArray() ) {
        $mention_count = $mention_count + 1;
    }
    
    if ( $mention_count > 1 ) {
        $mention_message = 'Mentioned in ' . $mention_count . ' comments';
        $mention_icon = 'fas fa-comment-alt';
    } else {
        if ( $mention_count == 1 ) {
            $mention_message = 'Mentioned in ' . $mention_count . ' comment';
            $mention_icon = 'fas fa-comment-alt';
        } else {
            $mention_message = 'Mentioned in ' . $mention_count . ' comments';
            $mention_icon = 'far fa-comment';
        }
    }
?>
<script type="text/javascript">
    // Info: https://github.com/showdownjs/showdown
    showdown.setFlavor('github');
    showdown.setOption('openLinksInNewWindow', 'true');
    showdown.setOption('ghMentionsLink', 'http://localhost:1001/project.php?id={u}');
    showdown.setOption('tasklists', 'true');
    showdown.setOption('tables', 'true');
    showdown.setOption('strikethrough', 'true');
    
    function convert(source, target) {
        var converter = new showdown.Converter();
        markdownContent = document.getElementById(source).value;
        htmlContent = converter.makeHtml(markdownContent);
        document.getElementById(target).innerHTML = htmlContent;
    }
</script>

<div class="popup_background" id="popup_background" style="display: none;">
    <div class="popup accent-border" id="new_popup" style="display: none;">
        <div class="name">
            <h2>Create a New project</h2>
            <span class="close_button" onclick="document.getElementById('popup_background').style.display='none'; document.getElementById('new_popup').style.display='none'"><i class="fas fa-times"></i></span>
        </div>
        <form method="post">
            <div class="body">
                    <input id="new_name" type="text" name="new_name" placeholder="Project title">
                    <textarea class="new_body" id="new_body_markdown" name="new_body" placeholder="Project brief"></textarea>
                    <div class="new_body" id="new_body_html" style="display: none;">
                    </div>
            </div>
            <div class="confirm_cancel_buttons">
                <div class="left">
                    Presets: <span onclick="document.getElementById('new_body_markdown').value='### Digital asset request\n\n#### Summary\n[Enter summary here]\n\n#### Required by\n[Date]\n\n#### Key stakeholders\n[Requested by & other stakeholders]\n\n#### Detailed requirements\n[Details]\n\n#### Other notes\n[Notes]'">Digital asset</span> | <span onclick="document.getElementById('new_body_markdown').value='### Main title\n\n#### Subtitle\n\n- bullet\n- point\n- list\n\n[link](www.google.co.uk)'">General request</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Type:&nbsp;
                    <select name="new_type">
                        <option value="NORMAL">Normal</option>
                        <option value="PRINT">Printed</option>
                    </select>
                </div>
                <div class="right">
                    <span id="new_preview_link" onclick="
                        document.getElementById('new_body_html').style.display='block'; 
                        document.getElementById('new_body_markdown').style.display='none';
                        document.getElementById('new_preview_link').style.display='none';
                        document.getElementById('new_edit_link').style.display='inline-block';
                        convert('new_body_markdown', 'new_body_html')
                    ">Preview</span>
                    <span id="new_edit_link" style="display: none" onclick="
                        document.getElementById('new_body_html').style.display='none'; 
                        document.getElementById('new_body_markdown').style.display='block';
                        document.getElementById('new_edit_link').style.display='none';
                        document.getElementById('new_preview_link').style.display='inline-block';
                    ">Edit</span>
                    <button>Save</button>
                </div> <!-- /right -->
            </div>
        </form>
    </div> <!-- /popup -->
</div> <!-- /popup-background -->

<div class="nav very-dark">
    <h1 class="accent-font"><a href="/" style="text-decoration: none; color: inherit;">Working Title</a> <span class="white-font">|</span> <span class="medium-font">All Projects</span></h1>
    <div class="nav-buttons">
    	<ul>
    		<li><span class="comment_button accent-font"><i class="<?php echo $mention_icon; ?>" title="<?php echo $mention_message; ?>" aria-hidden="true"></i></span></li>
    		<li><span class="accent-font" onclick="document.getElementById('new_popup').style.display='block'; document.getElementById('popup_background').style.display='flex'"><i class="fas fa-plus" aria-hidden="true" title="New project"></i></span></li>
    		<li><span class="medium-font"><i class="fa fa-chart-line" aria-hidden="true" title="Coming soon: Reports"></i></span></li>
    		<li><span class="medium-font"><i class="fa fa-share-square" aria-hidden="true" title="Coming soon: Export summary"></i></span></li>
    	</ul>
    </div>
</div> <!-- /nav -->

<?php 
    // == FORM SUBMISSION ==
    if ( isset($_POST['new_name']) ) {
        $new_project_name = $_POST['new_name'];
        $new_project_body = $_POST['new_body'];
        $new_project_type = $_POST['new_type'];

        if ( $new_project_name != '' and $new_project_body != '' ) {
            $success = $db->exec('INSERT INTO projects (PROJECT_NAME, PROJECT_BODY, PROJECT_TYPE) VALUES ("' . $new_project_name .'", "' . $new_project_body . '", "' . $new_project_type . '")');
            if ( $success ) {
                $new_project_id = $db->query('SELECT PROJECT_ID FROM projects WHERE PROJECT_NAME="' . $new_project_name . '" ORDER BY PROJECT_ID DESC LIMIT 1');
                $new_project_id = intval($new_project_id->fetchArray()[0]);
                echo '<div id="alert" class="alert good" onclick="document.getElementById(\'alert\').style.display=\'none\';">
                        <span><strong>New projet created.</strong> <a href="project.php?id=' . $new_project_id . '">Click here</a> to view, attach files and assign team members.</span>
                    </div>';

            } else {
                echo '<div id="alert" class="alert bad" onclick="document.getElementById(\'alert\').style.display=\'none\';">
                        <span><strong>Project creation failed:</strong> Unable to write to database, please try again</span>
                    </div>';
            }
        } else {
            echo '<div id="alert" class="alert bad" onclick="document.getElementById(\'alert\').style.display=\'none\';">
                        <span><strong>Project creation failed:</strong> Please enter both a project title and brief</span>
                    </div>';
        }
    }
    // == FORM SUBMISSION END ==
?>