<?php

function setSession($name, $value)
{
    if (!empty(session_id())) {
        if (!empty($name)) {
            $_SESSION[$name] = $value;
            return true;
        }
    }
    return false;
}

function getSession($name)
{
    if (empty($name)) {
        return $_SESSION;
    } else {
        if (!empty($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }

    return false;
}

function removeSession($name)
{
    if (empty($name)) {
        session_destroy();
        return true;
    } else {
        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
            return true;
        }
    }

    return false;
}

// Ham flash data
function setFlashData($name, $value)
{
    $name = 'flash_' . $name;
    return setSession($name, $value);
}

function getFlashData($name)
{
    $name = 'flash_' . $name;
    $data = getSession($name);

    removeSession($name);

    return $data;
}
