<!--Name: formSummary.php from Project 1
	Author: Michelle Estanol
	Purpose: Displays the user-submitted data in a table format.
-->
<?php
function displaySummary(){
 
?>
    <form name="surveyOne" method="POST">
        <h1>Multi-page Survey Application</h1>
        <h2>Response Summary</h2>

    <!-- populate using session data -->
        <table id="tblSummary">
            <tr>
                <th>Page</th>
                <th>Field</th>
                <th>Your Response</th>
            </tr>
            <?php
                echo "<tr><td>" .  1  . "</td>";
                echo "<td>" . "Full Name" . "</td>";
                echo "<td>" . $_SESSION['fullName'] . "</td>";
                echo "</tr>";

                echo "<tr><td>" .  1  . "</td>";
                echo "<td>" . "Age" . "</td>";
                echo "<td>" . $_SESSION['age'] . "</td>";
                echo "</tr>";

                echo "<tr><td>" .  2  . "</td>";
                echo "<td>" . "How did you complete your purchase?" . "</td>";
                echo "<td>" . $_SESSION['howPurchased'] . "</td>";
                echo "</tr>";

                echo "<tr><td>" .  2  . "</td>";
                echo "<td>" . "Which of the following did you purchase?" . "</td>";
                echo "<td>";

                //display name of each product
                foreach($_SESSION['purchases[]'] as $key => $value){
                    echo $value . "<br>";
                } 

                echo "</td>";
                echo "</tr>";

                //display satisfaction ratings and recommendations for each product
                for($y = 1; $y <= count($_SESSION['purchases[]']); ++$y){
                    echo "<tr><td>" .  3  . "</td>";
                    echo "<td>" . "How happy are you with this device on a scale from 1 (not satisfied) to 5 (very satisfied)?" . "</td>";
                    echo "<td>" . $_SESSION['satisfaction'.$y] . "</td>";
                    echo "</tr>";

                    echo "<tr><td>" .  3  . "</td>";
                    echo "<td>" . "Would you recommend the purchase of this device to a friend?" . "</td>";
                    echo "<td>" . $_SESSION['recommend'.$y] . "</td>";
                    echo "</tr>";
                }
            ?>

        </table>
        <footer>
            <div id="divButtons">
                <input type="submit" value="Previous" name="btnPrevious" id="btnPrevious">
                <input type="submit" value="Save" name="btnSave" id="btnSave">  
            </div>
        </footer>
    </form>
<?php
    }
?>