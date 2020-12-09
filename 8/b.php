<?php
	$input = array_map( 'trim', file("input.txt") );
	$commands = [];
	foreach( $input as $i => $command ) {
		list( $command, $value ) = explode( ' ', $command, 2 );
		$commands[] = [ 'i' => $i, 'cmd' => $command, 'val' => $value, 'count' => 0 ];
	}

	// start a loop - we're going to continually try running the program
	// and if it doesn't get to an end and an instruction runs more than 3 times we'll
	// assume it's an infinite loop and drop out

	$original_commands = $commands;
	$command_last_changed = -1; // if a loop is detected, we'll set this to the next nop/jmp instruction in the code so we can switch it
	do {
		$accumulator = 0;
		$pointer     = 0;
		$infinite_loop = false;

		do {
			$command = &$commands[ $pointer ];
			if ( $command[ 'count' ] > 3 ) {
				$infinite_loop = true;
				break;
			}

			$command[ 'count' ] ++;

			switch ( $command[ 'cmd' ] ) {
				case 'nop':
					$pointer ++;
					break;

				case 'acc':
					$accumulator += $command[ 'val' ];
					$pointer ++;
					break;

				case 'jmp':
					$pointer += $command[ 'val' ];
					break;
			}
		} while ( $pointer < count( $commands ) - 1 );

		// if we didn't detect an infinite loop, program terminated properly so break out
		if ( !$infinite_loop ) {
			break;
		} else {
			$commands = $original_commands;
			// find the next nop/jmp and swap it
			for( $i = $command_last_changed + 1; $i < count( $commands ); $i++ ) {
				$command = &$commands[ $i ];
				if ( $command['cmd'] == 'nop' || $command['cmd'] == 'jmp' ) {
					$command['cmd'] = ( $command['cmd'] == 'nop' ) ? 'jmp' : 'nop';
					$command_last_changed = $i;
					break;
				}
			}
		}
	} while ( true );

	echo $accumulator . " is the accumulator value.";
	exit;