<?php

// Use in the “Post-Receive URLs” section of your GitHub repo.

if ( $_POST['payload'] ) {
    shell_exec('cd /var/www/speed-skate.org/ && git reset –hard HEAD && git pull && cd .. && ./pscript');
}

?>hi