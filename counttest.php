<?php
$lines = 0;
$total_lines = 0;
$verbose = 0;
$file_type_html = 0;

function rglob($pattern = '*', $flags = 0, $path = '')
{
    $paths = glob($path . '*', GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT);
    $files = glob($path . $pattern, $flags);
    foreach ($paths as $path) {
        $files = array_merge($files, rglob($pattern, $flags, $path));
    }
    return $files;
}

// check for command line args
if ($argc > 1) {
    if (in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
        echo "-v	verbose\n";
        echo "-html	count html files\n";
        exit(0);
    }
    if (array_search('-v', $argv))
        $verbose = 1;
    if (array_search('-html', $argv))
        $file_type_html = 1;
}

$file_array_php = rglob('*.php');
$file_array_incs = rglob('*.inc');
if ($file_type_html)
    $file_array_html = rglob('*.htm*'); // catch *.html and *.htm

if ($verbose) {
    var_export($file_array_php);
    var_export($file_array_incs);
    if ($file_type_html)
        var_export($file_array_html);
}

foreach ($file_array_php as $file) {
    $lines = count(file($file));
    $total_lines += $lines;
    if ($verbose) {
        echo "\n";
        echo "$lines in the file $file";
    }
}

foreach ($file_array_incs as $file) {
    $lines = count(file($file));
    $total_lines += $lines;
    if ($verbose) {
        echo "\n";
        echo "$lines in the file $file";
    }
}

if ($file_type_html) {
    foreach ($file_array_html as $file) {
        $lines = count(file($file));
        $total_lines += $lines;
        if ($verbose) {
            echo "\n";
            echo "$lines in the file $file";
        }
    }
}
echo "\n\n\n";
echo "There are a total of $total_lines lines\n";

?>

