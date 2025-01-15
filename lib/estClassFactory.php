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
     * @param class $view
     * @return include
     */
    public static function loadView($view) {
        include $view;
    }


    public function getView() {
        return $this->view;
    }

    public function setView($view) {
        $this->view = $view;
    }
}


?>