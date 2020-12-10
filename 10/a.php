 <?php
	$input = array_map( 'trim', file("input.txt") );

	// sort adapters by their rating
	sort( $input );

	$max_difference = 3;

	$start = 0;
	$adapters_used = 0;
	$target_to_use = count( $input );
	$differences = [];

	do {
		for( $rating = $start + 1; $rating <= $start + $max_difference; $rating++ ) {
			if ( in_array( $rating, $input ) ) {
				$adapters_used++;
				$difference = $rating - $start;
				if ( !isset( $differences[ $difference ] ) ) $differences[ $difference ] = 0;
				$differences[ $difference ]++;
				$start = $rating;
				break;
			}
		}
	} while ( $adapters_used < $target_to_use );

	// always 3 higher than the highest adapter
	 $differences[3]++;

	$output = $differences[1] * $differences[3];
	echo $output . " is the answer.";
	exit;