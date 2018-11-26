<?php
$education = 'https://utdanning.no/data/atom/utdanningsbeskrivelse';
$profession = 'https://utdanning.no/data/atom/yrke';
//$hxml = simplexml_load_file($weather);

$xml = new DOMDocument();
$xml->load($profession);

$xmlUtdanning = new DOMDocument();
$xmlUtdanning->load($education);

$entryUtdanning = $xmlUtdanning->getElementsByTagName("entry");

$xml_file_utdanning = 'utdanning_yrke.xml';
$handle = fopen($xml_file_utdanning, 'w') or die('Cannot open file:  '.$xml_file_utdanning);
$append = fopen($xml_file_utdanning, 'a') or die('Cannot open file:  '.$xml_file_utdanning);
$header = '<?xml version="1.0" encoding="utf-8"?>'."\n";
fwrite($handle, $header);
$mainTag = '<main>'."\n";
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




$entries = $xml->getElementsByTagName("entry");


for ($i = 0; $i < $entries->length; $i++ ) {
    $secondTag = "  ".'<yrker>'."\n";
    fwrite($append, $secondTag);

    $title = $xml->getElementsByTagName("title");
    $mainTitle = $title->item($i+1);

    $entries = $xml->getElementsByTagName("content");
    $mainEntry = $entries->item($i);

    if(!empty($mainTitle1->nodeValue)){
      $uts = "    ".'<yrkesTittel>';
      $uti = $mainTitle->nodeValue;
      $utss = '</yrkesTittel>'."\n";
      $line1 = $uts. $uti. $utss;
      fwrite($append, $line1);
    }

    if(!empty($mainTitle1->nodeValue)){
      $uts = "    ".'<yrkesBeskrivelse>';
      $uti = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $mainEntry->nodeValue);
      $utss = '</yrkesBeskrivelse>'."\n";
      $line1 = $uts. $uti. $utss;
      fwrite($append, $line1);
    }

    $secondTagEnd = "  ".'</yrker>'."\n";
    fwrite($append, $secondTagEnd);
}

$mainTagEnd = '</main>';
fwrite($append, $mainTagEnd);
fclose($handle);
fclose($append);
?>