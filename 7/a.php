<?php
	$input = array_map( 'trim', file("input.txt") );

	$colour_map = [];
	foreach( $input as $line ) {
		list( $main, $secondary ) = explode( " bags contain ", rtrim( $line, "." ), 2 );
		$secondary = str_replace( [ "no other", " bags", " bag" ] , [ "0", "" ], $secondary );
		$colour_map[ $main ] = [];
		$secondaries = explode( ", ", $secondary );
		foreach( $secondaries as $secondary ) {
			list( $quantity, $secondary_colour ) = explode( " ", $secondary, 2 );
			$colour_map[ $main ][ $secondary_colour ] = $quantity;
		}
	}

	function find_bags_that_can_contain_colour( $colour, $map, $progress = [] ) {
		// find bags that can contain shiny gold bags
		foreach ( $map as $main => $contains ) {
			if ( !empty( $contains[ $colour ] ) ) {
				if ( !in_array( $main, $progress ) ) {
					$progress[] = $main;
				}
				$progress = find_bags_that_can_contain_colour( $main, $map, $progress );
			}
		}
		return $progress;
	}

	$colours = find_bags_that_can_contain_colour( 'shiny gold', $colour_map );
	echo count( $colours ) . " bag colours can contain a shiny gold bag.";
	exit;