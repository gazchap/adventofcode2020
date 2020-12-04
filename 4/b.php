<?php
	function is_valid( $value, $key ) {
		$rules = [
			'byr' => [
				'pattern' => '[0-9]{4}',
				'min' => '1920',
				'max' => '2002',
			],
			'iyr' => [
				'pattern' => '[0-9]{4}',
				'min' => '2010',
				'max' => '2020',
			],
			'eyr' => [
				'pattern' => '[0-9]{4}',
				'min' => '2020',
				'max' => '2030',
			],
			'hgt' => [
				'pattern' => '([0-9]+)(cm|in)',
				'cm' => [
					'min' => '150',
					'max' => '193',
				],
				'in' => [
					'min' => '59',
					'max' => '76',
				],
			],
			'hcl' => [
				'pattern' => '\#[0-9a-f]{6}',
			],
			'ecl' => [
				'pattern' => '(amb|blu|brn|gry|grn|hzl|oth)',
			],
			'pid' => [
				'pattern' => '[0-9]{9}',
			],
		];

		if ( !isset( $rules[ $key ] ) ) return true;
		$rule = $rules[$key];
		$pattern = "/^" . $rule['pattern'] . "$/i";
		$pattern_match = preg_match( $pattern, $value, $matches );
		if ( !$pattern_match ) return false;

		// deal with heights before checking min/max so we can set min/max appropriately
		if ( $key == 'hgt' ) {
			if ( empty( $matches[2] ) ) return false; // invalid unit
			$value = $matches[1];
			$unit = $matches[2];
			if ( isset( $rule[$unit]['min'] ) ) {
				$rule['min'] = $rule[$unit]['min'];
			}
			if ( isset( $rule[$unit]['max'] ) ) {
				$rule['max'] = $rule[$unit]['max'];
			}
		}
		if ( isset( $rule['min'] ) && $value < $rule['min'] ) return false;
		if ( isset( $rule['max'] ) && $value > $rule['max'] ) return false;

		// all tests passed
		return true;
	}

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
			$bits = explode( ":", $datum, 2 );
			$key = $bits[0] ?? '';
			$value = $bits[1] ?? '';
			if ( !empty( $key ) && !empty( $value ) && is_valid( $value, $key ) ) {
				$passport[$key] = $value;
			}
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

