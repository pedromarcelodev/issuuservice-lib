<?php

require('../../bootstrap.php');


$instance = new IssuuDocument('jil7ll5cg2cwm93kg6xlsc1x9apdeyh7', '8agoiu10igdyw7azj9b8rvi0otyja6gj');
$response = $instance->upload(array('name' => 'test-unit', 'title' => "Pedro Marcelo de Sá Alves"));
echo "<title>";
echo $response['stat'];

if ($response['stat'] == 'ok')
{
	sleep(10);
	$response = $instance->delete(array(
		'names' => $response['document']->name
	));
	echo $response['stat'];
}
echo "</title>";