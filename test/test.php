<html>
    <head>
        <script>
            function showUser(str) {
                if (str == "") {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else {
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET", "../test/getstuff.php?q=" + str, true);
                    xmlhttp.send();
                }
            }
        </script>
    </head>
    <body>

        <form>
            <select name="users" onchange="showUser(this.value)">
                <option disabled selected value> -- select category -- </option>
                <option value="stationary">Stationary Supplies</option>
                <option value="sanitary">Sanitary Supplies</option>
                <option value = "tech">IT Supplies</option>
            </select>
        </form>
        <br>
        <div id="txtHint">
            
            
        </div>

    </body>
</html>