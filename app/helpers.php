<?php

function isRouteActive($name) {
    return Route::currentRouteNamed($name);
}