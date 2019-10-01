<?php
/**
 * Command line utility to use dompdf.
 * Can also be used with HTTP GET parameters
 * 
 * @package dompdf
 * @link    http://dompdf.github.com/
 * @author  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */

/**
 * Display command line usage
 */
function dompdf_usage() {
  $default_paper_size = DOMPDF_DEFAULT_PAPER_SIZE;
  
  echo <<<EOD
  
Usage: {$_SERVER["argv"][0]} [options] html_file

html_file can be a filename, a url if fopen_wrappers are enabled, or the '-' character to read from standard input.

Options:
 -h             Show this message
 -l             List available paper sizes
 -p size        Paper size; something like 'letter', 'A4', 'legal', etc.  
                  The default is '$default_paper_size'
 -o orientation Either 'portrait' or 'landscape'.  Default is 'portrait'
 -b path        Set the 'document root' of the html_file.  
                  Relative urls (for stylesheets) are resolved using this directory.  
                  Default is the directory of html_file.
 -f file        The output filename.  Default is the input [html_file].pdf
 -v             Verbose: display html parsing warnings and file not found errors.
 -d             Very verbose: display oodles of debugging output: every frame 
                  in the tree printed to stdout.
 -t             Comma separated list of debugging types (page-break,reflow,split)
 
EOD;
exit;
}

/**
 * Parses command line options
 * 
 * @return array The command line options
 */
function getoptions() {

  $opts = array();

  if ( $_SERVER["argc"] == 1 )
    return $opts;

  $i = 1;
  while ($i < $_SERVER["argc"]) {

    switch ($_SERVER["argv"][$i]) {

    case "--help":
    case "-h":
      $opts["h"] = true;
      $i++;
      break;

    case "-l":
      $opts["l"] = true;
      $i++;
      break;

    case "-p":
      if ( !isset($_SERVER["argv"][$i+1]) )
        die("-p switch requires a size parameter\n");
      $opts["p"] = $_SERVER["argv"][$i+1];
      $i += 2;
      break;

    case "-o":
      if ( !isset($_SERVER["argv"][$i+1]) )
        die("-o switch requires an orientation parameter\n");
      $opts["o"] = $_SERVER["argv"][$i+1];
      $i += 2;
      break;

    case "-b":
      if ( !isset($_SERVER["argv"][$i+1]) )
        die("-b switch requires a path parameter\n");
      $opts["b"] = $_SERVER["argv"][$i+1];
      $i += 2;
      break;

    case "-f":
      if ( !isset($_SERVER["argv"][$i+1]) )
        die("-f switch requires a filename parameter\n");
      $opts["f"] = $_SERVER["argv"][$i+1];
      $i += 2;
      break;

    case "-v":
      $opts["v"] = true;
      $i++;
      break;

    case "-d":
      $opts["d"] = true;
      $i++;
      break;

    case "-t":
      if ( !isset($_SERVER['argv'][$i + 1]) )
        die("-t switch requires a comma separated list of types\n");
      $opts["t"] = $_SERVER['argv'][$i+1];
      $i += 2;
      break;

   default:
      $opts["filename"] = $_SERVER["argv"][$i];
      $i++;
      break;
    }

  }
  return $opts;
}

require_once("dompdf_config.inc.php");
global $_dompdf_show_warnings, $_dompdf_debug, $_DOMPDF_DEBUG_TYPES;

$sapi = php_sapi_name();
$options = array();

