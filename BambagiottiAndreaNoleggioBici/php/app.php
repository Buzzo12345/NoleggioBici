<?php
require_once "Database.php";

class app {
    private PDO $conn;
    
    public function __construct() {
        $this->conn = Database::getConnection();
    }
    
    // ✅ CORRETTO: getBicycles legge BICI
    public function getBicycles(): array {
        $sql = "SELECT * FROM `NOL_BICI`";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ✅ CORRETTO: getStations legge STAZIONI
    public function getStations(): array {
        $sql = "SELECT * FROM `NOL_STAZIONE`";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ✅ CORRETTO: Costruisce le <option> per la select
    public function getOptionsHtml(): string {
        $righeStazioni = $this->getStations();
        $righeBicycles = $this->getBicycles();
        
        // Opzioni stazioni - HTML corretto
        $optionsHtmlStazioni = "<option value=''>-- Seleziona una stazione --</option>\n";
        foreach ($righeStazioni as $r) {
            $optionsHtmlStazioni .= "<option value='" 
                          . htmlspecialchars($r['STA_ID']) . "'>" 
                          . htmlspecialchars($r['STA_LUOGO']) . " - "
                          . htmlspecialchars($r['STA_NOME'])
                          . "</option>\n";
        }
        
        // Tabella Bici con HTML semantico
        $tabella = "<table border='1' cellpadding='10'>\n";
        $tabella .= "<thead>\n";
        $tabella .= "<tr>\n";
        $tabella .= "<th>ID Bici</th>\n";
        $tabella .= "<th>Disponibilità</th>\n";
        $tabella .= "</tr>\n";
        $tabella .= "</thead>\n";
        $tabella .= "<tbody>\n";
        
        foreach ($righeBicycles as $r) {
            $tabella .= "<tr>\n";
            $tabella .= "<td>" . htmlspecialchars($r['BIC_ID']) . "</td>\n";
            $tabella .= "<td>" . htmlspecialchars($r['BIC_DISPONIBILE']) . "</td>\n";
            $tabella .= "</tr>\n";
        }
        
        $tabella .= "</tbody>\n";
        $tabella .= "</table>\n";
        
        // Carica HTML con gestione errori
        if (!file_exists("app.html")) {
            return "Errore: file app.html non trovato";
        }
        
        $html = file_get_contents("app.html");
        if ($html === false) {
            return "Errore: impossibile leggere il file app.html";
        }
        
        // Replace dei placeholder nel template
        $html = str_replace("{STAZIONI}", $optionsHtmlStazioni, $html);
        $html = str_replace("{BICI}", $tabella, $html);
        
        return $html;
    }
}
?>