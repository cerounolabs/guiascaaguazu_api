<?php
    $app->get('/api/v1/800', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		c.MTDTDC		AS		tipo_estado_codigo,
		c.MTDTDN		AS		tipo_estado_nombre,
		b.MTDTDC		AS		tipo_subcategoria_codigo,
		b.MTDTDN		AS		tipo_subcategoria_nombre,
		a.MEMEID		AS		empresa_codigo, 
		a.MEMENO		AS		empresa_nombre, 
		a.MEMERU		AS		empresa_ruc,
		a.MEMELO		AS		empresa_logo, 
		a.MEMEOA		AS		empresa_obs_administrador,
        a.MEMEOC		AS		empresa_obs_cliente
		
		FROM EMPMEM a
		INNER JOIN PARMTD b ON a.MEMTSC = b.MTDTDC
		INNER JOIN PARMTD c ON a.MEMTEC = c.MTDTDC
		
		ORDER BY b.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
				$detalle			= array(
					'tipo_estado_codigo'		=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'		=> $row['tipo_estado_nombre'],
					'tipo_subcategoria_codigo'	=> $row['tipo_subcategoria_codigo'],
					'tipo_subcategoria_nombre'	=> $row['tipo_subcategoria_nombre'],
					'empresa_codigo'		    => $row['empresa_codigo'],
					'empresa_nombre'		    => $row['empresa_nombre'],
					'empresa_ruc'			    => $row['empresa_ruc'],
					'empresa_logo'			    => '../image/empresa/logo/'.$row['empresa_logo'],
					'empresa_obs_administrador' => $row['empresa_obs_administrador'],
					'empresa_obs_cliente'	    => $row['empresa_obs_cliente']
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

    $app->get('/api/v1/800/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		c.MTDTDC		AS		tipo_estado_codigo,
		c.MTDTDN		AS		tipo_estado_nombre,
		b.MTDTDC		AS		tipo_subcategoria_codigo,
		b.MTDTDN		AS		tipo_subcategoria_nombre,
		a.MEMEID		AS		empresa_codigo, 
		a.MEMENO		AS		empresa_nombre, 
		a.MEMERU		AS		empresa_ruc,
		a.MEMELO		AS		empresa_logo, 
		a.MEMEOA		AS		empresa_obs_administrador,
        a.MEMEOC		AS		empresa_obs_cliente
		
		FROM EMPMEM a
		INNER JOIN PARMTD b ON a.MEMTSC = b.MTDTDC
		INNER JOIN PARMTD c ON a.MEMTEC = c.MTDTDC
		
        WHERE a.MEMEID = '$val00'
		ORDER BY b.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
				$detalle			= array(
					'tipo_estado_codigo'		=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'		=> $row['tipo_estado_nombre'],
					'tipo_subcategoria_codigo'	=> $row['tipo_subcategoria_codigo'],
					'tipo_subcategoria_nombre'	=> $row['tipo_subcategoria_nombre'],
					'empresa_codigo'		    => $row['empresa_codigo'],
					'empresa_nombre'		    => $row['empresa_nombre'],
					'empresa_ruc'			    => $row['empresa_ruc'],
					'empresa_logo'			    => '../image/empresa/logo/'.$row['empresa_logo'],
					'empresa_obs_administrador' => $row['empresa_obs_administrador'],
					'empresa_obs_cliente'	    => $row['empresa_obs_cliente']
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

	$app->post('/api/v1/800', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['tipo_subcategoria_codigo'];
		$val03                      = strtoupper($request->getParsedBody()['empresa_nombre']);
        $val04                      = strtoupper($request->getParsedBody()['empresa_ruc']);
		$val05                      = $request->getParsedBody()['empresa_logo'];
		$val06                      = $request->getParsedBody()['empresa_obs_administrador'];
		$val07                      = $request->getParsedBody()['empresa_obs_cliente'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "INSERT INTO EMPMEM (MEMTEC, MEMTSC, MEMENO, MEMERU, MEMELO, MEMEOA, MEMEOC) VALUES ('$val01', '$val02', '".$val03."', '".$val04."', '".$val05."', '".$val06."', '".$val07."')";
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

	$app->put('/api/v1/800/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['tipo_subcategoria_codigo'];
		$val03                      = strtoupper($request->getParsedBody()['empresa_nombre']);
        $val04                      = strtoupper($request->getParsedBody()['empresa_ruc']);
		$val05                      = $request->getParsedBody()['empresa_logo'];
		$val06                      = $request->getParsedBody()['empresa_obs_administrador'];
		$val07                      = $request->getParsedBody()['empresa_obs_cliente'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04)) {
            $sql                    = "UPDATE EMPMEM SET MEMTEC = '$val01', MEMTSC = '$val02', MEMENO = '".$val03."', MEMERU = '".$val04."', MEMELO = '".$val05."', MEMEOA = '".$val06."', MEMEOC = '".$val07."' WHERE MEMEID = '$val00'";
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

	$app->delete('/api/v1/800/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM EMPMEM WHERE MEMEID = '$val00'";
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