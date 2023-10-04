<?php

namespace Dhenfie\Accessible {

    /**
     * Accessible Object
     *
     * @param  object  $object
     * @return Accessible
     */
    function accessible(object $object): Accessible
    {
        return Accessible::inspect($object);
    }
}