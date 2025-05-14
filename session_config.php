<?php
// Session lifetime (30 days in seconds)
ini_set('session.gc_maxlifetime', 30 * 24 * 60 * 60);
session_set_cookie_params(30 * 24 * 60 * 60);
?>