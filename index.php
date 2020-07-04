<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Data4You Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Barlow">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Blinker">


</head>

<body>
    <div>
        <div id="app" class="container">
            <h1 class="text-center title-main" style="font-family: Barlow, sans-serif;color: rgb(67,67,67);">Data4You -
                Screenshot Generator </h1>
            <iframe name="dont_refresh" style="display:none;"></iframe>
            <form action="#" method="POST" target="dont_refresh">
                <div class="url-input-div">
                    <input id="url-input-first" class="my-input" type="url" placeholder="Enter the first URL." required name="my-first-url">
                    <i id="my-search-icon" class="fas fa-search"></i>
                </div>
                <div class="url-input-div">
                    <input id="url-input-second" class="my-input" type="url" placeholder="Enter the second URL." required name="my-second-url">
                    <i id="my-search-icon" class="fas fa-search"></i>
                </div>
                <div class="url-input-div">
                    <input id="url-input-third" class="my-input" type="url" placeholder="Enter the third URL." required name="my-third-url">
                    <i id="my-search-icon" class="fas fa-search"></i>
                </div>
                <div class="url-input-div">
                    <input id="url-input-forth" class="my-input" type="url" placeholder="Enter the forth URL." required name="my-forth-url">
                    <i id="my-search-icon" class="fas fa-search"></i>
                </div>
                <div class="url-input-div">
                    <input id="url-input-fifth" class="my-input" type="url" placeholder="Enter the fifth URL." required name="my-fifth-url">
                    <i id="my-search-icon" class="fas fa-search"></i>
                </div>
                <div>
                    <div class="d-flex">
                        <div class="option-div">
                            <input type="radio" id="pc" name="option" checked>
                            <label for="pc">Desktop <i class="fas fa-desktop"></i></label>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-dark text-light my-input-btn" name="submit-btn" data-toggle="modal" data-target="#shareModal">Take Screenshoot!</button>
                </div>
            </form>
        </div>
    </div>
    <!--Link Share Modal-->

    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-light" id="exampleModalLabel">Upload Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-light">Link : <a class="text-decoration-none text-warning" href="https://drive.google.com/drive/folders/1Jb95CJJfKlHWK82fn9uTXmWfPYjFr0tt?usp=sharing">Click</a></p>
                    <p class="text-danger loading-text">It may can take some time...</p>
                </div>

            </div>
        </div>
    </div>
    <?php
    include './vendor/screenshotmachine/screenshotmachine-php/client.php';
    include "uploadFiles.php";

    if(isset($_POST["submit-btn"])){
        $firstUrl = $_POST["my-first-url"];
        $secondUrl = $_POST["my-second-url"];
        $thirdUrl = $_POST["my-third-url"];
        $forthUrl = $_POST["my-forth-url"];
        $fifthUrl = $_POST["my-fifth-url"];
        $urlList = [$firstUrl,$secondUrl,$thirdUrl,$forthUrl,$fifthUrl];
        $nameList= ["iFunded","PropertyPartner","PropertyMoose","Homegrown","RealtyMogul"];
        $count = 0;
        foreach ($urlList as $url) {
            $count++;
            takeScreenshot($count, $nameList[$count - 1], $urlList[$count - 1]);//Taking screenshot from defined urls & saves them inside "files" folder.
        }

        // Uploading Files
        session_start();
        $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $url = $url_array[0];
        require_once 'google-api-php-client/src/Google_Client.php';
        require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
        $client = new Google_Client();
        $client->setClientId('529506816528-dplpnecupn3v6smut37lme1387eu28in.apps.googleusercontent.com'); // Client ID
        $client->setClientSecret('Z8begeIt8z6onZvvO4UiY533'); //Secret code
        $client->setRedirectUri($url);
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        uploadFiles($client,$url); //Upload images to GDrive from the folder "files"
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        //Default values
        document.getElementById('url-input-first').value = 'https://ifunded.de/en/';
        document.getElementById('url-input-second').value = 'https://www.propertypartner.co/';
        document.getElementById('url-input-third').value = 'https://propertymoose.co.uk/';
        document.getElementById('url-input-forth').value = 'https://www.homegrown.co.uk/';
        document.getElementById('url-input-fifth').value = 'https://www.realtymogul.com/';
    </script>
</body>

</html>