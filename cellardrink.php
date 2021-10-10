<!DOCTYPE html>

<?php include("style.php") ?>

  <form target="_self">
    <label for="icol">Column. </label>
    <label for="irow">Row</label><br>
    <input type="number" size="2" maxlength="2" min="1" max= "31" value="1" name="icol" required>
    <input type="number" size="2" maxlength="2" min="1" max= "23" value="1" name="irow" required>
    <input type="submit" name="display" id="display" value="display"><br>
  </form>
 
   <br>
   <form target="_self">
    <input type="number" size="2" maxlength="2" min="1" max= "31" value="1" name="icol" required>
    <input type="number" size="2" maxlength="2" min="1" max= "23" value="1" name="irow" required>
    <input type="text" size="10" maxlength="10" value="12/22/2020" name="jdate" required>
    <input type="submit" name="drink" id="drink" value="drink">
  </form>
 
 
  <?php
      $drinkpressed = 0;
      $displaypressed = 0;
      
      if ($_GET["icol"]) {
        $selectcol = $_GET["icol"];
        $selectrow = $_GET["irow"];
        if ($_GET["drink"]) { $drinkpressed = 1;}
        if ($_GET["display"]) { $displaypressed = 1;}
      } else {
        $selectcol = 1;
        $selectrow = 1;
        $displaypressed = 1;
      }

      $in_date1 = $_GET["jdate"];
# -------------------------------------------------------------------------------
#   Get the sequential ID
# -------------------------------------------------------------------------------      
      
      $startid = ($selectcol - 1) * 23 + $selectrow;
      $endid = ($selectcol - 1) * 23 + $selectrow;
      
      $dbname = "/var/www/html/winecellar/WineCellar.db";
      $getcolquery  = "SELECT * FROM CellarContents WHERE ID >= ? AND ID <= ?";
      
# -------------------------------------------------------------------------------
#   Open the Database from string set above
# -------------------------------------------------------------------------------      

      $db = new PDO('sqlite:' . $dbname);
     
      if (!$db) {
        echo "Failed to Open $dbname";
        die();
      }

      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
      
# -------------------------------------------------------------------------------
#   execute the query and get the data.
# -------------------------------------------------------------------------------      

      $stmt = $db->prepare($getcolquery);
     
      $stmt->execute(array($startid,$endid)); 
            
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);

      $drinkwines = 0;

# ---------------------------------------------------------------------------------
#  This starts the display table
# ---------------------------------------------------------------------------------
      echo "<table border=1 style='width:100%;'>";
      
      echo "<tr>";
        echo "<td color=red>ID</td>";
        echo "<td>Col</td>";
        echo "<td>Row</td>";
        echo "<td>Date</td>";
        echo "<td>Winery</td>";
        echo "<td>WineName</td>";
        echo "<td>Varietal</td>";
        echo "<td>Year</td>";
        echo "<td>Country</td>";
        echo "<td>Region</td>";
        echo "<td>Review</td>";
      echo "</tr>";

      foreach ($wines as $row) {
        echo "<tr >";
          for ($i=0; $i<=10; $i++) {
            echo "<td> $row[$i] </td>";
            if ($i == 3) {$in_date = $row[3];}
            if ($i == 4) {$in_winery = $row[4];}
            if ($i == 5) {$in_winename = $row[5];}
            if ($i == 6) {$in_varietal = $row[6];}
            if ($i == 7) {$in_year = $row[7];}
            if ($i == 8) {$in_country = $row[8];}
            if ($i == 9) {$in_region = $row[9];}
            if ($i == 10) {$in_review = $row[10];}
            if (($row[4] !== "Empty") && ($row[4] !== "N/A")) { $drinkwines = 1; }
          }
        echo "</tr>";
      }

       echo"</table>";
# ---------------------------------------------------------------------------------
#  This ends the display table
# ---------------------------------------------------------------------------------

# ---------------------------------------------------------------------------------
#   if $drinkwines is true and $drinkpressed we write to the database
# ---------------------------------------------------------------------------------      

        if ($drinkwines && $drinkpressed) {

#---------------------------------------------------------------------------------
#    No need to update the ID, col or row.  We have found by id and inserting by id.
#---------------------------------------------------------------------------------
          $upquery = "UPDATE CellarContents SET Date='.', Winery='Empty', WineName='.', Varietal='.', Year='0', Country='.', Region='.', Review='.' WHERE ID = $startid";

#  stmt means STatement Handle
            
          $stmt1 = $db->prepare($upquery);
    
#---------------------------------------------------------------------------------
#    Now we execute the update statement and commit it.
#---------------------------------------------------------------------------------
          $stmt1->execute();
#          $stmt1->commit();

          $drinkquery = "INSERT INTO WineConsumed (cColumn, cRow, ldDate, cWinery, cWineName, cVarietal, cYear, cCountry, cRegion, cReview, cDate) VALUES('$selectcol', '$selectrow', '$in_date', '$in_winery', '$in_winename', '$in_varietal', '$in_year', '$in_country', '$in_region', '$in_review', '$in_date1')";


          $stmt2 = $db->prepare($drinkquery);

#---------------------------------------------------------------------------------
#    Now we execute the drink query insert statement and commit it.
#---------------------------------------------------------------------------------
         $stmt2->execute();
#         $stmt2->commit();             

       }
        
       $db = null; //close the database

  ?>

</section>

<footer>
  <p style = "text-align:center; color:red;">Remove Bottles from the Wine Cellar</p>
</footer>

</body>
</html>  

