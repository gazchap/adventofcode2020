 <?php
	function count_adjacent_seats( $x, $y, $seats, $state_to_count ) {
		$count = 0;
		for( $nx = $x - 1; $nx <= $x + 1; $nx++ ) {
			for( $ny = $y - 1; $ny <= $y + 1; $ny++ ) {
				if ( $x == $nx && $y == $ny ) continue;

				if ( isset( $seats[$nx][$ny] ) && $seats[ $nx ][ $ny ] == $state_to_count ) {
					$count++;
				}
			}
		}
		return $count;
	}

	$input = array_map( 'trim', file("input.txt") );
	$seats = [];
	foreach( $input as $y => $line ) {
		for( $x = 0; $x < strlen( $line ); $x++ ) {
			if ( $line[$x] == 'L' ) {
				$seats[ $x ][ $y ] = 0; // unoccupied = 0
			}
			if ( $line[$x] == '#' ) {
				$seats[ $x ][ $y ] = 1; // occupied = 1
			}
		}
	}

	$check_seats = $seats;
	$check_hash = md5( serialize( $seats ) );
	$c = 0;
	do {
		$c++;
		$new_seats = $check_seats;
		foreach( $check_seats as $x => $row ) {
			foreach( $row as $y => $seat_state ) {
				if ( $seat_state == 0 ) {
					// check adjacent seats and if none are occupied, this one becomes occupied
					$adjacent_count = count_adjacent_seats( $x, $y, $check_seats, 1 );
					if ( !$adjacent_count ) {
						$new_seats[ $x ][ $y ] = 1;
					}
				} else {
					// check adjacent seats and if 4+ are occupied, the seat becomes empty
					$adjacent_count = count_adjacent_seats( $x, $y, $check_seats, 1 );
					if ( $adjacent_count >= 4 ) {
						$new_seats[ $x ][ $y ] = 0;
					}
				}
			}
		}
		$new_hash = md5( serialize( $new_seats ) );
		if ( $new_hash == $check_hash ) {
			break;
		} else {
			$check_seats = $new_seats;
			$check_hash = $new_hash;
		}
	} while ( true );

	// count occupied seats
    $occupied = 0;
    foreach( $new_seats as $x => $row ) {
    	$col = array_count_values( $row );
    	$occupied += $col[1];
    }
    echo $occupied . " seats occupied.";
    exit;