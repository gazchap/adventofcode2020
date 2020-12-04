<?php
	$input = file( "input.txt" );
	$valid = 0;
	foreach( $input as $line ) {
		list( $min_chars, $letter, $password ) = explode( " ", $line, 3 );
		$letter = rtrim( $letter, ':' );
		
		list( $min, $max ) = explode( "-", $min_chars, 2 );
		
		$count = substr_count( $password, $letter );
		if ( $count >= $min && $count <= $max ) {
			$valid++;
		}
	}
	
	echo $valid;