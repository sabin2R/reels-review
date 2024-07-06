<?php
            // Database connection
            $conn = new mysqli("localhost", "root", "", "reelreview");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }