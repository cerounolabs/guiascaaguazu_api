<?php
    $app->get('/api/v1/500', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		b.MTDTDC		AS		tipo_estado_codigo,
		b.MTDTDN		AS		tipo_estado_nombre,
		a.MTDTDC		AS		tipo_codigo, 
		a.MTDTDN		AS		tipo_nombre,
		a.MTDTDV		AS		tipo_dominio,
		a.MTDTDD		AS		tipo_descripcion
		
		FROM PARMTD a
		INNER JOIN PARMTD b ON a.MTDTEC = b.MTDTDC
		
		ORDER BY a.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'tipo_estado_codigo'			=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'			=> $row['tipo_estado_nombre'],
					'tipo_codigo'					=> $row['tipo_codigo'], 
					'tipo_nombre'					=> $row['tipo_nombre'],
					'tipo_dominio'					=> $row['tipo_dominio'],
					'tipo_descripcion'				=> $row['tipo_descripcion']
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

    $app->get('/api/v1/500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		b.MTDTDC		AS		tipo_estado_codigo,
		b.MTDTDN		AS		tipo_estado_nombre,
		a.MTDTDC		AS		tipo_codigo, 
		a.MTDTDN		AS		tipo_nombre,
		a.MTDTDV		AS		tipo_dominio,
		a.MTDTDD		AS		tipo_descripcion
		
		FROM PARMTD a
		INNER JOIN PARMTD b ON a.MTDTEC = b.MTDTDC
		
		WHERE a.MTDTDC = '$val00'
		ORDER BY a.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'tipo_estado_codigo'			=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'			=> $row['tipo_estado_nombre'],
					'tipo_codigo'					=> $row['tipo_codigo'], 
					'tipo_nombre'					=> $row['tipo_nombre'],
					'tipo_dominio'					=> $row['tipo_dominio'],
					'tipo_descripcion'				=> $row['tipo_descripcion']
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

    $app->get('/api/v1/500/dominio/{dominio}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('dominio');
		$sql                        = "SELECT
		b.MTDTDC		AS		tipo_estado_codigo,
		b.MTDTDN		AS		tipo_estado_nombre,
		a.MTDTDC		AS		tipo_codigo, 
		a.MTDTDN		AS		tipo_nombre,
		a.MTDTDV		AS		tipo_dominio,
		a.MTDTDD		AS		tipo_descripcion
		
		FROM PARMTD a
		INNER JOIN PARMTD b ON a.MTDTEC = b.MTDTDC
		
		WHERE a.MTDTDV = '$val00'
		ORDER BY a.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
                $detalle			= array(
					'tipo_estado_codigo'			=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'			=> $row['tipo_estado_nombre'],
					'tipo_codigo'					=> $row['tipo_codigo'], 
					'tipo_nombre'					=> $row['tipo_nombre'],
					'tipo_dominio'					=> $row['tipo_dominio'],
					'tipo_descripcion'				=> $row['tipo_descripcion']
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
	
	$app->post('/api/v1/500', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        $val01                      = $request->getParsedBody()['tipo_estado_codigo'];
		$val02                      = strtoupper($request->getParsedBody()['tipo_nombre']);
		$val03                      = strtoupper($request->getParsedBody()['tipo_dominio']);
		$val04                      = $request->getParsedBody()['tipo_descripcion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO PARMTD (MTDTEC, MTDTDN, MTDTDV, MTDTDD) VALUES ('$val01', '".$val02."', '".$val03."', '".$val04."')";
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

	$app->put('/api/v1/500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        $val01                      = $request->getParsedBody()['tipo_estado_codigo'];
		$val02                      = strtoupper($request->getParsedBody()['tipo_nombre']);
		$val03                      = strtoupper($request->getParsedBody()['tipo_dominio']);
		$val04                      = $request->getParsedBody()['tipo_descripcion'];
        
        if (isset($val00) &&isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE PARMTD SET MTDTEC = '$val01', MTDTDN = '".$val02."', MTDTDV = '".$val03."', MTDTDD = '".$val04."' WHERE MTDTDC = '$val00'";
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

	$app->delete('/api/v1/500/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM PARMTD WHERE MTDTDC = '$val00'";
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