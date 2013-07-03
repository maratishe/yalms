<?php
set_time_limit( 0);
ob_implicit_flush( 1);
//ini_set( 'memory_limit', '4000M');
for ( $prefix = is_dir( 'ajaxkit') ? 'ajaxkit/' : ''; ! is_dir( $prefix) && count( explode( '/', $prefix)) < 4; $prefix .= '../'); if ( ! is_file( $prefix . "env.php")) $prefix = '/web/ajaxkit/'; if ( ! is_file( $prefix . "env.php")) die( "\nERROR! Cannot find env.php in [$prefix], check your environment! (maybe you need to go to ajaxkit first?)\n\n");
foreach ( array( 'functions', 'env') as $k) require_once( $prefix . "$k.php"); clinit(); 
//clhelp( '');
//htg( clget( ''));

echo "\n\n"; $D = jsonload( 'results.json');
$FS = 20; $BS = 4.5;
class MyChartFactory extends ChartFactory { public function make( $C, $margins) { return new ChartLP( $C->setup, $C->plot, $margins);}}
$S = new ChartSetupStyle(); $S->style = 'D'; $S->lw = 0.3; $S->draw = '#000'; $S->fill = null;
$S2 = clone $S; $S2->lw = 0.6; $S2->draw = '#f00';
list( $C, $CS, $CST) = chartlayout( new MyChartFactory(), 'P', '3x3', 3, '0.05:0.05:0.05:0.05');
foreach ( ttl( '0,1,2,3,4,5,6,8,9') as $pos) { 
	$C2 = lshift( $CS);
	$vs = ttl( $D[ 'diffs'][ $pos]);
	$C2->train( hk( $vs), hv( $vs));
	$C2->autoticks( null, null, 10, 10);
	$C2->frame( null, null);
	chartline( $C2, hk( $vs), hv( $vs), $S);
	asort( $vs, SORT_NUMERIC); list( $k, $v) = hfirst( $vs);
	chartscatter( $C2, array( $k), array( $v), 'cross', 10, $S2);
	$CL = new ChartLegendBR( $C2);
	$CL->add( null, $BS, 0.1, "Slide " . ( $pos + 1));
	$CL->draw( true);
}
$C->dump( 'results.pdf');

?>