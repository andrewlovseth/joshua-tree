<?php 

function esa_svg($url) {

    $stream_opts = [
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false,
        ]
    ];

    if($url) {
        $svg = file_get_contents($url, false, stream_context_create($stream_opts));
        return $svg;
    }
}