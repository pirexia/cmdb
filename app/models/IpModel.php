<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IpModel extends CI_Model {
    public function guardarIPs($objeto_id, $ipsData) {
        $this->db->delete('objetos_ips', ['objeto_id' => $objeto_id]);
        
        foreach ($ipsData as $ipEntry) {
            if (!empty($ipEntry['ip'])) {
                $ipData = [
                    'objeto_id' => $objeto_id,
                    'tipo_ip' => $ipEntry['tipo'] ?? 'principal',
                    'direccion_ip' => $ipEntry['ip'],
                    'mascara' => $ipEntry['mascara'] ?? null,
                    'gateway' => $ipEntry['gateway'] ?? null,
                    'vlan' => $ipEntry['vlan'] ?? null,
                    'dns_primario' => $ipEntry['dns_primario'] ?? null,
                    'dns_secundario' => $ipEntry['dns_secundario'] ?? null,
                    'notas' => $ipEntry['notas'] ?? null
                ];
                
                $this->db->insert('objetos_ips', $ipData);
            }
        }
    }
    
    public function getPorObjeto($objeto_id) {
        return $this->db->get_where('objetos_ips', ['objeto_id' => $objeto_id])->result();
    }
}