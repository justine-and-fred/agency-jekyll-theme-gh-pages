<?php
 /**
  * ShowKase server compatibility test
  *
  * @package skTest
  * @author Jack Hardie {@link http://www.jhardie.com}
  * @version build 120308
  * @copyright Copyright (c) 2012, SimpleViewer Inc
  */
  ob_start();
  @ini_set('display_errors', 1);
  error_reporting(E_ALL);
?>
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
      #navsessionstart a:link, #navsessionstart a:visited {
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
        <h2>Session Test 2</h2>
        <?php
          if (isset($_GET['sessionSet'])) {
              $overall = true;
              $testMessage = '<p class="bad">Cannot read test data.</p>';
              print '<p>The test program will now check if your server has stored the session data correctly.</p>';
              print '<div id="filetests">';
              print '<p>Attempting to re-start the session&hellip;</p>';
              //ini_set('session.save_path', 'garbage');
              session_start();
              print '<p>Checking for stored test data&hellip;</p>';
              if (!isset($_SESSION['sessionTestMessage'])) {
                  $overall = false;
              }
              else {
                  print '<p>Reading test data&hellip;</p>';
                  $testMessage = $_SESSION['sessionTestMessage'];
              } 
              print $testMessage;
              print '</div>';
              print $overall 
                  ? '<p class="good">Success: your server supports sessions.</p>'
                  : '<p class="bad">Your server does not appear to be set-up for sessions: contact your server admin/helpdesk</p>';
            }
            else {
                print 'This is the second part of a two-part test. You must visit the <a href="sessionstart.php">first part of the test</a> and then  follow the link to come back here.';
            }
            ob_end_flush();
            error_reporting(0);
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