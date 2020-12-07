<?php

	$input = array_map( 'trim', file( "input.txt" ) );

	$colour_map = [];
	foreach ( $input as $line ) {
		list( $main, $secondary ) = explode( " bags contain ", rtrim( $line, "." ), 2 );
		$secondary = str_replace( [ "no other", " bags", " bag" ] , [ "0", "" ], $secondary );
		$colour_map[ $main ] = [];
		$secondaries         = explode( ", ", $secondary );
		foreach ( $secondaries as $secondary ) {
			list( $quantity, $secondary_colour ) = explode( " ", $secondary, 2 );
			if ( $quantity > 0 ) {
				$colour_map[ $main ][ $secondary_colour ] = $quantity;
			}
		}
	}

	function count_bags_inside_colour( $colour, $map, $progress = 0, $last_qty = 1 ) {
		if ( !empty( $map[ $colour ] ) ) {
			$this_bag = $map[ $colour ];
			foreach( $this_bag as $secondary => $quantity ) {
				$progress += $quantity * $last_qty;
				echo $colour . "/" . $secondary . " - " . $quantity . " > " . $progress . "\n";
				$progress = count_bags_inside_colour( $secondary, $map, $progress, $quantity * $last_qty );
			}
		}
		return $progress;
	}

	$bags = count_bags_inside_colour( 'shiny gold', $colour_map );
	echo $bags . " bags must be inside a shiny gold bag.";
	exit;