<?php
    $app->get('/api/v1/700', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$sql                        = "SELECT
		d.MTDTDC		AS		tipo_estado_codigo,
		d.MTDTDN		AS		tipo_estado_nombre,
		c.MTDTDC		AS		tipo_documento_codigo,
		c.MTDTDN		AS		tipo_documento_nombre,
		b.MTDTDC		AS		tipo_persona_codigo,
		b.MTDTDN		AS		tipo_persona_nombre,
		a.MPEPID		AS		persona_codigo, 
		a.MPEPNO		AS		persona_nombre, 
		a.MPEPAP		AS		persona_apellido,
		a.MPEPDN		AS		persona_documento_numero, 
		a.MPEPFN		AS		persona_fecha_nacimiento
		
		FROM PERMPE a
		INNER JOIN PARMTD b ON a.MPETPC = b.MTDTDC
		INNER JOIN PARMTD c ON a.MPETDC = c.MTDTDC
		INNER JOIN PARMTD d ON a.MPETEC = d.MTDTDC
		
		ORDER BY b.MTDTDN, d.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {
				$fecha1 = new DateTime($row['persona_fecha_nacimiento']);
    			$fecha2 = new DateTime();
    			$fecha  = $fecha1->diff($fecha2);
				
				$detalle			= array(
					'tipo_estado_codigo'		=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'		=> $row['tipo_estado_nombre'],
					'tipo_persona_codigo'		=> $row['tipo_persona_codigo'],
					'tipo_persona_nombre'		=> $row['tipo_persona_nombre'],
					'tipo_documento_codigo'		=> $row['tipo_documento_codigo'],
					'tipo_documento_nombre'		=> $row['tipo_documento_nombre'],
					'persona_codigo'			=> $row['persona_codigo'],
					'persona_nombre'			=> $row['persona_nombre'],
					'persona_apellido'			=> $row['persona_apellido'],
					'persona_apellido_nombre'	=> $row['persona_apellido'].', '.$row['persona_nombre'],
					'persona_documento_numero'	=> $row['persona_documento_numero'],
					'persona_fecha_nacimiento'	=> $row['persona_fecha_nacimiento'],
					'persona_edad'				=> $fecha->y
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

    $app->get('/api/v1/700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
		$val00                      = $request->getAttribute('codigo');
		$sql                        = "SELECT
		d.MTDTDC		AS		tipo_estado_codigo,
		d.MTDTDN		AS		tipo_estado_nombre,
		c.MTDTDC		AS		tipo_documento_codigo,
		c.MTDTDN		AS		tipo_documento_nombre,
		b.MTDTDC		AS		tipo_persona_codigo,
		b.MTDTDN		AS		tipo_persona_nombre,
		a.MPEPID		AS		persona_codigo, 
		a.MPEPNO		AS		persona_nombre, 
		a.MPEPAP		AS		persona_apellido,
		a.MPEPDN		AS		persona_documento_numero, 
		a.MPEPFN		AS		persona_fecha_nacimiento
		
		FROM PERMPE a
		INNER JOIN PARMTD b ON a.MPETPC = b.MTDTDC
		INNER JOIN PARMTD c ON a.MPETDC = c.MTDTDC
		INNER JOIN PARMTD d ON a.MPETEC = d.MTDTDC
		
		WHERE a.MPEPID = '$val00'
		ORDER BY b.MTDTDN, d.MTDTDN";
		
        if ($query = $mysqli->query($sql)) {
            while($row = $query->fetch_assoc()) {				
                $fecha1 = new DateTime($row['persona_fecha_nacimiento']);
    			$fecha2 = new DateTime();
    			$fecha  = $fecha1->diff($fecha2);
				
				$detalle			= array(
					'tipo_estado_codigo'		=> $row['tipo_estado_codigo'],
					'tipo_estado_nombre'		=> $row['tipo_estado_nombre'],
					'tipo_persona_codigo'		=> $row['tipo_persona_codigo'],
					'tipo_persona_nombre'		=> $row['tipo_persona_nombre'],
					'tipo_documento_codigo'		=> $row['tipo_documento_codigo'],
					'tipo_documento_nombre'		=> $row['tipo_documento_nombre'],
					'persona_codigo'			=> $row['persona_codigo'],
					'persona_nombre'			=> $row['persona_nombre'],
					'persona_apellido'			=> $row['persona_apellido'],
					'persona_apellido_nombre'	=> $row['persona_apellido'].', '.$row['persona_nombre'],
					'persona_documento_numero'	=> $row['persona_documento_numero'],
					'persona_fecha_nacimiento'	=> $row['persona_fecha_nacimiento'],
					'persona_edad'				=> $fecha->y
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

	$app->post('/api/v1/700', function($request) {
        require __DIR__.'/../src/connect.php';

		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['tipo_persona_codigo'];
		$val03                      = $request->getParsedBody()['tipo_documento_codigo'];
        $val04                      = strtoupper($request->getParsedBody()['persona_nombre']);
		$val05                      = strtoupper($request->getParsedBody()['persona_apellido']);
		$val06                      = $request->getParsedBody()['persona_documento_numero'];
		$val07                      = $request->getParsedBody()['persona_fecha_nacimiento'];
        
        if (isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07)) {
            $sql                    = "INSERT INTO PERMPE (MPETEC, MPETPC, MPETDC, MPEPNO, MPEPAP, MPEPDN, MPEPFN) VALUES ('$val01', '$val02', '$val03', '".$val04."', '".$val05."', '".$val06."', '".$val07."')";
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

	$app->put('/api/v1/700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
		$val01                      = $request->getParsedBody()['tipo_estado_codigo'];
        $val02                      = $request->getParsedBody()['tipo_persona_codigo'];
		$val03                      = $request->getParsedBody()['tipo_documento_codigo'];
        $val04                      = strtoupper($request->getParsedBody()['persona_nombre']);
		$val05                      = strtoupper($request->getParsedBody()['persona_apellido']);
		$val06                      = $request->getParsedBody()['persona_documento_numero'];
		$val07                      = $request->getParsedBody()['persona_fecha_nacimiento'];
        
        if (isset($val00) && isset($val01) && isset($val02) && isset($val03) && isset($val04) && isset($val05) && isset($val06) && isset($val07)) {
            $sql                    = "UPDATE PERMPE SET MPETEC = '$val01', MPETPC = '$val02', MPETDC = '$val03', MPEPNO = '".$val04."', MPEPAP = '".$val05."', MPEPDN = '".$val06."', MPEPFN = '".$val07."' WHERE MPEPID = '$val00'";
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

	$app->delete('/api/v1/700/{codigo}', function($request) {
        require __DIR__.'/../src/connect.php';
        
        $val00                      = $request->getAttribute('codigo');
        
        if (isset($val00)) {
            $sql = "DELETE FROM PERMPE WHERE MPEPID = '$val00'";
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