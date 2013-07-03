<?php
set_time_limit( 0);
ob_implicit_flush( 1);
//ini_set( 'memory_limit', '4000M');
for ( $prefix = is_dir( 'ajaxkit') ? 'ajaxkit/' : ''; ! is_dir( $prefix) && count( explode( '/', $prefix)) < 4; $prefix .= '../'); if ( ! is_file( $prefix . "env.php")) $prefix = '/web/ajaxkit/'; if ( ! is_file( $prefix . "env.php")) die( "\nERROR! Cannot find env.php in [$prefix], check your environment! (maybe you need to go to ajaxkit first?)\n\n");
foreach ( array( 'functions', 'env') as $k) require_once( $prefix . "$k.php"); clinit(); 
//clhelp( '');
//htg( clget( ''));

echo "\n\n"; $e = echoeinit(); $e2 = echoeinit(); $D = array(); // { slide2frame: [ frame, ...], diffs: [ diffs], ...}
`rm -Rf diffs*`; `rm -Rf diff/*`; // */ 
$slides = flget( 'pdf', 'slides', '', 'png'); $frames = flget( 'media', '', '', 'png'); $spos = 0; $fpos = 0; $temp = 0;
while ( $spos < count( $slides)) {
	echoe( $e2, ''); echoe( $e, "slide $spos: "); $slide = $slides[ $spos];
	if ( ! is_file( "pdf/resize.$slide")) procpipe( "convert pdf/$slide -resize 1920x1080 pdf/resize.$slide");
	if ( ! is_file( "pdf/resize.$slide")) die( " ERROR! Could not resize pdf/$slide!\n");
	$diffs = array();  $files = array();
	for ( $fpos2 = $fpos; $fpos2 < $fpos + 100 && $fpos2 < count( $frames); $fpos2++) {
		$frame = $frames[ $fpos2]; $diff = sprintf( 'diffs.%06d.png', $temp);
		$temp++; $c = "composite pdf/resize.$slide media/$frame -compose difference $diff"; procpipe( $c);
		if ( ! is_file( $diff)) die( " ERROR!  composite failed!\n");
		$size = filesize( $diff); if ( ! $size) die( " ERROR! Bad filesize of $diff\n");
		$size = round( 0.001 * $size); // kb
		$diffs[ "$fpos2"] = $size; $files[ "$fpos2"] = $diff;
		echoe( $e2, " $fpos2/" . count( $frames) . " > $size");
	}
	asort( $diffs, SORT_NUMERIC); list( $fpos, $size) = hfirst( $diffs); ksort( $diffs, SORT_NUMERIC);
	$diff = $files[ "$fpos"]; `mv $diff diff/$diff`;
	htouch( $D, 'slide2frame'); $D[ 'slide2frame'][ "$slide"] = $fpos;
	htouch( $D, 'diffs'); lpush( $D[ 'diffs'], ltt( $diffs));
	echo "  result: $fpos ($size)\n";  
	`rm -Rf diffs*`;
	$spos++;
}
echo " OK\n";
jsondump( $D, 'results.json');

?>