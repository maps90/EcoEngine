<?php

CroogoRouter::connect('/admin/EcoEngine', array('plugin' => 'EcoEngine', 'controller' => 'EcoSettings', 'action' => 'edit', 'admin' => true));
CroogoRouter::connect('/admin/EcoEngine/:action', array('plugin' => 'EcoEngine', 'controller' => 'EcoSettings', 'admin' => true));

