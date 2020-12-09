<?php
	$input = array_map( 'trim', file("input.txt") );
	$commands = [];
	foreach( $input as $command ) {
		list( $command, $value ) = explode( ' ', $command, 2 );
		$commands[] = [ 'cmd' => $command, 'val' => $value, 'count' => 0 ];
	}

	$accumulator = 0;
	$pointer = 0;
	do {
		$command = &$commands[ $pointer ];

		// have we already run this command?
		if ( $command['count'] > 0 ) {
			break;
		}

		$command['count']++;

		switch ( $command['cmd'] ) {
			case 'nop':
				$pointer++;
				break;

			case 'acc':
				$accumulator += $command['val'];
				$pointer++;
				break;

			case 'jmp':
				$pointer += $command['val'];
				break;
		}
	} while( $pointer < count( $commands ) - 1 );

	echo $accumulator . " is the accumulator value.";
	exit;