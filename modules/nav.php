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

<div class="popup_background" id="popup_background">
    <div class="popup accent-border" id="new_popup">
        <div class="name">
            <h2>Create a New project</h2>
            <span class="close_button" onclick="document.getElementById('popup_background').style.display='none'; document.getElementById('new_popup').style.display='none'"><i class="fas fa-times"></i></span>
        </div>
        <div class="body">
            <form id="new_project" method="post">
                <input id="new_name" type="text" name="new_name" placeholder="Project title">
                <textarea class="new_body" id="new_body_markdown" name="new_body" placeholder="Project brief" style="display: none;"></textarea>
                <div class="new_body" id="new_body_html">
                </div>
            </form>
        </div>
        <div class="confirm_cancel_buttons">
            <span>Preview</span>
            <button>Save</button>
        </div>
    </div>
</div>

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
</div>