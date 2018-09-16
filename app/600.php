<?php
    $app->get('/api/v1/600', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.MTDTDC		AS		tipo_estado_codigo,
		d.MTDTDN		AS		tipo_estado_nombre,
		c.MTDTDC		AS		tipo_subcategoria_codigo, 
		c.MTDTDN		AS		tipo_subcategoria_nombre, 
		b.MTDTDC		AS		tipo_categoria_codigo,
		b.MTDTDN		AS		tipo_categoria_nombre, 
		a.MTCCSC		AS		categoria_subcategoria_codigo, 
		a.MTCCSD		AS		categoria_subcategoria_descripcion
		
		FROM PARMTC a
		INNER JOIN PARMTD b ON a.MTCTCC = b.MTDTDC
		INNER JOIN PARMTD c ON a.MTCTSC = c.MTDTDC
		INNER JOIN PARMTD d ON a.MTCTEC = d.MTDTDC
		
		ORDER BY b.MTDTDN, c.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'tipo_estado_codigo'					=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'					=> $row['tipo_estado_nombre'],
					'tipo_subcategoria_codigo'				=> $row['tipo_subcategoria_codigo'],
					'tipo_subcategoria_nombre'				=> $row['tipo_subcategoria_nombre'],
					'tipo_categoria_codigo'					=> $row['tipo_categoria_codigo'],
					'tipo_categoria_nombre'					=> $row['tipo_categoria_nombre'],
					'categoria_subcategoria_codigo'			=> $row['categoria_subcategoria_codigo'],
					'categoria_subcategoria_descripcion'	=> $row['categoria_subcategoria_descripcion']
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

    $app->get('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.MTDTDC		AS		tipo_estado_codigo,
		d.MTDTDN		AS		tipo_estado_nombre,
		c.MTDTDC		AS		tipo_subcategoria_codigo, 
		c.MTDTDN		AS		tipo_subcategoria_nombre, 
		b.MTDTDC		AS		tipo_categoria_codigo,
		b.MTDTDN		AS		tipo_categoria_nombre, 
		a.MTCCSC		AS		categoria_subcategoria_codigo, 
		a.MTCCSD		AS		categoria_subcategoria_descripcion
		
		FROM PARMTC a
		INNER JOIN PARMTD b ON a.MTCTCC = b.MTDTDC
		INNER JOIN PARMTD c ON a.MTCTSC = c.MTDTDC
		INNER JOIN PARMTD d ON a.MTCTEC = d.MTDTDC
		
		WHERE a.MTCCSC = '$val00'
		ORDER BY b.MTDTDN, c.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $detalle			= array(
					'tipo_estado_codigo'					=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'					=> $row['tipo_estado_nombre'],
					'tipo_subcategoria_codigo'				=> $row['tipo_subcategoria_codigo'],
					'tipo_subcategoria_nombre'				=> $row['tipo_subcategoria_nombre'],
					'tipo_categoria_codigo'					=> $row['tipo_categoria_codigo'],
					'tipo_categoria_nombre'					=> $row['tipo_categoria_nombre'],
					'categoria_subcategoria_codigo'			=> $row['categoria_subcategoria_codigo'],
					'categoria_subcategoria_descripcion'	=> $row['categoria_subcategoria_descripcion']
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

	$app->post('/api/v1/600', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['tipo_categoria_codigo'];
        $val03                      = $request->getParsedBody()['tipo_subcategoria_codigo'];
		$val04                      = $request->getParsedBody()['categoria_subcategoria_descripcion'];
        
        if (isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "INSERT INTO PARMTC (MTCTEC, MTCTCC, MTCTSC, MTCCSD) VALUES ('$val01', '$val02', '$val03', '".$val04."')";
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

	$app->put('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['tipo_categoria_codigo'];
        $val03                      = $request->getParsedBody()['tipo_subcategoria_codigo'];
		$val04                      = $request->getParsedBody()['categoria_subcategoria_descripcion'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03)) {
            $sql                    = "UPDATE PARMTC SET MTCTEC = '$val01', MTCTCC = '$val02', MTCTSC = '$val03', MTCCSD = '".$val04."' WHERE MTCCSC = '$val00'";
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

	$app->delete('/api/v1/600/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM PARMTC WHERE MTCCSC = '$val00'";
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