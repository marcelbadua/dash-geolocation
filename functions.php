<?php

use GeoIp2\Database\Reader;

function get_country() {

		$reader = new Reader( sprintf("%s/data/GeoLite2-City.mmdb", dirname(__FILE__)) );

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		try {
			$record = $reader->city( $ip );
			$result = [];
			$result['isoCode'] = $record->country->isoCode;
			$result['name'] = $record->country->name;
		} catch (Exception $e) {}
		return $result;
	}