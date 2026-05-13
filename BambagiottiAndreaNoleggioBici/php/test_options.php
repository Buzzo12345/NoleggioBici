<?php
require_once "app.php";

$repo = new app();
echo $repo->getOptionsHtml();

