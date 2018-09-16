<?php
    $app->get('/api/v1/200', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		c.MTDTDC		AS		tipo_estado_codigo,
		c.MTDTDN		AS		tipo_estado_nombre,
		b.MLPLPC		AS		pais_codigo, 
		b.MLPLPN		AS		pais_nombre, 
		b.MLPLPD		AS		pais_descripcion,
		a.MLDLDC		AS		distrito_codigo, 
		a.MLDLDN		AS		distrito_nombre, 
		a.MLDLDD		AS		distrito_descripcion
		
		FROM LOCMLD a
		INNER JOIN LOCMLP b ON a.MLDLPC = b.MLPLPC
		INNER JOIN PARMTD c ON a.MLDTEC = c.MTDTDC
		
		ORDER BY b.MLPLPN, a.MLDLDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'tipo_estado_codigo'	=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'	=> $row['tipo_estado_nombre'],
					'pais_codigo'			=> $row['pais_codigo'],
					'pais_nombre'			=> $row['pais_nombre'],
					'pais_descripcion'		=> $row['pais_descripcion'],
					'distrito_codigo'		=> $row['distrito_codigo'],
					'distrito_nombre'		=> $row['distrito_nombre'],
					'distrito_descripcion'	=> $row['distrito_descripcion']
				);	
                $result[]           = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => 'null'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

    $app->get('/api/v1/200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		c.MTDTDC		AS		tipo_estado_codigo,
		c.MTDTDN		AS		tipo_estado_nombre,
		b.MLPLPC		AS		pais_codigo, 
		b.MLPLPN		AS		pais_nombre, 
		b.MLPLPD		AS		pais_descripcion,
		a.MLDLDC		AS		distrito_codigo, 
		a.MLDLDN		AS		distrito_nombre, 
		a.MLDLDD		AS		distrito_descripcion
		
		FROM LOCMLD a
		INNER JOIN LOCMLP b ON a.MLDLPC = b.MLPLPC
		INNER JOIN PARMTD c ON a.MLDTEC = c.MTDTDC
		
		WHERE a.MLDLDC = '$val00'
		ORDER BY b.MLPLPN, a.MLDLDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'tipo_estado_codigo'	=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'	=> $row['tipo_estado_nombre'],
					'pais_codigo'			=> $row['pais_codigo'],
					'pais_nombre'			=> $row['pais_nombre'],
					'pais_descripcion'		=> $row['pais_descripcion'],
					'distrito_codigo'		=> $row['distrito_codigo'],
					'distrito_nombre'		=> $row['distrito_nombre'],
					'distrito_descripcion'	=> $row['distrito_descripcion']
				);	
                $result[]           = $detalle;
            }
			$query->free();
        }
        
        $mysqli->close();
        
        if (isset($result)){
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Consulta con exito', 'data' => $result), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No hay registros', 'data' => 'null'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }
        
        return $json;
    });

	$app->post('/api/v1/200', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['pais_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['distrito_nombre']);
		$val04                      = $request->getParsedBody()['distrito_descripcion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO LOCMLD (MLDTEC, MLDLPC, MLDLDN, MLDLDD) VALUES ('$val01', '$val02', '".$val03."', '".$val04."')";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se inserto con exito', 'codigo' => $mysqli->insert_id), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo insertar', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.', 'codigo' => 0), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });

	$app->put('/api/v1/200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['pais_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['distrito_nombre']);
		$val04                      = $request->getParsedBody()['distrito_descripcion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE LOCMLD SET MLDTEC = '$val01', MLDLPC = '$val02', MLDLDN = '".$val03."', MLDLDD = '".$val04."' WHERE MLDLDC = '$val00'";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se actualizo con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo actualizar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });

	$app->delete('/api/v1/200/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM LOCMLD WHERE MLDLDC = '$val00'";
            if ($mysqli->query($sql) === TRUE) {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 200, 'status' => 'ok', 'message' => 'Se elimino con exito'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            } else {
                header("Content-Type: application/json; charset=utf-8");
                $json               = json_encode(array('code' => 204, 'status' => 'ok', 'message' => 'No se pudo eliminar'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
            }
        } else {
            header("Content-Type: application/json; charset=utf-8");
            $json                   = json_encode(array('code' => 400, 'status' => 'error', 'message' => 'Verifique, algún campo esta vacio.'), JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRESERVE_ZERO_FRACTION);
        }

        $mysqli->close();
        
        return $json;
    });