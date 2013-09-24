<?php

/**
 * HashMap
 * 
 * Equivalent de JAVA HashMap en PHP
 * 
 * @access public
 * @author Ambrosini Loïc (CraZyBaLL) <loic.ambrosini@me.com>
 */
class HashMap implements \Iterator {

    private $_hashTable = array();
    private $_valid = true;

    /**
     * Supprime les clef/valeurs de la HashMap
     * @return void
     */
    public function clear() {
        $this->_hashTable = array();
    }
    
    /**
     * Retourne 'true' si la map contient la clef spécifiée
     * @param string $key
     * @return boolean
     */
    public function containsKey($key) {
        if(!is_scalar($key)) {
            throw new Exception("La clef de HashMap doit être une donnée scalaire");
        }
        if(empty($key)) {
            throw new Exception("Clef vide passée dans HashMap::containsKey");
        }
        return array_key_exists($key, $this->_hashTable);
    }

    /**
     * Retourne 'true' si la map contient la valeur spécifiée
     * @param mixed $value
     * @return boolean
     */
    public function containsValue($value) {
        return in_array($value, $this->_hashTable);
    }

    /**
     * Retourne la valeur de la map pour la clef spécifiée
     * @param string $key clef
     * @return mixed valeur
     */
    public function get($key) {
        if(!key_exists($key, $this->_hashTable)) {
            return NULL;
        }
        return $this->_hashTable[$key];
    }

    /**
     * Retourne 'true' si la map ne contient aucun mapping clef/valeur
     * @return boolean
     */
    public function isEmpty() {
        if(count($this->_hashTable) === 0) {
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Retourne un tableau de clefs de la HashMap
     * @return array
     */
    public function keySet() {
        return array_keys($this->_hashTable);
    }
    
    /**
     * Renseigner une paire de clef/valeur dans la map
     * @param scalar $key clef
     * @param mixed $value valeur
     * @return void
     */
    public function put($key, $value) {
        if(is_scalar($key)) {
            if( !$this->_retainKeyCase) {
                $key = strtolower($key);
            }
        }
        $this->_hashTable[$key] = $value;
    }

    /**
     * Combine les valeurs d'une HashMap avec cette HashMap
     * @param HashMap $hash
     */
    public function putAll(HashMap $hash) {
        foreach($hash as $key => $value) {
            $this->put($key, $value);
        }
    }
    
    /**
     * Supprime une association clef/valeur de la map
     * @param scalar $key
     */
    public function remove($key) {
        unset($this->_hashTable[$key]);
    }

    /**
     * Retourne la taille de la HashMap
     * @return int
     */
    public function size() {
        return count($this->_hashTable);
    }
    
    /**
     * Retourne une representation string de la HashMap construite sous la forme
     * [Nom de la classe]@[hash de la classe]
     * @return string
     */
    public function __toString() {
        return __CLASS__ . '@' . hash($this);
    }
    
    /**
     * Retourne une collection de valeurs (sans clefs)
     * @return array
     */
    public function values() {
        return array_values($this->_hashTable);
    }

    /**
     * Retourne la HashMap sous forme de tableau
     * @return HashMap
     */
    public function getAll() {
        return $this->_hashTable;
    }

    /**
     * Retourne sous forme de string le tableau de map clef/valeur
     * @return String
     * @param String $endLine[optional]
     */
    public function toString($endLine = "\n") {
        $string = "";
        foreach($this as $key => $value) {
            if(is_object($value)) {
                $string .= "[$key] : " . $value->toString() . $endLine;
                continue;
            }
            $string .= "$key : $value $endLine";
        }
        return $string;
    }

    /**
     * Ajouter tous les elements d'un tableau dans cette Map
     * @param array $source
     */
    public function addArray(array $source) {
        if(!is_array($source)) {
            throw new Exception("Le parametre n'est pas un tableau");
        }
        foreach($source as $key => $value) {
            $this->put($key, $value);
        }
    }

    // Methodes de l'Iterator 
    
    public function rewind() {
        $this->_valid = (FALSE !== reset($this->_hashTable));
    }

    public function current() {
        return current($this->_hashTable);
    }

    public function key() {
        return key($this->_hashTable);
    }

    public function next() {
        $this->_valid = (FALSE !== next($this->_hashTable));
    }

    public function valid() {
        return $this->_valid;
    }
}