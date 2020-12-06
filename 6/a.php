<?php
	$input = array_map( 'trim', file("input.txt") );
	$input[] = "";

	$groups = [];
	$group = [];
	foreach( $input as $line ) {
		if ( empty( $line ) ) {
			$groups[] = $group;
			$group = [];
			continue;
		}

		for( $i = 0; $i < strlen( $line ); $i++ ) {
			if ( !isset( $group[ $line[ $i ] ] ) ) $group[ $line[ $i ] ] = 0;
			$group[ $line[ $i ] ]++;
		}
	}

	$count = 0;
	foreach( $groups as $group ) {
		$questions = count( array_keys( $group ) );
		$count += $questions;
	}

	echo $count . " questions answered by the groups.";