<?php

namespace Vergleichsrechner\Entity;

/**
 * Description of BaseEntity
 *
 * @author Александр
 */
abstract class BaseEntity {

    public function jsonSerialize() {
        $json = array();
        foreach ($this as $key => $value) {
            $json[$key] = $value;
        }
        return $json;
    }

}
