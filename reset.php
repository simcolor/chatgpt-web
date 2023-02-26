<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// clear the conversation history
unset($_SESSION["history"]);
