<?php

	function fnDateDMYtoYMD($param){
		$result = date("Y-m-d", strtotime($param));
		return $result;
	}

	function fnDateYMDtoDMY($param){
		$result = date("d/m/Y", strtotime($param));
		return $result;
	}


	function fnDateDMYHIStoYMDHI($param){
		$result = date("Y-m-d H:i", strtotime($param));
		return $result;
	}

	function fnDateYMDHItoDMYHI($param){
		$result = date("d/m/Y H:i", strtotime($param));
		return $result;
	}

	function fnDateToMysql($dateSql){

		//DD/MM/YYYY HH:ii to YYYY/MM/DD HH:ii
		$year = substr($dateSql, 6, 4);
		$month = substr($dateSql, 3,2);
		$day = substr($dateSql, 0,2);
		$hours = substr($dateSql, 11, 2);
		$minutes = substr($dateSql, 14, 2);

    	return $year."-".$month."-".$day." ".$hours.":".$minutes;
	}

	function isDate($x) {
		return (date('Y-m-d H:i', strtotime($x)) == $x);
	}

	function fnTimeElapsed($datetime, $full = false, $language) {
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		if ($language == "pt_BR"){

			$string = array(
				'y' => 'ano',
				'm' => 'mês',
				'w' => 'semana',
				'd' => 'dia',
				'h' => 'hora',
				'i' => 'min',
				's' => 'seg',
			);

			$stringPlural = array(
				'y' => 'ano',
				'm' => 'meses',
				'w' => 'semana',
				'd' => 'dia',
				'h' => 'hora',
				'i' => 'min',
				's' => 'seg',
			);


			foreach ($string as $k => &$v) {
				if ($diff->$k) {

					if ($diff->y < 1 && $diff->m > 1){
						$v = $diff->$k . ' ' . 'meses';
					}else{
						$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
					}
				} else {
					unset($string[$k]);
				}
			}

			if (!$full) $string = array_slice($string, 0, 1);
			return $string ? implode(', ', $string) . ' atrás' : 'agora';
		}else{

			$string = array(
				'y' => 'year',
				'm' => 'month',
				'w' => 'week',
				'd' => 'day',
				'h' => 'hour',
				'i' => 'min',
				's' => 'sec',
			);

			foreach ($string as $k => &$v) {
				if ($diff->$k) {
					$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
				} else {
					unset($string[$k]);
				}
			}

			if (!$full) $string = array_slice($string, 0, 1);
			return $string ? implode(', ', $string) . ' ago' : 'just now';
		}
	}

	function consoleLog($data) {
		$output = $data;
		if ( is_array( $output ) )
			$output = implode( ',', $output);

		echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	}

	function fnLeaveOnlyNumbers($string){
		return preg_replace("/[^0-9]/", "", $string);
	}

?>
