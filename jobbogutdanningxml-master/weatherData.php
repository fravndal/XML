<?php
//$weather = 'https://utdanning.no/data/atom/yrke';

//$hxml = simplexml_load_file($weather);

$xml = new DOMDocument();
$xml->load("yrke.xml");

$xmlUtdanning = new DOMDocument();
$xmlUtdanning->load("utdanning.xml");

$elm = new DOMDocument();
$elm->load("forecast.xsl");
$xslt = new XSLTProcessor();
$xslt->importStylesheet($elm);
//echo $resultat = $xslt->transformToXML($xml);

$entryUtdanning = $xmlUtdanning->getElementsByTagName("entry");
$titleUtdanning = $xmlUtdanning->getElementsByTagName("title");

$mainEntry1 = $entryUtdanning->item(0);
$mainTitle1 = $titleUtdanning->item(1);

$xml_file_yrke = 'yrke2.xml';
$handle = fopen($xml_file_yrke, 'w') or die('Cannot open file:  '.$xml_file_yrke);
$append = fopen($xml_file_yrke, 'a') or die('Cannot open file:  '.$xml_file_yrke);
$header = '<?xml version="1.0" encoding="utf-8"?>'."\n";
fwrite($handle, $header);

for ($i = 0; $i < $entryUtdanning->length; $i++) {
    $title = $xmlUtdanning->getElementsByTagName("title");

    $mainTitle1 = $titleUtdanning->item($i+1);
    $entries1 = $xmlUtdanning->getElementsByTagName("content");
    $mainEntry1 = $entries1->item($i);
    
    $uts = '<utdanningTittel>';
    $uti = $mainTitle1->nodeValue;
    $utss = '</utdanningTittel>'."\n";
    $line1 = $uts. $uti. $utss;
    fwrite($append, $line1);

    $ubs = '<utdanningBeskrivelse>';
    $ubi = $mainEntry1->nodeValue;
    $ubss = '</utdanningBeskrivelse>'."\n";
    $line2 = $ubs. $ubi. $ubss;
    fwrite($append, $line2);
}
fclose($handle);
fclose($append);

$entry = $xml->getElementsByTagName("feed");

$title = $xml->getElementsByTagName("title");

$entries = $xml->getElementsByTagName("entry");

$mainEntry = $entries->item(0);

$mainTitle = $title->item(1);

//echo $mainTitle->nodeValue . "\n";
//echo $mainEntry->nodeValue, PHP_EOL;

for ($i = 0; $i < $entries->length; $i++ ) {
    $title = $xml->getElementsByTagName("title");
    $mainTitle = $title->item($i+1);
//    echo $mainTitle->nodeValue, PHP_EOL;

    $entries = $xml->getElementsByTagName("entry");
    $mainEntry = $entries->item($i);
//    $strip = strip_tags($mainEntry, '<link><author><content>');
//    echo $mainEntry->nodeValue, PHP_EOL;
    echo '
<table id="jobbTable" border="1px solid black" width="30%">
  <tr>
    <td>JobbTittel</td>
    <td>', $mainTitle->nodeValue,PHP_EOL, '</td>
  </tr>
  <tr>
    <td>JobbBeskrivelse</td>
    <td>', $mainEntry->nodeValue, PHP_EOL, '</td>
  </tr>
</table>
</body>
</html>';
}

?>