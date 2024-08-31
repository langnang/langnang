<?php

return [
  "max_depth" => "3",
  "themes" => [
    "default" => "dumper",
    "options" => [
      "default" => [
        "details" => [
          "open" => true,
        ],
        "styles" => [
          "container" => [
            "font-size" => "87.5%",
          ],
          "string" => [
            "color" => "#cc0000",
          ],
          "integer" => [
            "color" => "#4e9a06",
          ],
          "null" => [
            "color" => "#3465a4",
          ],
          "empty" => [
            "color" => "#888a85"
          ],
          "array_key" => [
            // "color" => "#56DB3A",
          ]
        ],

      ],
      "dumper" => [
        "details" => [
          "open" => true,
        ],
        "styles" => [
          "container" => [
            "font-size" => "87.5%",
            "background-color" => "#18171B",
            "color" => "#FF8400",
          ],
          "summary" => [
            "float" => "left",
            "font-size" => "small",
          ],
          "string" => [
            "color" => "#56DB3A",
          ],
          "integer" => [
            "color" => "#1299DA",
          ],
          "null" => [
            // "color" => "#3465a4",
          ],
          "empty" => [
            "color" => "#888a85"
          ],
          "array_type" => [
            "color" => "#1299DA",
          ],
          "array_key" => [
            "color" => "#56DB3A",
          ],
          "object_type" => [
            "color" => "#1299DA",
          ],
          "object_key" => [
            "color" => "#FFFFFF",
          ],
        ],

      ],
    ],
  ]
];
