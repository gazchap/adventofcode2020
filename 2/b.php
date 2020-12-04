<?php
	$input = file( "input.txt" );
	$valid = 0;
	foreach( $input as $line ) {
		list( $char_positions, $letter, $password ) = explode( " ", $line, 3 );
		$letter = rtrim( $letter, ':' );
		
		$char_positions = explode( "-", $char_positions );
		$positions_valid = 0;
		foreach( $char_positions as $char_position ) {
			if ( $password[ $char_position - 1 ] == $letter ) {
				$positions_valid++;
			}
		}
		if ( $positions_valid == 1 ) {
			$valid++;
		}
	}
	
	echo $valid;