<?php
namespace App\Http\Controllers;

use \DOMDocument;

class urlsize extends Controller
{

public function curl_data($remotefile)
{
 $ch = curl_init($remotefile);
 curl_setopt($ch, CURLOPT_NOBODY, true);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HEADER, true);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
 $data = curl_exec($ch);
 curl_close($ch);
 return $data;
}
//gives size of the url provided
public function get_size($remoteFile)
{
 $contentLength = 'unknown';
 $data=$this->curl_data($remoteFile);
 if ($data === false)
 {
   echo "cURL failed\n";
   $contentLength='unknown';
 }



 //matches with the regex pattern for given HTTP: url and returns the match
 if (preg_match('/Content-Length: (\d+)/', $data, $matches))
 {
   $contentLength = (int)$matches[1];
 }
   return $contentLength;
}
//gives status of the url provided
public function get_status($remotefile)
{
 $status = 'unknown';
 $data=$this->curl_data($remotefile);
 if ($data === false)
 {
   echo 'cURL failed';
   exit;
 }
 //matches with the regex pattern for given HTTP: url and returns the match
 if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $data, $matches))
 {
   $status = (int)$matches[1];
   return $status;
 }
}
//returns size in readable format
public function human_filesize($bytes, $decimals = 2)
{
 $sz = 'BKMGTP';
 $factor = floor((strlen($bytes) - 1) / 3);
 return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

public function link_colllect($url)
{
 $pUrl = parse_url($url);

 // Load the HTML into a DOMDocument
 $doc = new DOMDocument;
 @$doc->loadHTMLFile($url);

 // Look for all the 'a' elements
 $links = $doc->getElementsByTagName('a');

 $numLinks = 0;
 foreach ($links as $link)
 {

   // Exclude if not a link or has 'nofollow'
   preg_match_all('/\S+/', strtolower($link->getAttribute('rel')), $rel);
   if (!$link->hasAttribute('href') || in_array('nofollow', $rel[0]))
   {
     continue;
   }

   // Exclude if internal link
   $href = $link->getAttribute('href');

   if (substr($href, 0, 2) === '//')
   {
     // Deal with protocol relative URLs as found on Wikipedia
     $href = $pUrl['scheme'] . ':' . $href;
   }

   $pHref = @parse_url($href);
   if (!$pHref || !isset($pHref['host']) || strtolower($pHref['host'])
   === strtolower($pUrl['host']))
   {
     continue;
   }

   // Increment counter otherwise
   //echo 'URL: ' . $link->getAttribute('href') . "\n";
   $linkarray[]=$link->getAttribute('href');
   $numLinks++;
   //echo $numLinks;
 }
   return $linkarray;
}
public function js_colllect($url)
{

 $linkarray[] = array();
 // Load the HTML into a DOMDocument
 $doc = new DOMDocument;
 @$doc->loadHTMLFile($url);

 // Look for all the 'script' elements
 $links = $doc->getElementsByTagName('script');

 $numLinks = 0;
 foreach ($links as $link)
 {

   $href = $link->getAttribute('src');

   if (!empty($href))
   {
     $linkarray[$numLinks]=$href;
   }
   $numLinks++;
   //echo $numLinks;
 }
   return $linkarray;
   //return $links;
}

public function css_colllect($url)
{
 //$pUrl = parse_url($url);
 $linkarray[] = array();
 // Load the HTML into a DOMDocument
 $doc = new DOMDocument;
 @$doc->loadHTMLFile($url);

 // Look for all the 'link' elements
 $links = $doc->getElementsByTagName('link');

 $numLinks = 0;
 foreach ($links as $link)
 {
$href = $link->getAttribute('href');
   if (!empty($href))
   {
     $linkarray[$numLinks]=$href;
   }
   $numLinks++;
   //echo $numLinks;
 }
   return $linkarray;
   //return $links;

}
}
