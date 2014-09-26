<?php
if (!isset($_GET['id'])) {
  die();
}
readfile('mocks/mock_' . $_GET['id'] . '.json');