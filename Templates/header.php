<?php 
include("../db/db3.php");
include("../db/db2.php");
include("../Login/session.php");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HR DEPT</title>
        <link href="bootstrapCSS" rel="stylesheet">
        <script type = "text/javascript" src = "bootstrapvalidate"></script>

        <!--Bootstrap link-->
        <script type = "text/javascript" src = "bootstrap"></script>

        <!--JQuery link-->
        <script src = "jquerylib" type = "text/javascript"></script>

        <!--datatables JS link-->
        <!--<script src = "http://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" type = "text/javascript"></script>-->
        <script src = "datatableslib" type = "text/javascript"></script>
        <!--datatables table tools JS link-->
        <!--<script src = "http://cdn.datatables.net/tabletools/2.2.4/js/TableTools.js" type = "text/javascript"></script> -->
        <script src = "tabletoolslib" type = "text/javascript"></script>
        
        
        <script src = "tabletoolsbuttonlib" type = "text/javascript"></script>
        <script src = "buttonflashlib" type = "text/javascript"></script>
        <script src = "pdfmakelib" type = "text/javascript"></script>

        <!--datatables CSS link-->
        <!--<link rel = "stylesheet" href = "http://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">-->
        <link rel = "stylesheet" href = "datatablesCSS">

        <!--datatables table tools CSS link-->
        <!--<link rel = "stylesheet" href = "http://cdn.datatables.net/tabletools/2.2.4/css/TableTools.css">-->
        <link rel = "stylesheet" href = "tabletoolsCSS">
        
        <link rel = "stylesheet" href = "tabletoolsbuttonCSS">

        <script src="newstickerlib"></script>
        <script src="newstapelib"></script>
        <script src="mousewheellib"></script>
        <link rel = "stylesheet" href = "newstickerCSS">
        <link rel = "stylesheet" href = "newstapeCSS">
        <link rel="stylesheet" href="resetfontminCSS"><!--remove or edit if font needs to increase-->
        <link rel="stylesheet" href="clearfixCSS">
        <script>
            // start
            $(function () {
                $('.newsticker').newsticker({
                    //height: 30 //default: 30
                });
            });
        </script>
        
        <script>
            // start
            $(function () {
                $('.newstape').newstape();
            });
        </script>