switch ( $sapi ) {

 case "cli":

  $opts = getoptions();

  if ( isset($opts["h"]) || (!isset($opts["filename"]) && !isset($opts["l"])) ) {
    dompdf_usage();
    exit;
  }

  if ( isset($opts["l"]) ) {
    echo "\nUnderstood paper sizes:\n";

    foreach (array_keys(CPDF_Adapter::$PAPER_SIZES) as $size)
      echo "  " . mb_strtoupper($size) . "\n";
    exit;
  }
  $file = $opts["filename"];

  if ( isset($opts["p"]) )
    $paper = $opts["p"];
  else
    $paper = DOMPDF_DEFAULT_PAPER_SIZE;

  if ( isset($opts["o"]) )
    $orientation = $opts["o"];
  else
    $orientation = "portrait";

  if ( isset($opts["b"]) )
    $base_path = $opts["b"];

  if ( isset($opts["f"]) )
    $outfile = $opts["f"];
  else {
    if ( $file === "-" )
      $outfile = "dompdf_out.pdf";
    else
      $outfile = str_ireplace(array(".html", ".htm", ".php"), "", $file) . ".pdf";
  }

  if ( isset($opts["v"]) )
    $_dompdf_show_warnings = true;

  if ( isset($opts["d"]) ) {
    $_dompdf_show_warnings = true;
    $_dompdf_debug = true;
  }

  if ( isset($opts['t']) ) {
    $arr = split(',',$opts['t']);
    $types = array();
    foreach ($arr as $type)
      $types[ trim($type) ] = 1;
    $_DOMPDF_DEBUG_TYPES = $types;
  }
  
  $save_file = true;

  break;

 default:

  if ( isset($_GET["input_file"]) )
    $file = rawurldecode($_GET["input_file"]);
  else
    //throw new DOMPDF_Exception("An input file is required (i.e. input_file _GET variable).");
  
  if ( isset($_GET["paper"]) )
    $paper = rawurldecode($_GET["paper"]);
  else
    $paper = DOMPDF_DEFAULT_PAPER_SIZE;
  
  if ( isset($_GET["orientation"]) )
    $orientation = rawurldecode($_GET["orientation"]);
  else
    $orientation = "portrait";
  
  if ( isset($_GET["base_path"]) ) {
    $base_path = rawurldecode($_GET["base_path"]);
    $file = $base_path . $file; # Set the input file
  }  
  
  if ( isset($_GET["options"]) ) {
    $options = $_GET["options"];
  }
  
  $file_parts = explode_url($file);
  
  /* Check to see if the input file is local and, if so, that the base path falls within that specified by DOMDPF_CHROOT */
  if(($file_parts['protocol'] == '' || $file_parts['protocol'] === 'file://')) {
    $file = realpath($file);
    if ( strpos($file, DOMPDF_CHROOT) !== 0 ) {
      throw new DOMPDF_Exception("Permission denied on $file. The file could not be found under the directory specified by DOMPDF_CHROOT.");
    }
  }
  
  $outfile = "dompdf_out.pdf"; # Don't allow them to set the output file
  $save_file = false; # Don't save the file
  
  break;
}

