<?php

if (! function_exists('respond')) {

    /**
     * Get a class accessor for the respond class.
     *
     * @return \Alacrity\Responses\Respond
     */
    function respond()
    {
        return new \Alacrity\Responses\Respond();
    }
}
