<?php
    include "config.php";
    session_unset();
    session_destroy();
    echo "<script>location.href = 'http://localhost/blitz/landingpage.php'</script>"
    
?>
<html