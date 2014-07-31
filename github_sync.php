<?php
// Short script written to make syncing the website to the github
// easier. The script cant be launched @
// uberbots.org/public_html/beta/github_sync.php

    $command = "cd github_sync/;rm -rf uberbots-website/;git clone https://github.com/frc1124/uberbots-website.git;cd uberbots-website/;rm -rf .git/;rm -rf sixdegrees/;rm README.md; cp -rf * ../../";
    shell_exec($command);
?>
