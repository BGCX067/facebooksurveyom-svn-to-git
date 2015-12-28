
    <div class="menu-container">
    <h4>Survey Menu</h4>
    <ul class="menu">
        <li><a href="http://apps.facebook.com/uomsurvey/">Take the survey</a></li>
        <fb:if-is-app-user>
            <li><a href="http://apps.facebook.com/uomsurvey/friends.php">Send to Friends</a></li>
            <li><a href="http://apps.facebook.com/uomsurvey/comment.php">View & Post Comments</a></li>
        <fb:else>
            <li><a href="https://graph.facebook.com/oauth/authorize?client_id=135695519794633&redirect_uri=http://apps.facebook.com/uomsurvey/friends.php&scope=publish_stream">Send to Friends</a></li>
            <li><a href="https://graph.facebook.com/oauth/authorize?client_id=135695519794633&redirect_uri=http://apps.facebook.com/uomsurvey/comment.php&scope=publish_stream">View & Post Comments</a></li>                    
        </fb:else>
        </fb:if-is-app-user>
    </ul>
    <fb:bookmark />
    <div class="disclaimer">
        <h4>Purpose of Survey</h4>
        <p><strong>Greetings dear friend</strong> first may I express my utmost gratitude for you sparing 10mins to take this survey. The data collected here will be used in my MBA thesis which is based on the effectiveness of viral marketing.</p>
    </div>
    <div class="disclaimer">
        <h4>Disclaimer</h4>
        <p>
        This survey is completely <strong>anonymous</strong>. For authenticity pourpose we do record your IP address: <?php echo $_SERVER['REMOTE_ADDR']?>
        <?php //echo $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]?>
        </p>
    </div>
    </div>