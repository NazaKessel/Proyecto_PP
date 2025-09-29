<?php
// Archivo: promociones_model.php
include("conexion.php");

class PromocionesModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    // Obtener todos los autos
    public function getAutos() {
        try {
            $stmt = $this->conn->query("SELECT id, marca, modelo, patente FROM autos");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al cargar autos: " . $e->getMessage();
            return [];
        }
    }

    // Insertar una nueva promoción
    public function insertarPromocion($auto_id, $descripcion, $precio) {
        try {
            $sql = "INSERT INTO promociones (auto_id, descripcion, precio, creado_en)
                    VALUES (:auto_id, :descripcion, :precio, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':auto_id' => $auto_id,
                ':descripcion' => $descripcion,
                ':precio' => $precio
            ]);
        } catch (PDOException $e) {
            echo "Error al insertar promoción: " . $e->getMessage();
        }
    }

    // Obtener todas las promociones con información del auto
    public function getPromociones() {
        try {
            $sql = "SELECT p.id, p.descripcion, p.precio, p.creado_en,
                           a.marca, a.modelo, a.patente
                    FROM promociones p
                    INNER JOIN autos a ON p.auto_id = a.id";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al cargar promociones: " . $e->getMessage();
            return [];
        }
    }

    // Eliminar promoción por ID
    public function eliminarPromocion($id) {
        try {
            $sql = "DELETE FROM promociones WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            echo "Error al eliminar promoción: " . $e->getMessage();
        }
    }
}
?>
