<?php

// URL cloacking script
// Version	1.2.4

define ('PROTOCOL', 'http://');
define ('TRACKING_SCRIPT', 'http://stonestreem.com/cgi-bin/track.cgi');
define ('SALT', 'K9zhSvwHMPVlaRFy75fNZi1wlNF5Myv3qWVIkhfdxYA5uxgHBXy');	// adjust to yours
$debug = 0;	// 1 means "debug mode"

// provides URL map (key = value)
require_once ('./URLs.php');


// *** set global variables ***

// this-site.com , www.this-site.com , etc.
$host = (isset ($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);
// http://this-site.com/this-dir/this-script.php
$self = PROTOCOL . $host . $_SERVER['SCRIPT_NAME'];
// http://this-site.com/this-dir
$self_dir = dirname ($self);
// http://ref-site.com/some-dir/and-so-on?get=params&here
$referrer = (isset ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
// http://this-site.com/this-dir/---req/name/may.be.long.html---
$resource = PROTOCOL . $host . $_SERVER['REQUEST_URI'];


// does the referrer come from this directory?
// if no - send frameset html code (1)
// 	http://ref-site.com/some-dir/and-so-on?get=params&here
// if yes - do redirection (2)
// 	http://this-site.com/this-dir/---req/name/may.be.long.html---?get=params&here
$pos = strpos ($referrer, "$self_dir/");
if ( ($pos !== false) && ($pos == 0) )
{
	// extract requested name from referrer's URL
	// will be used as key from URLs map
	$req_name = trim_get (substr_replace ($referrer, '', 0, strlen ("$self_dir/")));

	// do redirection with 301 Moved Permanently
	if ($debug != "1")
		header ('Location: ' . get_destination ($req_name), TRUE, 301);
}
else
{
	// get unique URL because user's browser will cache it
	$req_name = trim_get (substr_replace ($resource, '', 0, strlen ("$self_dir/")));
	$redirect_url = $self . '?' . md5 (SALT . get_destination ($req_name));

	if ( isset ($_SERVER['QUERY_STRING']) && ($_SERVER['QUERY_STRING'] != '') )
	{
		$redirect_url .= '&' . $_SERVER['QUERY_STRING'];
	}

	$track = TRACKING_SCRIPT . '?' . $referrer;
?>
	<html>
	<head>
	<title></title>
	</head>

	<frameset rows="100%,0" border="0">
	<frame src="<?php echo $redirect_url; ?>" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
<?php //	<frame src="< ?php echo $track; ? >" frameborder="0">  ?>
	</frameset>

	</html>
<?php
}

show_debug ();







// remove get parameters and trailing / or \
// input:  string $uri (/dir/file\///\\?get=params&here)
// output: string URL (/dir/file)
function trim_get ($uri = '')
{
	$res = preg_replace ("/^(.+)\?.*$/", "$1", $uri);
	return rtrim ($res, '/\\');
} // function trim_get (...)


/*
// lower case only!
$URLs = array (
	'sfi' => 'http://www.quickinfo247.com/8216336/FREE',	// sfimg
	'name2' => 'value2',					// not set
	'name3' => 'value3',					// not set
	'dbg' => 'http://www.dir.bg',				// test
// -------------------------
	'default' => 'http://stonestreem.com/blog/'		// fallback URL
); // $URLs = array (...)
*/

// retrives URL from map (key = value)
// input:  $key (name)
// output: destination URL (value)
function get_destination ($key = '')
{
	global $URLs;

	$key = strtolower ($key);

	if (array_key_exists ($key, $URLs))
		$destination = $URLs[$key];			// http://...
	else
		$destination = $URLs['default'];		// fallback URL
	return $destination;
} // function get_destination (...)








function show_debug ()
{
	global $debug;

	if ($debug != "1")
		return;

	global	$self, $self_dir, $referrer, $resource;
	global	$req_name, $redirect_url, $pos, $track;
?>

	<html> <br /> <h3>
	Results here: <br />
	$_SERVER['HTTP_REFERER']: <?php echo $_SERVER['HTTP_REFERER']; ?> <br />
	$_SERVER['REQUEST_URI']: <?php echo $_SERVER['REQUEST_URI']; ?> <br />
	$REQUEST_URI: <?php echo $REQUEST_URI; ?> <br />

	$_SERVER['QUERY_STRING']: <?php echo $_SERVER['QUERY_STRING']; ?> <br />

	$_SERVER['SCRIPT_NAME']: <?php echo $_SERVER['SCRIPT_NAME']; ?> <br />
	$_SERVER['PHP_SELF']: <?php echo $_SERVER['PHP_SELF']; ?> <br />

	dirname($_SERVER['PHP_SELF']): <?php echo dirname($_SERVER['PHP_SELF']); ?> <br />

	$_SERVER['SERVER_NAME']: <?php echo $_SERVER['SERVER_NAME']; ?> <br />
	$_SERVER['HTTP_HOST']: <?php echo $_SERVER['HTTP_HOST']; ?> <br />
<br />
	$self: <?php echo $self; ?> <br />
	$self_dir: <?php echo $self_dir; ?> <br />
	$req_name: <?php echo $req_name; ?> <br />
<br />
	$redirect_url: <?php echo $redirect_url; ?> <br />
<br />
	$pos: <?php echo $pos; ?> <br />
	$track: <?php echo $track; ?> <br />
	$referrer: <?php echo $referrer; ?> <br />
	$resource: <?php echo $resource; ?> <br />

	<?php echo get_destination ($req_name); ?>

<?php

echo "<br />";
	if ($ndvr)
	{
		echo "Yes";
	}
	if ($ndvr33 == 0)
	{
		echo "Yes33";
	}
	if (isset($ndvr33))
	{
		echo "Yes33 isset";
	}
	if (isset($ndvr334))
	{
		echo "Yes334 isset";
	}
	var_dump ($ndvr33);
	var_dump ($ndvr334);
echo "<br />";
	var_dump ($ndvr3347);








?>

	</h3> </html>

<?php
	phpinfo ();
}




















?>