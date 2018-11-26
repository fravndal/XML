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

//$mainEntry1 = $entryUtdanning->item(0);
//$mainTitle1 = $titleUtdanning->item(1);

$xml_file_utdanning = 'utdanning2.xml';
$handle = fopen($xml_file_utdanning, 'w') or die('Cannot open file:  '.$xml_file_utdanning);
$append = fopen($xml_file_utdanning, 'a') or die('Cannot open file:  '.$xml_file_utdanning);
$header = '<?xml version="1.0" encoding="utf-8"?>'."\n";
fwrite($handle, $header);
$mainTag = '<utdanning>'."\n";
fwrite($handle, $mainTag);

for ($i = 0; $i < $entryUtdanning->length; $i++) {
    $secondTag = "  ".'<utdanninger>'."\n";
    fwrite($append, $secondTag);

    $title = $xmlUtdanning->getElementsByTagName("title");
    $mainTitle1 = $title->item($i+1);

    $entries1 = $xmlUtdanning->getElementsByTagName("content");
    $mainEntry1 = $entries1->item($i);

    $prereq = $xmlUtdanning->getElementsByTagName("field_formal_prerequisites");
    $prereq1 = $prereq->item($i);

    if(!empty($mainTitle1->nodeValue)){
      $uts = "    ".'<utdanningTittel>';
      $uti = $mainTitle1->nodeValue;
      $utss = '</utdanningTittel>'."\n";
      $line1 = $uts. $uti. $utss;
      fwrite($append, $line1);
    }
    
    if(!empty($mainEntry1->nodeValue)) {
      $ubs = "    ".'<utdanningBeskrivelse>';
      $ubi = $mainEntry1->nodeValue;
      $ubss = '</utdanningBeskrivelse>'."\n";
      $line2 = $ubs. $ubi. $ubss;
      fwrite($append, $line2);
    }
    
    if(!empty($prereq1->nodeValue)){
      $fks = "    ".'<formelleKrav>';
      $fpi = $prereq1->nodeValue;
      $fpss = '</formelleKrav>'."\n";
      $line3 = $fks. $fpi. $fpss;     
      fwrite($append, $line3);
    }
    
    $secondTagEnd = "  ".'</utdanninger>'."\n";
    fwrite($append, $secondTagEnd);
}
$mainTagEnd = '</utdanning>';
fwrite($append, $mainTagEnd);
fclose($handle);
fclose($append);



$entries = $xml->getElementsByTagName("entry");

$mainEntry = $entries->item(0);

$mainTitle = $title->item(1);

//echo $mainTitle->nodeValue . "\n";
//echo $mainEntry->nodeValue, PHP_EOL;

$xml_file_yrke = 'yrke2.xml';
$handle = fopen($xml_file_yrke, 'w') or die('Cannot open file:  '.$xml_file_yrke);
$append = fopen($xml_file_yrke, 'a') or die('Cannot open file:  '.$xml_file_yrke);
$header = '<?xml version="1.0" encoding="utf-8"?>'."\n";
fwrite($handle, $header);
$mainTag = '<yrke>'."\n";
fwrite($handle, $mainTag);

for ($i = 0; $i < $entries->length; $i++ ) {
    $secondTag = "  ".'<yrker>'."\n";
    fwrite($append, $secondTag);
    $title = $xml->getElementsByTagName("title");
    $mainTitle = $title->item($i+1);
//    echo $mainTitle->nodeValue, PHP_EOL;

    $entries = $xml->getElementsByTagName("content");
    $mainEntry = $entries->item($i);
//    $strip = strip_tags($mainEntry, '<link><author><content>');
//    echo $mainEntry->nodeValue, PHP_EOL;



    if(!empty($mainTitle1->nodeValue)){
      $uts = "    ".'<yrkesTittel>';
      $uti = $mainTitle->nodeValue;
      $utss = '</yrkesTittel>'."\n";
      $line1 = $uts. $uti. $utss;
      fwrite($append, $line1);
    }

    if(!empty($mainTitle1->nodeValue)){
      $uts = "    ".'<yrkesBeskrivelse>';
      $uti = $mainEntry->nodeValue;
      $utss = '</yrkesBeskrivelse>'."\n";
      $line1 = $uts. $uti. $utss;
      fwrite($append, $line1);
    }

    $secondTagEnd = "  ".'</yrker>'."\n";
    fwrite($append, $secondTagEnd);


}
$mainTagEnd = '</yrke>';
fwrite($append, $mainTagEnd);
fclose($handle);
fclose($append);

?>