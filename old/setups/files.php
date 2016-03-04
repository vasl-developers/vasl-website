<?
require_once "dropbox-sdk/Dropbox/autoload.php";
use \Dropbox as dbx;
$appInfo = dbx\AppInfo::loadFromJsonFile("app-info.json");
$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");
$accessToken = "twlvL0sgj80AAAAAAAIDYKq9JYCg7K4Z_DDV5-ZvpuyzdMVEfevBV15eyUYEPpVu";
$dbxClient = new dbx\Client($accessToken, "PHP-Example/1.0");
$dropbox = "/VASL Scenarios";

$debug = false;
$baseDir = getcwd();
if(!is_dir($baseDir.$dropbox)) mkdir($baseDir.$dropbox, 0777, true);
chdir($baseDir.$dropbox);

$scenarios = [];

$folderMetadata = $dbxClient->getMetadataWithChildren($dropbox);
folderDive($folderMetadata);

function folderDive($folderMetadata) {
  global $scenarios, $dbxClient, $baseDir, $dropbox, $debug;
  foreach ($folderMetadata[contents] as &$folder) {
    if($folder[is_dir] == 1) {
      $subFolder = $folder[path];
      if($subFolder != $dropbox."/.git") {
        $f = sanitize($baseDir.$subFolder);
        if($debug) print_r("<br/>".$f);
        if(!is_dir($f)) mkdir($f, 0777, true);
        chdir($f);
        $path_parts = pathinfo($subFolder);
        if($debug) print_r("<br/>".$path_parts['basename']);
        addToArray($folder[path]);
        $subfolderMetadata = $dbxClient->getMetadataWithChildren($subFolder);
        folderDive($subfolderMetadata);
      }
    } else {
      $vsav = $folder[path];
      $path_parts = pathinfo($vsav);
      if($path_parts['extension'] == "vsav") {
        if($debug) echo "<br/>".getcwd()."/".$path_parts['basename'];
        $f = getcwd()."/".$path_parts['basename'];
        addToArray($f);
        if(file_exists($f)) {
          $timestamp = strtotime($fileMetadata[modified]);
          if($timestamp > filemtime($f)) {
            saveFile($f, $vsav);
          }
        } else {
          echo "<br/>".getcwd()."/".$path_parts['basename'];
          saveFile($f, $vsav);
        }
      }
    }
  }
}

function sanitize($string) {
  $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "+", "[", "{", "]",
                 "}", "|", ";", ":", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                 "—", "–", ",", "<", ">", "?");
  $clean = trim(str_replace($strip, "", strip_tags($string)));
  return $clean;
}

function addToArray($path) {
  global $scenarios;
  $exploded = explode("/", $path);
  $temp = &$scenarios;
  foreach($exploded as $key) {
      $temp = &$temp[$key];
  }
  $temp = $value;
  unset($temp);
}

function saveFile($file, $vsav) {
  global $dbxClient;
  $f = fopen($file, "w+b");
  $fileMetadata = $dbxClient->getFile($vsav, $f);
  fclose($f);
}

if($debug) {
  echo "<br/><br/>";
  var_dump($scenarios);
}


$path = realpath($baseDir);
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
foreach($objects as $name => $object){
    echo "$name\n";
}
?>