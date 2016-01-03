<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <title>ShowKase test program</title>
    <link href="css/dummy.css" rel="stylesheet" type="text/css" media="all" />
    <!-- Conditional comment to fix bugs in IE5 and 6 Win -->
    <!--[if lte IE 6]>
      <link href="css/ielte6.css" rel="stylesheet" type="text/css" media="all" />
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
      .warning
      {
        color: #EF6421;
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
      #navfiles a:link, #navfiles a:visited {
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
  $openBasedir = @ini_get("open_basedir");
  ?>
    <div id="wrapper">
      <div id="header">
        <div id="navigation">
          <ul>
            <li id="navbasic"><a href="index.php">Basic tests</a></li>
            <li id="navfiles"><a href="filetest.php">File tests</a></li>
            <li id="navsessionstart"><a href="sessionstart.php">Session tests</a></li>
            <li id="help"><a target="_blank" href="http://www.showkase.net/support/sktest/" title="link to web site">Help</a></li>
          </ul>
        </div>      
      </div>
      <div id="content">
        <h2>File handling tests</h2>
        <?php
            define('TEST_SOURCE', 'master'.DIRECTORY_SEPARATOR);
            define('TEST_DIRECTORY', 'g1'.DIRECTORY_SEPARATOR);
            define('TEST_FILE', 'gallery.xml');
            $overall = true;
            if ($openBasedir == '') {
                print '<p class="good">No base directory restriction.</p>';
            } else {
                print '<p class="warning">Warning: a base directory restriction is in effect on your server. This may cause problems reading and writing files (open_basedir = '.$openBasedir.').';
            }
            print '<p>The test program will now carry-out a few file operations. If these produce any error messages then you should check the permissions on the &lsquo;sktest&rsquo; folder and all of its contents and then run the test program again. See the <a target="_blank" href="#" title="link to web site">help document</a> for information on file permissions.</p>';
            print '<div id="filetests">';
            if (file_exists(TEST_DIRECTORY)) unlink(TEST_DIRECTORY.TEST_FILE);
            if (file_exists(TEST_DIRECTORY)) rmdir(TEST_DIRECTORY);
            print '<p>Attempting to create test folder <em>'.TEST_DIRECTORY.'</em>&hellip;</p>';
            $result = mkdir(TEST_DIRECTORY);
            $message = ($result !== false) ? '<p class="good">Created test folder with permissions '.substr(sprintf('%o', fileperms(TEST_DIRECTORY)), -4).'</p>' : '<p class="bad">Failed to create test folder</p>';
            $overall = $overall && ($result !== false);
            print $message;
            print '<p>Attempting to copy test file <em>'.TEST_FILE.'</em>&hellip;</p>';
            $result = copy(TEST_SOURCE.TEST_FILE, TEST_DIRECTORY.TEST_FILE);
            $message =  ($result !== false) ? '<p class="good">Copied test file</p>' : '<p class="bad">Failed to copy test file</p>';
            $overall = $overall && ($result !== false);
            print $message;
            print '<p>Attempting to read contents of test file <em>'.TEST_FILE.'</em>&hellip;</p>';
            $contents = file_get_contents(TEST_DIRECTORY.TEST_FILE);
            $message =  ($contents !== false) ? '<p class="good">Read test file</p>' : '<p class="bad">Failed to read test file</p>';
            $overall = $overall && ($contents !== false);
            print $message;
            print '<p>Attempting to open test file <em>'.TEST_FILE.'</em> for writing &hellip;</p>';
            $handle =  fopen(TEST_DIRECTORY.TEST_FILE, 'w');
            $message =  ($handle !== false) ? '<p class="good">Opened test file</p>' : '<p class="bad">Failed to open test file</p>';
            $overall = $overall && ($handle !== false);
            print $message;
            print '<p>Attempting to write to test file <em>'.TEST_FILE.'</em>&hellip;</p>';
            $result = fwrite($handle, $contents);
            $message =  (($result !== false)&&($result != 0)) ? '<p class="good">Successfully written to test file</p>' : '<p class="bad">Failed to write to test file</p>';
            $overall = $overall && ($result !== false);
            print $message;
            print '<p>Deleting test files &hellip;</p>';
            fclose($handle);
            if (file_exists(TEST_DIRECTORY.TEST_FILE)) unlink(TEST_DIRECTORY.TEST_FILE);
            if (file_exists(TEST_DIRECTORY)) rmdir(TEST_DIRECTORY);
            print '</div>';
            $message = $overall ? '<p class="good">Success: your file and folder permissions appear to be ok. You can now test that your server supports <a href="sessionstart.php" title="session test 1">sessions</a>.</p>' : '<p class="bad">Problems with some file operations: please check file and folder permissions</p>';
            print $message;
        ?>     
      </div>
      <div id="footer">
        <p class="tip">Tip: remove all test programs from your server after use</p>
        <p class="copyright">&copy; 2012 SimpleViewer Inc</p>
        <br class="clearboth" />  
      </div>
    </div>
  </body>
</html>