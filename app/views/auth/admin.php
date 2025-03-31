<?php
if ($_SESSION['role'] == 0) {
    header('Location: ?action=index');
    exit;
}
?>