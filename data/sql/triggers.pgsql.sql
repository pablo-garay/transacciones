CREATE OR REPLACE FUNCTION usuario_add() RETURNS trigger AS $$
    BEGIN
        NEW.estado_cuenta := 'A';
        
        RETURN NEW;
    END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS usuario_add ON usuarios;

CREATE TRIGGER usuario_add BEFORE INSERT ON usuarios
    FOR EACH ROW EXECUTE PROCEDURE usuario_add();



CREATE OR REPLACE FUNCTION solicitud_insert() RETURNS trigger AS $$
    BEGIN
	NEW.fecha_solicitada := current_date;
        NEW.estado_solicitud := 'NUEVO';
        NEW.etapa_actual := 'RCDA';
        NEW.resultado_requisitos := 'NO_VERIFICADO';
        NEW.mesa_entrada := NEW.solicitud;
        
        RETURN NEW;
    END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS solicitud_insert ON solicitudes;

CREATE TRIGGER solicitud_insert BEFORE INSERT ON solicitudes
    FOR EACH ROW EXECUTE PROCEDURE solicitud_insert();



CREATE OR REPLACE FUNCTION extraordinario_insert() RETURNS trigger AS $$
    BEGIN
	NEW.cumple_fecha := 'NO_VERIFICADO';
        NEW.ausente_tercera_op := 'NO_VERIFICADO';
        NEW.inscripto_tercera_op := 'NO_VERIFICADO';
        
        RETURN NEW;
    END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS extraordinario_insert ON solicitud_de_extraordinario;

CREATE TRIGGER extraordinario_insert BEFORE INSERT ON solicitud_de_extraordinario
    FOR EACH ROW EXECUTE PROCEDURE extraordinario_insert(); 