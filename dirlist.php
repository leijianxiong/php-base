#!/bin/bash php
<?php
/**
 * 给定一个目录, 列出目录里所有的文件
 */

$entry = $argv[1];

function listdir($entry, $maxlevel = 3, $currentLevel = 1) {
    if ($currentLevel > $maxlevel) {
        return null;
    }

    if ($files = @scandir($entry)) {
        foreach ($files as $file) {
            if ($file == "." || $file == "..") {
                continue;
            }
            $fullpath = rtrim($entry, "/")."/$file";
            echo $fullpath."\n";
            if (is_dir($fullpath)) {
                listdir($fullpath, $maxlevel, $currentLevel+1);
            }
        }
    }
    return null;
}

listdir($entry);
