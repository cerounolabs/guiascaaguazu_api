<?php
    $app->get('/api/v1/400', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		e.MTDTDC		AS		tipo_estado_codigo,
		e.MTDTDN		AS		tipo_estado_nombre,
		d.MLPLPC		AS		pais_codigo, 
		d.MLPLPN		AS		pais_nombre, 
		d.MLPLPD		AS		pais_descripcion,
		c.MLDLDC		AS		distrito_codigo, 
		c.MLDLDN		AS		distrito_nombre, 
		c.MLDLDD		AS		distrito_descripcion,
		b.MLCLCC		AS		ciudad_codigo,
		b.MLCLCN		AS		ciudad_nombre,
		b.MLCLCD		AS		ciudad_descripcion,
		a.MLBLBC		AS		barrio_codigo,
		a.MLBLBN		AS		barrio_nombre,
		a.MLBLBD		AS		barrio_descripcion
		
		FROM LOCMLB a
		INNER JOIN LOCMLC b ON a.MLBLCC = b.MLCLCC
		INNER JOIN LOCMLD c ON b.MLCLDC = c.MLDLDC
		INNER JOIN LOCMLP d ON c.MLDLPC = d.MLPLPC
		INNER JOIN PARMTD e ON a.MLBTEC = e.MTDTDC
		
		ORDER BY d.MLPLPN, c.MLDLDN, b.MLCLCN, a.MLBLBN";
		
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
					'ciudad_descripcion'	=> $row['ciudad_descripcion'],
					'barrio_codigo'			=> $row['barrio_codigo'],
					'barrio_nombre'			=> $row['barrio_nombre'],
					'barrio_descripcion'	=> $row['barrio_descripcion']
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

    $app->get('/api/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		
		$sql                        = "SELECT
		e.MTDTDC		AS		tipo_estado_codigo,
		e.MTDTDN		AS		tipo_estado_nombre,
		d.MLPLPC		AS		pais_codigo, 
		d.MLPLPN		AS		pais_nombre, 
		d.MLPLPD		AS		pais_descripcion,
		c.MLDLDC		AS		distrito_codigo, 
		c.MLDLDN		AS		distrito_nombre, 
		c.MLDLDD		AS		distrito_descripcion,
		b.MLCLCC		AS		ciudad_codigo,
		b.MLCLCN		AS		ciudad_nombre,
		b.MLCLCD		AS		ciudad_descripcion,
		a.MLBLBC		AS		barrio_codigo,
		a.MLBLBN		AS		barrio_nombre,
		a.MLBLBD		AS		barrio_descripcion
		
		FROM LOCMLB a
		INNER JOIN LOCMLC b ON a.MLBLCC = b.MLCLCC
		INNER JOIN LOCMLD c ON b.MLCLDC = c.MLDLDC
		INNER JOIN LOCMLP d ON c.MLDLPC = d.MLPLPC
		INNER JOIN PARMTD e ON a.MLBTEC = e.MTDTDC
		
		WHERE a.MLBLBC = '$val00'
		ORDER BY d.MLPLPN, c.MLDLDN, b.MLCLCN, a.MLBLBN";
		
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
					'ciudad_descripcion'	=> $row['ciudad_descripcion'],
					'barrio_codigo'			=> $row['barrio_codigo'],
					'barrio_nombre'			=> $row['barrio_nombre'],
					'barrio_descripcion'	=> $row['barrio_descripcion']
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

	$app->post('/api/v1/400', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['ciudad_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['barrio_nombre']);
		$val04                      = $request->getParsedBody()['barrio_descripcion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO LOCMLB (MLBTEC, MLBLCC, MLBLBN, MLBLBD) VALUES ('$val01', '$val02', '".$val03."', '".$val04."')";
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

	$app->put('/api/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['ciudad_codigo'];
        $val03                      = strtoupper($request->getParsedBody()['barrio_nombre']);
		$val04                      = $request->getParsedBody()['barrio_descripcion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE LOCMLB SET MLBTEC = '$val01', MLBLCC = '$val02', MLBLBN = '".$val03."', MLBLBD = '".$val04."' WHERE MLBLBC = '$val00'";
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

	$app->delete('/api/v1/400/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM LOCMLB WHERE MLBLBC = '$val00'";
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