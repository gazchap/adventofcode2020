<?php
	function bsp( $code, $lower_min, $upper_max, $use_lower ) {
		$lower_min++;
		$upper_max++;
		$result = 0;
		$delta = intval( ceil( ( $upper_max - $lower_min ) / 2 ) );
		$lower_max = $upper_max - $delta;
		for( $i = 0; $i < strlen( $code ); $i++ ) {
			$upper_min = $lower_max + 1;

			$char = $code[$i];
			if ( $char == $use_lower ) {
				if ( $i == strlen( $code ) - 1 ) {
					return $lower_min - 1;
				}
				$upper_max = $lower_max;
			} else {
				if ( $i == strlen( $code ) - 1 ) {
					return $upper_max - 1;
				}
				$lower_min = $upper_min;
			}

			$delta /= 2; // for next round
			$lower_max = ( $lower_min + $delta ) - 1;
		}
		return $result;
	}

	$input = array_map( 'trim', file("input.txt") );

	$row_min = 0;
	$row_max = 127;
	$col_min = 0;
	$col_max = 7;

	$seats = [];
	$highest_seat_id = 0;
	foreach( $input as $code ) {
		$row_code = substr( $code, 0, 7 );
		$col_code = substr( $code, 7 );
		$row = bsp( $row_code, $row_min, $row_max, 'F' );
		$col = bsp( $col_code, $col_min, $col_max, 'L' );
		$seat_id = ( $row * 8 ) + $col;
		$seats[] = [ $row, $col, $seat_id ];
		if ( $seat_id > $highest_seat_id ) $highest_seat_id = $seat_id;
	}

	echo $highest_seat_id . " is your highest seat ID.";
