<?php
require_once 'functions.php';
start_session_if_not_started();
session_destroy();
header("Location: http://localhost/Project-Web/Edorolli/index.php");
exit();

?>