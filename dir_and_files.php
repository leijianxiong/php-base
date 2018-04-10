<?php

// db 查询出来所有知识 select * from `table_name`;
$sql = 'select * from cc_faq';
//$sql = 'select nID, fatherId, FaqTitle, `Sort` from cc_faq';
$knowledges = app('db')->createCommand($sql)->queryAll();
$converted = [];

$tempFiles = [];
foreach ($knowledges as $knowledge) {
    if ($knowledge['fatherId'] == -1) {
        $converted[$knowledge['nID']] = [
            'dir' => $knowledge,
            'files' => [],
        ];
        if (isset($tempFiles[$knowledge['nID']])) {
            $converted[$knowledge['nID']]['files'] = $tempFiles[$knowledge['nID']];
            unset($tempFiles[$knowledge['nID']]);
        }
    } else {
        if (isset($converted[$knowledge['fatherId']]['files'])) {
            $converted[$knowledge['fatherId']]['files'][] = $knowledge;
        } else {
            $tempFiles[$knowledge['fatherId']][] = $knowledge;
        }
    }
}
//echo json_encode(array_values($converted));
$converted = array_values($converted);

//echo
echo "\n";
foreach ($converted as $dir) {
    echo "{$dir['dir']['nID']} {$dir['dir']['FaqTitle']}\n";
    foreach ($dir['files'] as $file) {
        echo "\t{$file['nID']} {$file['FaqTitle']}\n";
    }
}
