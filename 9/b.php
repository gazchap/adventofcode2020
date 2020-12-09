<?php
	function get_valid_numbers( $array, $start = 0, $output = [] ) {
		$a = $array[$start];
		foreach( $array as $i => $b ) {
			if ( $i != $start && !in_array( $a + $b, $output ) ) {
				$output[] = $a + $b;
			}
		}
		if ( $start < count( $array ) ) {
			$output = get_valid_numbers( $array, $start + 1, $output );
		}
		return $output;
	}

	function find_weakness( $array, $target, $start = 0 ) {
		$sum = 0;
		$weakness_found = false;
		for( $i = $start; $i < count( $array ); $i++ ) {
			$sum += $array[ $i ];
			if ( $sum == $target ) {
				$weakness_found = true;
				break;
			} elseif( $sum > $target ) {
				break;
			}
		}

		if ( $weakness_found ) {
			$sequence = array_slice( $array, $start, ( $i - $start ) + 1 );
			$weakness = min( $sequence ) + max( $sequence );
			return $weakness;
		} else {
			return false;
		}
	}


	$input = array_map( 'trim', file("input.txt") );

	$preamble_length = 25;

	for( $i = $preamble_length; $i < count( $input ); $i++ ) {
		$last_25 = array_slice( $input, $i - $preamble_length, $preamble_length );

		$valid_numbers = get_valid_numbers( $last_25 );

		$target = $input[$i];
		if ( !in_array( $target, $valid_numbers ) ) {
			break;
		}
	}

	// we have the target, need to find the contiguous set of numbers that add to it now
	for( $i = 0; $i < count( $input ); $i++ ) {
		$weakness = find_weakness( $input, $target, $i );
		if ( false !== $weakness ) break;
	}

	echo $weakness . " is the weakness!";
	exit;