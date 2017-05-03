<!DOCTYPE HTML>
<!--
	Alpha by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)s
    -->
<html>

<head>
    <title>Phone Add-in For XLS</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
</head>

<body>
    <div id="page-wrapper">
        <!-- Header -->
        <header id="header">
            <h1 style="color: white; font-size: 24px;">Phone Add-in For XLS</h1>
            <nav id="nav">
                <ul>
                    <li ><a href="index.php">Home</a></li>
                    <li class="active"><a href="upload.php">Upload File</a></li>
                </ul>
            </nav>
        </header>
        <!-- Main -->
        <section id="main" class="container">
            <div class="row">
                <div class="12u">
                    <!-- Form -->
                    <section class="box">
                        <h3>Upload Excel File</h3>
                      
                        <hr />
                        <form method="post" action="fileUploadCtrl.php" enctype="multipart/form-data">
                            <div class="row uniform 50%">
                                <div class="9u 12u(mobilep)">
                                    <input type="file" name="file" id="file" value="" placeholder="File" />
                                </div>
                                <div class="3u 12u(mobilep)">
                                    <input type="submit" value="Upload" class="fit" />
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </div>
    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.dropotron.min.js"></script>
    <script src="assets/js/jquery.scrollgress.min.js"></script>
    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/util.js"></script>
    <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
    <script src="assets/js/main.js"></script>
</body>

</html>
