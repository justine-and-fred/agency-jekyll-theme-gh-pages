<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <title>ShowKase test program</title>
    <link href="css/dummy.css" rel="stylesheet" type="text/css" media="all" >
    <!--[if lte IE 6]>
      <link href="css/ielte6.css" rel="stylesheet" type="text/css" media="all" >
    <![endif]-->
    <script type="text/javascript" src="scripts/external.js">
    </script>
    <style type="text/css">
      p {
        padding-right: 10px;
      }
      .good {
        color: #00AA00;
      }
      .bad {
        color: #AA0000;
      }
      em {
        color: #333333;
      }
      #filetests {
        padding-bottom: 10px;
      }
      #filetests p {
        margin-bottom: 0;
      }
      #filetests p.good, #filetests p.bad {
        margin-bottom: 0.5em;
      }
      #navigation #navbasic {
        padding-left: 11px;
      }
      #navbasic a:link, #navbasic a:visited {
        color: #3c5c7c;
      }
      #footer p.tip {
        float: left;
        display: inline;
      }
      #footer p.copyright {
        float: right;
        padding-right: 40px;
      }
    </style>

  </head>
  <body>
<?php
/**
 * ShowKase server compatibility test
 *
 * @package skTest
 * @author Jack Hardie {@link http://www.jhardie.com}
 * @version build 120308
 * @copyright Copyright (c) 2012, SimpleViewer Inc
 */
@ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Build td string for ok column
 * @param boolean test is ok
 * @return string <td>tick or cross</td>
 */
function okTd($ok)
{
    return $ok ? '<td class="good">&#10004;</td>' : '<td class="bad">&#10008;</td>';
}
  
/**
 * Get which version of GD is installed, if any.
 *
 * @return string version vector or '0' if GD not installed
 */
function getGdVersion()
{
    if (! extension_loaded('gd')) {
        return '0';
    }
    // Use the gd_info() function if possible.
    if (function_exists('gd_info')) {
        $versionInfo = gd_info();
        preg_match("/[\d\.]+/", $versionInfo['GD Version'], $matches);
        return $matches[0];
    }
    // If phpinfo() is disabled return false...
    if (preg_match('/phpinfo/', ini_get('disable_functions'))) {
        return '0';
    }
    // ...otherwise use phpinfo().
    ob_start();
    @phpinfo(8);
    $moduleInfo = ob_get_contents();
    ob_end_clean();
    if (preg_match("/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i", $moduleInfo,$matches)) {
        $gdVersion = $matches[1];
    }
    else {
        $gdVersion = '0';
    }
    return $gdVersion;
}
  
/**
 * Get absolute path to server document root
 * realpath may not be strictly necessary here, included for consistency with SiteSingleton::getDocRoot
 *
 * @return string
 */
function getDocRoot()
{
    if (isset($_SERVER['DOCUMENT_ROOT'])) {
        return realpath($_SERVER['DOCUMENT_ROOT']).DIRECTORY_SEPARATOR;
    }
    if (isset($_SERVER['SCRIPT_NAME']) && isset($_SERVER['SCRIPT_FILENAME'])) {
        return realpath(substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['SCRIPT_NAME']))).DIRECTORY_SEPARATOR;
    }
    return false;
}
?>
    <div id="wrapper">
      <div id="header">
        <div id="navigation">
          <ul>
            <li id="navbasic"><a href="index.php">Basic tests</a></li>
            <li id="navfiles"><a href="filetest.php">File tests</a></li>
            <li id="navsessionstart"><a href="sessionstart.php">Session tests</a></li>
            <li id="help"><a target="_blank" href="http://showkase.net/support/sktest/" title="link to web site">Help</a></li>
          </ul>
        </div>      
      </div>
      <div id="content">
        <h2>Basic tests</h2>
        <?php
            ini_set('error_prepend_string', '');
            ini_set('error_append_string', '');
            print '<table id="results">';
            print '<tr><th>Test</th><th>Result</th><th>OK?</th></tr>';
            $overall = true;
            $ok = version_compare(phpversion(), '5.2.0', '>=');
            $overall = $overall && $ok;
            print '<tr><td>Php version</td><td>'.phpversion().'</td>'.okTd($ok).'</tr>';
            $ok = (@ini_get("safe_mode") != 'On') && (@ini_get("safe_mode") != 1);
            $overall = $overall && $ok;
            $status = $ok ? 'off' : 'on';
            print '<tr><td>Safe mode</td><td>'.$status.'</td>'.okTd($ok).'</tr>';
            $gdVersion = getGDVersion();
            $ok = version_compare($gdVersion, '2.0', '>=');
            $overall = $overall && $ok;
            print '<tr><td>GD graphics library version</td><td>'.$gdVersion.'</td>'.okTd($ok).'</tr>';
            $ok = class_exists('DOMDocument');
            $overall = $overall && $ok;
            $status = $ok ? 'available' : 'not available';
            print '<tr><td>XML DOM functions</td><td>'.$status.'</td>'.okTd($ok).'</tr>';
            print '</table>';
            $message = $overall
                ? '<p class = "good">Success: your server meets the basic requirements to run ShowKase. You should now run the <a href="filetest.php" title = "file handling tests">file handling tests</a> to ensure that your server has the correct permissions for ShowKase to work with files and folders.</p>'
                : '<p class="bad">Sorry: your server does not meet the basic requirements to run ShowKase</p>';
            print $message;     
        ?>     
      </div>
      <div id="footer">
        <p class="tip">Tip: remove all test programs from your server after use</p>
        <p class="copyright">&copy; 2012 SimpleViewer Inc</p>
        <br class="clearboth" > 
      </div>
    </div>
  </body>
</html>