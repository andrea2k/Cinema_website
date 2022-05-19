<?php
session_start();



echo "authenticated as:" . $_SESSION['user_id'];
