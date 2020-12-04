<?php
	$input = file( "input.txt" );
	$map = [];
	foreach( $input as $y => $line ) {
		$line = trim( $line );
		for( $x = 0; $x < strlen( $line ); $x++ ) {
			$map[$x][$y] = $line[$x];
		}
	}
	$max_y = count( $input ) -1;
	$max_x = count( $map ) - 1;

	$slopes = [
		[ 1, 1 ],
		[ 3, 1 ],
		[ 5, 1 ],
		[ 7, 1 ],
		[ 1, 2 ],
	];
	$trees_per_slope = [];

	foreach( $slopes as $slope ) {
		$cur_x = 0;
		$cur_y = 0;

		$move_right = $slope[0];
		$move_down = $slope[1];

		$trees_encountered = 0;
		do {
			$this_pos = $map[$cur_x][$cur_y];
			if ( $this_pos == '#' ) {
				$trees_encountered++;
			}
			$cur_y += $move_down;
			$cur_x += $move_right;
			if ( $cur_x > $max_x ) {
				$cur_x = $cur_x - $max_x - 1;
			}
		} while( $cur_y <= $max_y );

		$trees_per_slope[] = $trees_encountered;
	}
	echo array_product( $trees_per_slope ) . " trees in total";
