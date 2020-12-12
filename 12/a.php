<?php
	$input = array_map( 'trim', file("input.txt") );
	$commands = [];
	foreach( $input as $command ) {
		$cmd = substr( $command, 0, 1 );
		$value = intval( substr( $command, 1 ) );
		$commands[] = [ 'cmd' => $cmd, 'val' => $value ];
	}

	$headings = [
		0 => 'E',
		90 => 'S',
		180 => 'W',
		270 => 'N',
	];

	// ship start position
	$x = 0;
	$y = 0;
	$heading = array_search( 'E', $headings ); // ship starts facing east

	foreach( $commands as $i => $command ) {
		echo $i . ". ";
		if ( $command['cmd'] == 'F' ) {
			echo $command['cmd'] . $command['val'] . " -> ";
			// work out direction we're facing and change the command to suit
			$command['cmd'] = $headings[ $heading ];
		}
		echo $command['cmd'] . $command['val'] . " -> ";
		switch( $command['cmd'] ) {
			case 'N':
				$y -= $command['val'];
				break;
			case 'S':
				$y += $command['val'];
				break;
			case 'E':
				$x += $command['val'];
				break;
			case 'W':
				$x -= $command['val'];
				break;
			case 'L':
				$heading -= $command['val'];
				if ( $heading < 0 ) {
					$heading = $heading + 360;
				}
				break;
			case 'R':
				$heading += $command['val'];
				if ( $heading > 359 ) {
					$heading = $heading - 360;
				}
				break;
			default:
				exit("Invalid command");
		}
		echo $x . ", " . $y . "   (hdg " . $heading . " (" . $headings[$heading] . "))\n";
		$t=1;
	}

	echo $x . ", " . $y . " is final position.\n";

	$manhattan = abs( $x ) + abs( $y );
	echo $manhattan . " is the Manhattan distance.";
