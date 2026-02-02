<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: University of Muenster <info@uni-muenster.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

return [
    "routes" => [
        // LaunchController
        [
            "name" => 'launch#app',
            "url" => '/launcher/app',
            "verb" => 'GET',
        ],
    ]
];
