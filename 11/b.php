 <?php
	function count_los_seats( $x, $y, $seats, $state_to_count, $grid_width, $grid_height ) {
		$count = 0;
		$directions = [
			'nw' => [-1, -1],
			'n' => [0,-1],
			'ne' => [1,-1],
			'w' => [-1,0],
			'e' => [1,0],
			'sw' => [-1,1],
			's' => [0,1],
			'se' => [1,1],
		];
		foreach( $directions as $cp => $direction ) {
			$visible_seat = false;
			$nx = $x;
			$ny = $y;
			do {
				$nx += $direction[0];
				$ny += $direction[1];
				if ( $nx < 0 || $ny < 0 || $nx > $grid_width || $ny > $grid_height ) break;
				if ( isset( $seats[ $nx ] ) ) {
					$row = $seats[ $nx ];

					if ( isset( $row[ $ny ] ) ) {
						$visible_seat = true;
						if ( $row[ $ny ] == $state_to_count ) {
							$count ++;
						}
					}
				}
			} while ( !$visible_seat );
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
	$grid_width = $x;
	$grid_height = $y;

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
					$adjacent_count = count_los_seats( $x, $y, $check_seats, 1, $grid_width, $grid_height );
					if ( !$adjacent_count ) {
						$new_seats[ $x ][ $y ] = 1;
					}
				} else {
					// check adjacent seats and if 4+ are occupied, the seat becomes empty
					$adjacent_count = count_los_seats( $x, $y, $check_seats, 1, $grid_width, $grid_height );
					if ( $adjacent_count >= 5 ) {
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
	 echo $occupied . " seats occupied.\n";

	 exit;