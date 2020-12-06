<?php
	$input = array_map( 'trim', file("input.txt") );
	$input[] = "";

	$groups = [];
	$group_person_counts = [];
	$group = [];
	$person_count = 0;
	foreach( $input as $line ) {
		if ( empty( $line ) ) {
			$groups[] = $group;
			$group_person_counts[] = $person_count;
			$group = [];
			$person_count = 0;
			continue;
		}

		for( $i = 0; $i < strlen( $line ); $i++ ) {
			if ( !isset( $group[ $line[ $i ] ] ) ) $group[ $line[ $i ] ] = 0;
			$group[ $line[ $i ] ]++;
		}
		$person_count++;
	}

	$count = 0;
	foreach( $groups as $i => $group ) {
		$person_count = $group_person_counts[ $i ];
		$counts = array_count_values( $group );
		$count += $counts[ $person_count ] ?? 0;
	}

	echo $count . " questions answered by the groups.";