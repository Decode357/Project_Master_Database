<?php

return [

    'graph' => [
        // layout engine: dot, neato, circo, twopi, fdp, sfdp
        'layout'  => 'dot',

        // การจัดเรียงทิศทาง: TB = Top→Bottom, LR = Left→Right
        'rankdir' => 'TB',

        // ระยะห่าง
        'nodesep' => 1.2,   // default ~0.25 (เพิ่มระยะ node ให้โปร่ง)
        'ranksep' => 1.5,   // default ~0.5 (เพิ่มระยะระหว่างชั้น)

        // style ของ diagram
        'bgcolor' => '#ffffff',
        'splines' => 'ortho',  // เส้นเป็นมุมฉาก อ่านง่ายกว่าที่พันกัน
        'overlap' => false,
        'outputorder' => 'edgesfirst',
    ],

    'node' => [
        'shape'     => 'record',
        'style'     => 'rounded,filled',
        'fillcolor' => '#f9fafb',
        'fontname'  => 'Arial',
        'fontsize'  => 12,
        'margin'    => '0.4,0.4', // เพิ่ม margin ในกล่อง
    ],

    'edge' => [
        'color'     => '#666666',
        'arrowsize' => 0.8,
        'penwidth'  => 1.0,
        'fontname'  => 'Arial',
        'fontsize'  => 12,

        'minlen'    => 2,
        'constraint'=> true,
        // กำหนดให้บังคับมี arrow ปลายเส้น
        'arrowhead' => 'normal',
        'arrowtail' => 'none',
        'dir'       => 'forward', // บังคับให้แสดง arrow

        'labeldistance'=> 2.0,    // ระยะ label จากเส้น
        'labelangle'   => 0,      // ปรับมุม (0 = ตามเส้น)
        
    ],
];
