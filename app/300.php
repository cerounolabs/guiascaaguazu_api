<?php
    $app->get('/api/v1/300', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.MTDTDC		AS		tipo_estado_codigo,
		d.MTDTDN		AS		tipo_estado_nombre,
		c.MLPLPC		AS		pais_codigo, 
		c.MLPLPN		AS		pais_nombre, 
		c.MLPLPD		AS		pais_descripcion,
		b.MLDLDC		AS		distrito_codigo, 
		b.MLDLDN		AS		distrito_nombre, 
		b.MLDLDD		AS		distrito_descripcion,
		a.MLCLCC		AS		ciudad_codigo,
		a.MLCLCN		AS		ciudad_nombre,
		a.MLCLCD		AS		ciudad_descripcion
		
		FROM LOCMLC a
		INNER JOIN LOCMLD b ON a.MLCLDC = b.MLDLDC
		INNER JOIN LOCMLP c ON b.MLDLPC = c.MLPLPC
		INNER JOIN PARMTD d ON a.MLCTEC = d.MTDTDC
		
		ORDER BY c.MLPLPN, b.MLDLDN, a.MLCLCN";
		
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
					'distrito_descripcion'	=> $row['distrito_descripcion'],
					'ciudad_codigo'			=> $row['ciudad_codigo'],
					'ciudad_nombre'			=> $row['ciudad_nombre'],
					'ciudad_descripcion'	=> $row['ciudad_descripcion']
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

    $app->get('/api/v1/300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.MTDTDC		AS		tipo_estado_codigo,
		d.MTDTDN		AS		tipo_estado_nombre,
		c.MLPLPC		AS		pais_codigo, 
		c.MLPLPN		AS		pais_nombre, 
		c.MLPLPD		AS		pais_descripcion,
		b.MLDLDC		AS		distrito_codigo, 
		b.MLDLDN		AS		distrito_nombre, 
		b.MLDLDD		AS		distrito_descripcion,
		a.MLCLCC		AS		ciudad_codigo,
		a.MLCLCN		AS		ciudad_nombre,
		a.MLCLCD		AS		ciudad_descripcion
		
		FROM LOCMLC a
		INNER JOIN LOCMLD b ON a.MLCLDC = b.MLDLDC
		INNER JOIN LOCMLP c ON b.MLDLPC = c.MLPLPC
		INNER JOIN PARMTD d ON a.MLCTEC = d.MTDTDC
		
		WHERE a.MLCLCC = '$val00'
		ORDER BY c.MLPLPN, b.MLDLDN, a.MLCLCN";
		
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
					'distrito_descripcion'	=> $row['distrito_descripcion'],
					'ciudad_codigo'			=> $row['ciudad_codigo'],
					'ciudad_nombre'			=> $row['ciudad_nombre'],
					'ciudad_descripcion'	=> $row['ciudad_descripcion']
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

	$app->post('/api/v1/300', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['distrito_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['ciudad_nombre']);
		$val04                      = $request->getParsedBody()['ciudad_descripcion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO LOCMLC (MLCTEC, MLCLDC, MLCLCN, MLCLCD) VALUES ('$val01', '$val02', '".$val03."', '".$val04."')";
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

	$app->put('/api/v1/300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['distrito_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['ciudad_nombre']);
		$val04                      = $request->getParsedBody()['ciudad_descripcion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE LOCMLC SET MLCTEC = '$val01', MLCLDC = '$val02', MLCLCN = '".$val03."', MLCLCD = '".$val04."' WHERE MLCLCC = '$val00'";
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

	$app->delete('/api/v1/300/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM LOCMLC WHERE MLCLCC = '$val00'";
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