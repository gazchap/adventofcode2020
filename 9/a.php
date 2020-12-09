<?php
	function get_valid_numbers( $array, $index = 0, $output = [] ) {
		$a = $array[$index];
		foreach( $array as $i => $b ) {
			if ( $i != $index && !in_array( $a + $b, $output ) ) {
				$output[] = $a + $b;
			}
		}
		if ( $index < count( $array ) ) {
			$output = get_valid_numbers( $array, $index + 1, $output );
		}
		return $output;
	}


	$input = array_map( 'trim', file("input.txt") );

	$preamble_length = 25;

	for( $i = $preamble_length; $i < count( $input ); $i++ ) {
		$last_25 = array_slice( $input, $i - $preamble_length, $preamble_length );

		$valid_numbers = get_valid_numbers( $last_25 );

		$target = $input[$i];
		if ( !in_array( $target, $valid_numbers ) ) {
			echo $target . " is the first invalid number.";
			break;
		}
	}

	exit;