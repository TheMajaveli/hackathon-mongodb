<?php
// Tâche Dev 1

class ViewHelper {
    /**
     * Render a view with layout
     */
    public static function render($viewName, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Start output buffering
        ob_start();
        
        // Include the view file
        $viewPath = __DIR__ . '/' . $viewName . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<div class='empty-state'><h2>View not found: $viewName</h2></div>";
        }
        
        // Get the view content
        $content = ob_get_clean();
        
        // Include layout with content
        $title = $data['title'] ?? ucfirst($viewName);
        include __DIR__ . '/layout.php';
    }
    
    /**
     * Format date
     */
    public static function formatDate($date) {
        if (!$date) return '-';
        return date('d/m/Y H:i', strtotime($date));
    }
    
    /**
     * Format ObjectId for display
     */
    public static function formatId($id) {
        if (is_array($id) && isset($id['$oid'])) {
            return $id['$oid'];
        }
        return $id;
    }
    
    /**
     * Generate pagination links
     */
    public static function pagination($currentPage, $totalPages, $baseUrl) {
        if ($totalPages <= 1) return '';
        
        $html = '<div class="pagination">';
        
        // Previous
        if ($currentPage > 1) {
            $html .= '<a href="' . $baseUrl . '?page=' . ($currentPage - 1) . '">← Précédent</a>';
        } else {
            $html .= '<span>← Précédent</span>';
        }
        
        // Page numbers
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                $html .= '<span class="active">' . $i . '</span>';
            } else {
                $html .= '<a href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a>';
            }
        }
        
        // Next
        if ($currentPage < $totalPages) {
            $html .= '<a href="' . $baseUrl . '?page=' . ($currentPage + 1) . '">Suivant →</a>';
        } else {
            $html .= '<span>Suivant →</span>';
        }
        
        $html .= '</div>';
        return $html;
    }
    
    /**
     * Make API request
     */
    public static function apiRequest($endpoint) {
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . 
                   '://' . $_SERVER['HTTP_HOST'];
        
        // Ensure endpoint starts with /
        if (strpos($endpoint, '/') !== 0) {
            $endpoint = '/' . $endpoint;
        }
        
        $url = $baseUrl . $endpoint;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($httpCode === 200 && !$error) {
            $data = json_decode($response, true);
            // Handle different response structures
            if (isset($data['data'])) {
                return $data['data'];
            } elseif (isset($data['success']) && $data['success']) {
                return $data['data'] ?? [];
            }
            return $data ?? [];
        }
        
        return [];
    }
}
