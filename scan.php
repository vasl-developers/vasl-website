<?
$baseDir = getcwd();
$dropbox = "/setups/VASL Scenarios";
$path = realpath($baseDir.$dropbox);
$debug = false;
$files = [];

$results = [];
if(is_dir($path)) {
    $iterator = new RecursiveDirectoryIterator($path);
    foreach ( new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file ) {
        if ($file->isFile()) {
            $thispath = str_replace('\\', '/', $file);
            $thisfile = utf8_encode($file->getFilename());
            if($thisfile != 'error_log') {
              $files[$thisfile] = $thispath;
              $results = array_merge_recursive($results, pathToArray($thispath));
            } else {
              unlink($file);
            }
        }
    }
}

function pathToArray($path , $separator = '/') {
  if (($pos = strpos($path, $separator)) === false) {
    return array($path);
  }
  return array(substr($path, 0, $pos) => pathToArray(substr($path, $pos + 1)));
}

function sanitize($string) {
  $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "=", "+", "[", "{", "]",
                 "}", "|", ";", ":", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                 " ", "—", "–", ",", "<", ">", "?");
  $clean = trim(str_replace($strip, "", strip_tags($string)));
  return $clean;
}

$array = $results[""]["home3"]["samt88"]["public_html"]["vasl.info"]["setups"]["VASL Scenarios"];

function scanner($arr, $lv) {
  asort($arr);
  foreach ($arr as $key => $val) {
    //echo "<br>";
    if(is_array($val)) {
      echo "<h{$lv}>".$key."</h{$lv}>";
      echo '<ul class="list-unstyled">';
      scanner($val, $lv+1);
      echo '</ul>';
    } else {
      echo vsav($val);
    }
  }
}

function vsav($file) {
  global $files, $baseDir;
  $path = $files[$file];
  if (substr($path, 0, strlen($baseDir)) == $baseDir) {
    $path = "http://".$_SERVER['SERVER_NAME'].substr($path, strlen($baseDir));
  }
  echo "<li><a href='{$path}' rel='nofollow'>{$file}</a></li>";
}

$lv = 2;
scanner($array, $lv);
//echo "<pre>";
//print_r($files);
?>
<!--
<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
  <ul id="myTab" class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Home</a></li>
    <li role="presentation" class=""><a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">Profile</a></li>
    <li role="presentation" class="dropdown">
      <a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Dropdown <span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
        <li class=""><a href="#dropdown1" tabindex="-1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1" aria-expanded="false">@fat</a></li>
        <li class=""><a href="#dropdown2" tabindex="-1" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2" aria-expanded="false">@mdo</a></li>
      </ul>
    </li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
      <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
      <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit. Keytar helvetica VHS salvia yr, vero magna velit sapiente labore stumptown. Vegan fanny pack odio cillum wes anderson 8-bit, sustainable jean shorts beard ut DIY ethical culpa terry richardson biodiesel. Art party scenester stumptown, tumblr butcher vero sint qui sapiente accusamus tattooed echo park.</p>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="dropdown1" aria-labelledby="dropdown1-tab">
      <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
    </div>
    <div role="tabpanel" class="tab-pane fade" id="dropdown2" aria-labelledby="dropdown2-tab">
      <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR, banh mi before they sold out farm-to-table VHS viral locavore cosby sweater. Lomo wolf viral, mustache readymade thundercats keffiyeh craft beer marfa ethical. Wolf salvia freegan, sartorial keffiyeh echo park vegan.</p>
    </div>
  </div>
</div>
-->