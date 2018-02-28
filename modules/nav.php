<?php 

    // Comment @mentions
    $mention_array = $db->query('SELECT PROJECT_ID, COMMENT_DATE, COMMENT_CONTENT FROM comments WHERE COMMENT_CONTENT LIKE("%@' . $me . '%") AND COMMENT_DISMISSED="FALSE"');
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
<div class="nav very-dark">
    <h1 class="accent-font"><a href="/" style="text-decoration: none; color: inherit;">Working Title</a> <span class="white-font">|</span> <span class="medium-font">All Projects</span></h1>
    <div class="nav-buttons">
    	<ul>
    		<li><span class="comment_button accent-font"><i class="<?php echo $mention_icon; ?>" title="<?php echo $mention_message; ?>" aria-hidden="true"></i></span></li>
    		<li><span class="accent-font"><i class="fas fa-plus" aria-hidden="true" title="New project"></i></span></li>
    		<li><span class="medium-font"><i class="fa fa-chart-line" aria-hidden="true" title="Coming soon: Reports"></i></span></li>
    		<li><span class="medium-font"><i class="fa fa-share-square" aria-hidden="true" title="Coming soon: Export summary"></i></span></li>
    	</ul>
    </div>
</div>