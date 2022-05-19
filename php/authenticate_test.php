<?php

    //start the session
    session_start();
    ?>
<!DOCTYPE html>
<html>
<head>
    <script>
        function test_auth(privilage, userId) {
            var xmlhttp = new XMLHttpRequest();
            var url = 'authenticate.php';
            var params = 'privilage='.concat(privilage).concat('&user_id=').concat(userId);
            xmlhttp.open('POST', url, true);

            xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert();
                    alert(xmlhttp.response);
                }
            }

            xmlhttp.send(params);
        }

    </script>
</head>
<body>

<!--    create html page with 3 buttons, one for each privilage-->
<form><button onclick="test_auth('none', null)">no privileges</button></form>

<form><button onclick="test_auth('user', bestaand_user_id)">user privilage</button></form>

<form><button onclick="test_auth('admin', bestaand_admin_id)">admin privilages</button></form>

</body>
</html>
