<?php
$jsArray = json_encode($attachments);
$script = "var attachments = ". $jsArray . ";\n";
$script .= <<<EOT
        window.opener.catchArray(attachments, '$returnTo');
        window.close();
EOT;
$this->Js->buffer($script);