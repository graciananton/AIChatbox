<?php
session_start(); # always starts the session

session_unset(); # removes elements from array

session_destroy(); # gets rid of the array

header("Location: login.php"); # moves over to the login.php page

exit; # exits
