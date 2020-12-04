<?php
	$input = array_map( 'trim', file( "input.txt" ) );
	$input[] = ""; // add empty line just to force all passports go be dealt with

	$allowed_fields = [ 'byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid', 'cid' ];
	$optional_fields = [ 'cid' ];

	$passports = [];
	$passport = [];
	foreach( $input as $line ) {
		if ( empty( $line ) && !empty( $passport ) ) {
			$passports[] = $passport;
			$passport = [];
			continue;
		}
		$data = explode( " ", $line );
		foreach( $data as $datum ) {
			list( $key, $value ) = explode( ":", $datum, 2 );
			$passport[$key] = $value;
		}
	}

	$valid = 0;
	$required_keys = array_diff( $allowed_fields, $optional_fields );
	foreach( $passports as $passport ) {
		$keys = array_keys( $passport );
		$check = array_intersect( $keys, $required_keys );
		if ( count( $check ) == count( $required_keys ) ) {
			$valid++;
		}
	}

	echo $valid . " valid passports.";

