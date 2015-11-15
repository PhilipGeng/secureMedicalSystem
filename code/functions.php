<?php
    include_once '../dbconfig/link.php';
    
    function sec_session_start() {
        $session_name = 'sec_session_id';    // Set a custom session name
        $secure = SECURE;    // This stops JavaScript being able to access the session id.
        $httponly = true;    // Forces sessions to only use cookies.
        
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }
        
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"],
                                  $cookieParams["path"],
                                  $cookieParams["domain"],
                                  $secure,
                                  $httponly);
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session
        session_regenerate_id(true);    // regenerated the session, delete the old one.
    }
    
    function doctor_login($doctor_id, $password, $mysqli) {
        if($stmt = $mysqli->prepare("SELECT password, salt 
                                     FROM doctor
                                     WHERE doctor_id = ?
                                     LIMIT 1")){
                                    return true;
            $stmt->bind_param('s', $doctor_id);  // Bind "$username" to parameter.
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            // get variables from result.
            $stmt->bind_result($db_password, $salt);
            $stmt->fetch();
            // hash the password with the unique salt.
            $password = hash('sha1', $password . $salt);
            if ($stmt->num_rows == 1) {
                // If the user exists we check if the account is locked
                // from too many login attempts
                if (checkbrute($doctor_id, $mysqli) == true) {
                    // Account is locked
                    // Send an email to user saying their account is locked
                    return false;
                } else {
                    // Check if the password in the database matches
                    // the password the user submitted.
                    if ($db_password == $password) {
                        // Password is correct!
                        // Get the user-agent string of the user.
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        // XSS protection as we might print this value
                        $doctor_id = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $doctor_id);
                        $_SESSION['doctor_id'] = $doctor_id;
                        // XSS protection as we might print this value
                        $_SESSION['login_string'] = hash('sha1', $password . $user_browser);
                        // Login successful.
                        return true;
                    } else {
                        // Password is not correct
                        // We record this attempt in the database
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$doctor_id', '$now')");
                        return false;
                    }
                }
            } else {
                // No user exists.
                return false;
            }
        }else{
            return false;
        }
    }
    
    //
    function patient_login($patient_id, $password, $mysqli) {
        if($stmt = $mysqli->prepare("SELECT password, salt FROM patient WHERE patient_id = ? LIMIT 1")){
            $stmt->bind_param('s', $patient_id);  // Bind "$username" to parameter.
            $stmt->execute();    // Execute the prepared query.
            $stmt->store_result();
            
            // get variables from result.
            $stmt->bind_result($db_password, $salt);
            $stmt->fetch();
            
            // hash the password with the unique salt.
            $password = hash('sha1', $password . $salt);
            if ($stmt->num_rows == 1) {
                // If the user exists we check if the account is locked
                // from too many login attempts
                if (checkbrute($patient_id, $mysqli) == true) {
                    // Account is locked
                    // Send an email to user saying their account is locked
                    return false;
                } else {
                    // Check if the password in the database matches
                    // the password the user submitted.
                    if ($db_password == $password) {
                        // Password is correct!
                        // Get the user-agent string of the user.
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        // XSS protection as we might print this value
                        $user_id = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $patient_id);
                        $_SESSION['patient_id'] = $patient_id;
                        // XSS protection as we might print this value
                        $_SESSION['login_string'] = hash('sha1', $password . $user_browser);
                        // Login successful.
                        return true;
                    } else {
                        // Password is not correct
                        // We record this attempt in the database
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$doctor_id', '$now')");
                        return false;
                    }
                }
            } else {
                // No user exists.
                return false;
            }
        }else{
            return false;
        }
    }
    //prevent bruteforce
    function checkbrute($user_id, $mysqli) {
        // Get timestamp of current time
        $now = time();
        
        // All login attempts are counted from the past 2 hours.
        $valid_attempts = $now - (2 * 60 * 60);
        
        if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
            $stmt->bind_param('s', $user_id);
            
            // Execute the prepared query.
            $stmt->execute();
            $stmt->store_result();
            
            // If there have been more than 5 failed logins
            if ($stmt->num_rows > 5) {
                return true;
            } else {
                return false;
            }
        }
    }
    //prevent session hijacking
    function doctor_login_check($mysqli) {
        // Check if all session variables are set
        if (isset($_SESSION['doctor_id'],
                  $_SESSION['login_string'])) {
            
            $doctor_id = $_SESSION['doctor_id'];
            $login_string = $_SESSION['login_string'];
            
            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            
            if ($stmt = $mysqli->prepare("SELECT password FROM doctor WHERE doctor_id = ? LIMIT 1")) {
                // Bind "$user_id" to parameter.
                $stmt->bind_param('s', $doctor_id);
                $stmt->execute();   // Execute the prepared query.
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    // If the user exists get variables from result.
                    $stmt->bind_result($password);
                    $stmt->fetch();
                    $login_check = hash('sha1', $password . $user_browser);
                    
                    if ($login_check == $login_string) {
                        // Logged In!!!!
                        return true;
                    } else {
                        // Not logged in
                        return false;
                    }
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    }
    //
    function patient_login_check($mysqli) {
        // Check if all session variables are set
        if (isset($_SESSION['patient_id'],
                  $_SESSION['login_string'])) {
            
            $patient_id = $_SESSION['patient_id'];
            $login_string = $_SESSION['login_string'];
            
            // Get the user-agent string of the user.
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
            
            if ($stmt = $mysqli->prepare("SELECT password FROM patient WHERE patient_id = ? LIMIT 1")) {
                // Bind "$user_id" to parameter.
                $stmt->bind_param('s', $patient_id);
                $stmt->execute();   // Execute the prepared query.
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    // If the user exists get variables from result.
                    $stmt->bind_result($password);
                    $stmt->fetch();
                    $login_check = hash('sha1', $password . $user_browser);
                    
                    if ($login_check == $login_string) {
                        // Logged In!!!!
                        return true;
                    } else {
                        // Not logged in
                        return false;
                    }
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    }
    //sanitize url from php_self
    function esc_url($url) {
        
        if ('' == $url) {
            return $url;
        }
        
        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
        
        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = (string) $url;
        
        $count = 1;
        while ($count) {
            $url = str_replace($strip, '', $url, $count);
        }
        
        $url = str_replace(';//', '://', $url);
        
        $url = htmlentities($url);
        
        $url = str_replace('&amp;', '&#038;', $url);
        $url = str_replace("'", '&#039;', $url);
        
        if ($url[0] !== '/') {
            // We're only interested in relative links from $_SERVER['PHP_SELF']
            return '';
        } else {
            return $url;
        }
    }
    
    ?>