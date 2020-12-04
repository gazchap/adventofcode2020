<?php
	$input = file( "input.txt" );
	$target = 2020;
	$output = '0';
	foreach( $input as $a) {
		foreach( $input as $b ) {
			if ( $a + $b == $target ) {
				$output = $a * $b;
				break 2;
			}
		}
	}
	echo $output;