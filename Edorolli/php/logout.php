<?php
session_start();
session_destroy();
header("Location: http://localhost/Project-Web/Edorolli/index.php");
exit();

?>