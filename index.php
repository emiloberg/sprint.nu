<?php


/**
 * @author Emil Öberg <emil.oberg@uadm.uu.se>
 * @version 1.0
 * @create-date 2013
 * @copyright WTFPL ( http://www.wtfpl.net/ )
 *
 * This is a small script that grabs the name and release date of the current sprint
 * of a Jira installation and displays it on a web page.
 *
 * Real life demo: http://www.sprint.nu
 *
 *
 *
 * Instructions:	1) Set the username, password and url to your Jira, below.
 *                  2) Make sure $getBoardIDsMode is set to 'true';
 *                  3) Visit the page. You'll now see a list of boards (projects),
 *                     grab the [id] of the board (project) you want to display
 *                  4) put the ID number in the $jiraBoardId variable.
 *                  5) Set $getBoardIDsMode to 'false'
 *                  6) All done, visit the page!
 *
 *
 * Thanks to:       This i *very* inspired by the awesome site http://www.vecka.nu
 *
 * Fine print:		Must be run on a server where cURL is allowed.
 *
 *
 *
 */




/**
 * SETTINGS
 *
 */
$username           = '';                               //Jira username
$password           = '';                               //Jira password
$jiraUrl            = '';                               //URL to Jira
$jiraBoardId        = '';                               //The ID number of the board you want to display the sprint
                                                        //information for. To figure out the ID's available to you
                                                        //set $getBoardIDsMode (below) to true and visit the page. An
                                                        //array of all available boards will be shown. Grab the 'id'
                                                        //and put it in this variable.

$getBoardIDsMode    = false;                            //If set to true, the page will output a list of Jira Board ID's
                                                        //to put in the $jiraBoardId variable. If set to false, the page will
                                                        //normally and show the current sprint.


/**
 * DON'T CHANGE ANYTHING BELOW THIS LINE IF YOU'RE NOT SURE WHAT YOU'RE DOING
 *
 */


$url = $jiraUrl . "rest/greenhopper/1.0/xboard/work/allData/?rapidViewId=" . $jiraBoardId;

if($getBoardIDsMode) {
$url = $jiraUrl . "rest/greenhopper/1.0/rapidview";
}

$ch = curl_init();
$headers = array(
    'Accept: application/json',
    'Content-Type: application/json'
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_SSLVERSION,3); 

$result = curl_exec($ch);
$ch_error = curl_error($ch);
  
if ($ch_error) {
    echo "cURL Error: $ch_error";
    die();
} else {
    if($getBoardIDsMode) {
        print '<pre>';
        print_r(json_decode($result, true)['views']);
        print '</pre>';
        die();
    }

    $res = json_decode($result, true);
    $sprint['name'] = $res['sprintsData']['sprints'][0]['name'];
    $sprint['endDate'] = $res['sprintsData']['sprints'][0]['endDate'];
}
  
curl_close($ch);
 
?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Current Sprint</title>
<meta name="distribution" content="global">
<meta name="robots" content="follow,index">
<meta http-equiv="Content-Language" content="sv">

<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<style>
html {
height:100%
}

html,body {
margin:0;padding:0;
}

body{
text-align: center;
min-width:650px;
background-color: #90C0DE;
}

#vertical{	
position:absolute;
top:50%;	
margin-top:-130px;/* half flash height*/	
left:0;
width:100%;
}

#hoz {
width:100%;
margin-left:auto;
margin-right:auto;	
height:395px;/* flash height*/
}

h1 {
color:#fff;
margin:0;
padding:0

}

img
{
border: 0;
}
</style>
</head>
<body bgcolor="#ffffff">


<div id="vertical">   
	<div id="hoz">	
<div style="color: #066EB0; font-family: Arial; font-size: 80pt; line-height: 80pt; font-weight: bold;"><?php echo $sprint['name'] ?></div>
<div style="color: rgba(6, 110, 176, 0.41); font-family: Arial; font-size: 20pt; line-height: 40pt; font-weight: bold;">Ends 
<?php 
	$months = array(
				"jan"=>"January",
				"feb"=>"February",
				"mar"=>"March",
				"apr"=>"April",
				"may"=>"May",
				"jun"=>"June",
				"jul"=>"July",
				"aug"=>"August",
				"sep"=>"September",
				"oct"=>"October",
				"nov"=>"November",
				"dec"=>"December");
	
	$datepart = explode("/", $sprint['endDate']);
	$month = $months[strtolower($datepart[1])];
	$rdate = $datepart[0] . " " . $month;
	print $rdate;
?>
</div>

	</div>
</div>
	




</body>
</html>
