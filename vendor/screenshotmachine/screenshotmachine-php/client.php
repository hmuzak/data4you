<?php
include('ScreenshotMachine.php');

function takeScreenshot($id, $name, $url){
    $customer_key = "4f208b";
    $secret_phrase = ""; //leave secret phrase empty, if not needed
    $machine = new ScreenshotMachine($customer_key, $secret_phrase);
    $options['url'] = $url;
    $options['dimension'] = "1920x1080";
    $options['device'] = "desktop";
    $options['format'] = "jpg";
    $options['cacheLimit'] = "0";
    $options['delay'] = "200";
    $options['zoom'] = "100";
    $output_file = "{$id}_{$name}.jpg";
    $api_url = $machine->generate_screenshot_api_url($options);
    if (!is_dir('files/')) {
        mkdir('files/');
    } //Create a folder "files" and save images inside "files" folder.
    file_put_contents("files/$output_file", file_get_contents($api_url));
}





//put link to your html code

//or save screenshot as an image


//echo 'Screenshot saved as ' . $output_file . PHP_EOL;
