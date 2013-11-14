<?php

CroogoRouter::connect('/admin/EcoEngine', array('plugin' => 'EcoEngine', 'controller' => 'Settings', 'action' => 'edit', 'admin' => true));
CroogoRouter::connect('/admin/EcoEngine/:action', array('plugin' => 'EcoEngine', 'controller' => 'Settings', 'admin' => true));

