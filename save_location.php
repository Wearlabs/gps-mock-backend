<?php
if (!isset($_POST['lat']) || !isset($_POST['lng']) || !isset($_POST['acc']) || !isset($_POST['id'])) {
	die("no data");
}

$data = array(
	'lat' => $_POST['lat'],
	'lng' => $_POST['lng'],
	'acc' => $_POST['acc']
);
$json = json_encode($data);
file_put_contents('mocks/mock_' . $_POST['id'] . '.json', $json);
echo "OK";
