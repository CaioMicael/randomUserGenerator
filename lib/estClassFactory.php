<?php
namespace lib;

require_once '../autoload.php';

/**
 * Classe com métodos estáticos feita para criar estruturas gerais de forma automática.
 * 
 * @author Caio Micael Krieger
 */
class estClassFactory {
    private object $view;


    /**
     * Este método chama a view solicitada e apresenta na view atual.
     * 
     * @param  string $view
     * @return include
     */
    public static function loadView($view) {
        class_exists($view, true);
    }


    public function getView() {
        return $this->view;
    }

    public function setView($view) {
        $this->view = $view;
    }
}


?>