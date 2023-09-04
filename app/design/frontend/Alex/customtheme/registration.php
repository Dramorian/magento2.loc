<?php

use Magento\Framework\Component\ComponentRegistrar;

Magento\Framework\Component\ComponentRegistrar::register(
    ComponentRegistrar::THEME,
    'frontend/Alex/customtheme',
    __DIR__
);
