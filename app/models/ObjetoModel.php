<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ObjetoModel extends Model {
    protected $table = 'objetos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre', 'descripcion', 'tipo', 'clase_id', 'estado', 
        'ip', 'ip_consola', 'ubicacion', 'planta', 'modulo', 
        'rack', 'u', 'brs', 'usuario_creador_id', 'notas'
    ];

    // Métodos básicos CRUD
    public function getById($id) {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?", 
            [$id]
        )->row();
    }

    public function getAll() {
        return $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY nombre ASC"
        )->result();
    }

    public function save($data) {
        if (isset($data[$this->primaryKey])) {
            // Actualizar
            $id = $data[$this->primaryKey];
            unset($data[$this->primaryKey]);
            return $this->db->update($this->table, $data, "{$this->primaryKey} = ?", [$id]);
        } else {
            // Crear nuevo
            return $this->db->insert($this->table, $data);
        }
    }

    public function delete($id) {
        return $this->db->delete(
            $this->table, 
            "{$this->primaryKey} = ?", 
            [$id]
        );
    }

    // Métodos específicos del CMDB
    public function countAll() {
        $result = $this->db->query(
            "SELECT COUNT(*) as total FROM {$this->table}"
        )->row();
        return $result->total ?? 0;
    }

    public function countByEstado($estado) {
        $result = $this->db->query(
            "SELECT COUNT(*) as total FROM {$this->table} WHERE estado = ?",
            [$estado]
        )->row();
        return $result->total ?? 0;
    }

	public function getProximosVencimientosPublicos($limit = 5) {
		return $this->db->query("
			SELECT 
				o.id,
				o.nombre,
				tf.nombre as tipo_fecha,  -- Comentario SQL válido
				f.fecha,
				DATEDIFF(f.fecha, CURDATE()) as dias_restantes
			FROM fechas_objeto f
			JOIN objetos o ON o.id = f.objeto_id
			JOIN tipos_fecha tf ON tf.id = f.tipo_fecha_id
			WHERE f.fecha >= CURDATE()
			ORDER BY f.fecha ASC
			LIMIT ?
		", [$limit])->result();
	}

    public function getEstadisticasEstadoPublicas() {
        return $this->db->query("
            SELECT 
                estado,
                COUNT(*) as total,
                ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM objetos), 2) as porcentaje
            FROM objetos
            GROUP BY estado
        ")->result();
    }

    public function search($query) {
        return $this->db->query("
            SELECT * FROM {$this->table}
            WHERE 
                nombre LIKE ? OR
                descripcion LIKE ? OR
                ip LIKE ? OR
                ip_consola LIKE ?
            ORDER BY nombre ASC
            LIMIT 50
        ", [
            "%{$query}%", "%{$query}%", 
            "%{$query}%", "%{$query}%"
        ])->result();
    }

    public function ipExiste($ip, $excludeId = null) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} 
                WHERE (ip = ? OR ip_consola = ?)";
        
        $params = [$ip, $ip];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $result = $this->db->query($sql, $params)->row();
        return $result->total > 0;
    }

    public function getByClase($claseId) {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE clase_id = ?",
            [$claseId]
        )->result();
    }

    public function getRelaciones($objetoId) {
        return $this->db->query("
            SELECT 
                a.tipo_relacion,
                o.* 
            FROM asociaciones a
            JOIN objetos o ON o.id = a.objeto_hijo_id
            WHERE a.objeto_padre_id = ?
            UNION
            SELECT 
                a.tipo_relacion,
                o.* 
            FROM asociaciones a
            JOIN objetos o ON o.id = a.objeto_padre_id
            WHERE a.objeto_hijo_id = ?
        ", [$objetoId, $objetoId])->result();
    }
}