$dompdf = new DOMPDF();


  $dompdf->load_html('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta	http-equiv="Content-Type"	content="charset=utf-8" />
    <style type="text/css">
	    * {
		  font-family: "DejaVu Sans Mono", monospace;
		}
	  </style>
<title>Unicode (UTF-8) Test</title> 
</head> 
 
<body dir="ltr"> 
 
<h1 lang="en"><small>Unicode (UTF-8) test</small></h1> 
 
<p lang="en">You can use this document to check if your browser and your installed fonts display multilingual HTML documents in <a href="http://www.unicode.org/unicode/faq/utf_bom.html#UTF8" title=" FAQ - UTF and BOM ">Unicode (UTF-8)</a> correctly.</p> 
 
<hr id="latin" class="noprint"> 
 
<h2 lang="en" class="newpage"><small>Latin extended</small></h2> 
 
<dl> 
<dt lang="en">Letters with <strong>acute</strong></dt> 
<dd>AÁ aá &nbsp; CĆ cć &nbsp; EÉ eé &nbsp; IÍ ií &nbsp; LĹ lĺ &nbsp; NŃ nń &nbsp; OÓ oó &nbsp; RŔ rŕ &nbsp; SŚ sś &nbsp; UÚ uú &nbsp; YÝ yý &nbsp; ZŹ zź</dd> 
 
<dt lang="en">Letters with <strong>apostrophe</strong> (<strong>hacek</strong>)</dt> 
<dd>dď &nbsp; LĽ lľ &nbsp; tť</dd> 
 
<dt lang="en">Letters with <strong>breve</strong></dt> 
<dd>AĂ aă &nbsp; GĞ gğ &nbsp; UŬ uŭ</dd> 
 
<dt lang="en">Letters with <strong>caron</strong> (<strong>hacek</strong>)</dt> 
<dd>CČ cč &nbsp; DĎ &nbsp; EĚ eě &nbsp; NŇ nň &nbsp; RŘ rř &nbsp; SŠ sš &nbsp; TŤ &nbsp; ZŽ zž</dd> 
 
<dt lang="en">Letters with <strong>cedilla</strong> (<strong>comma</strong>)</dt> 
<dd>CÇ cç &nbsp; GĢ gģ &nbsp; KĶ kķ &nbsp; LĻ lļ &nbsp; NŅ nņ &nbsp; RŖ rŗ &nbsp; SŞ sş &nbsp; TŢ tţ</dd> 
 
<dt lang="en">Letters with <strong>circumflex</strong></dt> 
<dd>AÂ aâ &nbsp; CĈ cĉ &nbsp; EÊ eê &nbsp; GĜ gĝ &nbsp; HĤ hĥ &nbsp; IÎ iî &nbsp; JĴ jĵ &nbsp; OÔ oô &nbsp; SŜ sŝ &nbsp; UÛ uû &nbsp; WŴ wŵ &nbsp; YŶ yŷ</dd> 
 
<dt lang="en">Letters with <strong>diaeresis</strong> (<strong>umlaut</strong>)</dt> 
<dd>AÄ aä &nbsp; EË eë &nbsp; IÏ iï &nbsp; OÖ oö &nbsp; UÜ uü &nbsp; YŸ yÿ</dd> 
 
<dt lang="en">Letters with/without <strong>dot above</strong></dt> 
<dd>CĊ cċ &nbsp; EĖ eė &nbsp; GĠ gġ &nbsp; Iİ iı &nbsp; ZŻ zż</dd> 
 
<dt lang="en">Letters with <strong>double acute</strong></dt> 
<dd>OŐ oő &nbsp; UŰ uű</dd> 
 
<dt lang="en">Letters with <strong>grave</strong></dt> 
<dd>AÀ aà &nbsp; EÈ eè &nbsp; IÌ iì &nbsp; OÒ oò &nbsp; UÙ uù</dd> 
 
<dt lang="en">Letters with <strong>horn</strong></dt> 
<dd>OƠ oơ &nbsp; UƯ uư</dd> 
 
<dt lang="en">Letters with <strong>macron</strong></dt> 
<dd>AĀ aā &nbsp; EĒ eē &nbsp; IĪ iī &nbsp; OŌ oō &nbsp; UŪ uū</dd> 
 
<dt lang="en">Letters with <strong>ogonek</strong></dt> 
<dd>AĄ aą &nbsp; EĘ eę &nbsp; IĮ iį &nbsp; UŲ uų</dd> 
 
<dt lang="en">Letters with <strong>ring above</strong></dt> 
<dd>AÅ aå &nbsp; UŮ uů</dd> 
 
<dt lang="en">Letters with <strong>stroke</strong></dt> 
<dd>DĐ dđ &nbsp; HĦ hħ &nbsp; LŁ lł &nbsp; OØ oø</dd> 
 
<dt lang="en">Letters with <strong>tilde</strong></dt> 
<dd>AÃ aã &nbsp; NÑ nñ &nbsp; OÕ oõ</dd> 
 
<dt lang="en"><strong>Ligatures</strong></dt> 
<dd>AEÆ aeæ &nbsp; OEŒ oeœ</dd> 
 
<dt lang="en"><strong>Eth</strong> &amp; <strong>Thorn</strong></dt> 
<dd>DÐ dð &nbsp; THÞ thþ</dd> 
 
<dt lang="en">German <strong>sharp s</strong> &amp; <strong>long s</strong></dt> 
<dd>ß &nbsp; ſ</dd> 
</dl> 
 
<h3 lang="en" class="noprint"><small><a href="combining-marks.html">Combining diacritical marks</a><br>&nbsp;</small></h3> 
 
<hr id="greek" class="noprint"> 
 
<h2 lang="en" class="newpage"><small><a href="greek-alphabet.html">Greek</a></small></h2> 
 
<dl> 
<dt lang="en"><strong>Capital</strong> letters</dt> 
<dd>Α Β Γ Δ Ε Ζ Η Θ Ι Κ Λ Μ Ν Ξ Ο Π Ρ Σ Τ Υ Φ Χ Ψ Ω</dd> 
 
<dt lang="en"><strong>Capital</strong> letters with <strong>tonos</strong></dt> 
<dd>Ά &nbsp; Έ &nbsp; Ή &nbsp; Ί &nbsp; Ό &nbsp; Ύ &nbsp; Ώ</dd> 
 
<dt lang="en"><strong>Capital</strong> letters with <strong>dialytika</strong></dt> 
<dd>Ϊ &nbsp; Ϋ</dd> 
 
<dt lang="en"><strong>Small</strong> letters</dt> 
<dd>α β γ δ ε ζ η θ ι κ λ μ ν ξ ο π ρ σς τ υ φ χ ψ ω</dd> 
 
<dt lang="en"><strong>Small</strong> letters with <strong>tonos</strong></dt> 
<dd>ά &nbsp; έ &nbsp; ή &nbsp; ί &nbsp; ό &nbsp; ύ &nbsp; ώ</dd> 
 
<dt lang="en"><strong>Small</strong> letters with <strong>dialytika</strong></dt> 
<dd>ϊ &nbsp; ϋ</dd> 
 
<dt lang="en"><strong>Small</strong> letters with <strong>dialytika and tonos</strong></dt> 
<dd>ΐ &nbsp; ΰ</dd> 
</dl> 
 
<hr id="cyrillic" class="noprint"> 
 
<h2 lang="en"><small><a href="cyrillic-script.html">Cyrillic</a></small></h2> 
 
<dl> 
<dt lang="en"><strong>Russian</strong> alphabet</dt> 
 
<dd>А Б В Г Д Е Ё Ж З И Й К Л М Н О П Р С Т У Ф Х Ц Ч Ш Щ Ъ Ы Ь Э Ю Я
<br>а б в г д е ё ж з и й к л м н о п р с т у ф х ц ч ш щ ъ ы ь э ю я</dd> 
 
<dt lang="en"><strong>Belarussian</strong> alphabet</dt> 
 
<dd>А Б В Г Д Е Ё Ж З І Й К Л М Н О П Р С Т У Ў Ф Х Ц Ч Ш Ы Ь Э Ю Я
<br>а б в г д е ё ж з і й к л м н о п р с т у ў ф х ц ч ш ы ь э ю я</dd> 
 
<dt lang="en"><strong>Ukrainian</strong> alphabet</dt> 
 
<dd>А Б В Г Ґ Д Е Є Ж З И І Ї Й К Л М Н О П Р С Т У Ф Х Ц Ч Ш Щ Ь Ю Я
<br>а б в г ґ д е є ж з и і ї й к л м н о п р с т у ф х ц ч ш щ ь ю я</dd> 
 
<dt lang="en"><strong>Bulgarian</strong> alphabet</dt> 
 
<dd>А Б В Г Д Е Ж З И Й К Л М Н О П Р С Т У Ф Х Ц Ч Ш Щ Ъ Ь Ю Я
<br>а б в г д е ж з и й к л м н о п р с т у ф х ц ч ш щ ъ ь ю я</dd> 
 
<dt lang="en"><strong>Macedonian</strong> alphabet</dt> 
 
<dd>А Б В Г Д Ѓ Е Ж З Ѕ И Ј К Л Љ М Н Њ О П Р С Т Ќ У Ф Х Ц Ч Џ Ш
<br>а б в г д ѓ е ж з ѕ и ј к л љ м н њ о п р с т ќ у ф х ц ч џ ш</dd> 
 
<dt lang="en"><strong>Serbian</strong> alphabet</dt> 
 
<dd>А Б В Г Д Ђ Е Ж З И Ј К Л Љ М Н Њ О П Р С Т Ћ У Ф Х Ц Ч Џ Ш
<br>а б в г д ђ е ж з и ј к л љ м н њ о п р с т ћ у ф х ц ч џ ш</dd> 
 
<dt lang="en"><strong>Mongolian</strong> alphabet</dt> 
 

<hr class="noprint"> 

<p lang="en"><br>19 February 2010</p> 
 
</body> 
</html> ');
	//$dompdf->load_html_file('test/encoding_utf-8.html');
if ( isset($base_path) ) {
  $dompdf->set_base_path($base_path);
}

$dompdf->set_paper($paper, $orientation);

$dompdf->render();

if ( $_dompdf_show_warnings ) {
  global $_dompdf_warnings;
  foreach ($_dompdf_warnings as $msg)
    echo $msg . "\n";
  echo $dompdf->get_canvas()->get_cpdf()->messages;
  flush();
}

if ( $save_file ) {
//   if ( !is_writable($outfile) )
//     throw new DOMPDF_Exception("'$outfile' is not writable.");
  if ( strtolower(DOMPDF_PDF_BACKEND) === "gd" )
    $outfile = str_replace(".pdf", ".png", $outfile);

  list($proto, $host, $path, $file) = explode_url($outfile);
  if ( $proto != "" ) // i.e. not file://
    $outfile = $file; // just save it locally, FIXME? could save it like wget: ./host/basepath/file

  $outfile = realpath(dirname($outfile)) . DIRECTORY_SEPARATOR . basename($outfile);

  if ( strpos($outfile, DOMPDF_CHROOT) !== 0 )
    throw new DOMPDF_Exception("Permission denied.");

  file_put_contents($outfile, $dompdf->output( array("compress" => 0) ));
  exit(0);
}

if ( !headers_sent() ) {
  $dompdf->stream($outfile, $options);
}
