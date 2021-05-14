<?php
require_once 'class/SessionClass.php';
SessionClass::getSessionInstance();
if (! isset($_SESSION ["adminId"])) {
    header("Location: not.php");
    exit();
}
