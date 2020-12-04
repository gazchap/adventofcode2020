<?php
	$input = file( "input.txt" );
	$target = 2020;
	$output = '0';
	foreach( $input as $a) {
		foreach( $input as $b ) {
			foreach( $input as $c ) {
				if ( $a + $b + $c == $target ) {
					$output = $a * $b * $c;
					break 3;
				}
			}
		}
	}
	echo $output;