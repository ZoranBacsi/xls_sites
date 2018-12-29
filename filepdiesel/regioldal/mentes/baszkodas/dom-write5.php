<?php

	require_once 'form.inc.php';
if (isset ($_POST['ok']))
{
	$dom = new DOMDocument();
	$dom->load('quotes.xml');
	$quote = $dom->createElement('quote');
	$quote->setAttribute('year', $_POST['year']);
	$phrase = $dom->createElement('phrase');
	$phraseText = $dom->createTextNode($_POST['quote']);
	$phrase->appendChild($phraseText);
	$author = $dom->createElement('author');
	$authorText = $dom->createTextNode($_POST['author']);
	$author->appendChild($authorText);
	$quote->appendChild($phrase);
	$quote->appendChild($author);
	$dom->documentElement->appendChild($quote);
	$dom->save('quotes.xml');
	echo 'Idézet mentve';
}
?>