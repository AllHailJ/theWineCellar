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
<!--    <label for="icol">Col</label>
    <label for="irow">Row</label>
    <label for="jdate">Date</label>
    <label for="jwinery">Winery</label>
    <label for="jwinename">Wine Name</label>
    <label for="jvarietal">Varietal</label>
    <label for="jyear">Year</label>
    <label for="jcountry">Country</label>
    <label for="jregion">Region</label>
    <label for="jreview">Review</label> <br>
    <label for="jredwhite">RedWhite</label> <br>
    <label for="jprice">Price</label> <br> -->        
    <input type="number" size="2" maxlength="2" min="1" max= "31" value="1" name="icol" required>
    <input type="number" size="2" maxlength="2" min="1" max= "23" value="1" name="irow" required>
    <input type="text" size="10" maxlength="10" value="1/1/1990" name="jdate" required>
    <input type="text" size="10" maxlength="30" value="Winery" name ="jwinery" required>
    <input type="text" size="10" maxlength="30" value="Wine Name" name="jwinename" required>
    <input type="text" size="15" maxlength="30" value="Varietal" name="jvarietal" required>
    <input type="text" size="4" maxlength="4" value="1980" name="jyear" required>
    <input type="text" size="10" maxlength="20" value="Country" name="jcountry" required>
    <input type="text" size="15" maxlength="30"  value="Region" name="jregion" required>
    <input type="text" size="30" maxlength="2048" value="Review"name="jreview" required>
    <input type="text" size="6" maxlength="6" value="RedWhite"name="jredwhite" required>
    <input type="text" size="6" maxlength="6" value="Price"name="jprice" required>
    <input type="submit" name="add" id="add" value="add">
  </form>
 
 
  <?php
      $addpressed = 0;
      $displaypressed = 0;
      
      if ($_GET["icol"]) {
        $selectcol = $_GET["icol"];
        $selectrow = $_GET["irow"];
        if ($_GET["add"]) { $addpressed = 1;}
        if ($_GET["display"]) { $displaypressed = 1;}
      } else {
        $selectcol = 1;
        $selectrow = 1;
        $displaypressed = 1;
      }
# -------------------------------------------------------------------------------
#   User pressed add - get the input so it can be written to the database.
# -------------------------------------------------------------------------------      
      if ( $addpressed ) {
        $in_date     = $_GET["jdate"];
        $in_winery   = $_GET["jwinery"];
        $in_winename = $_GET["jwinename"];
        $in_varietal = $_GET["jvarietal"];
        $in_year     = $_GET["jyear"];
        $in_country  = $_GET["jcountry"];
        $in_region   = $_GET["jregion"];
        $in_review   = $_GET["jreview"];
        $in_redwhite = $_GET["jredwhite"];
        $in_price    = $_GET["jprice"];
      }

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

      $addwines = 0;

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
        echo "<td>RedWhite</td>";
        echo "<td>Price</td>";
      echo "</tr>";

      foreach ($wines as $row) {
        echo "<tr >";
          for ($i=0; $i<=12; $i++) {
            echo "<td> $row[$i] </td>";
            if ($i == 4) { $junk = $row[4]; }
            if ($row[4] == "Empty") { $addwines = 1; }
          }
        echo "</tr>";
      }

       echo"</table>";
# ---------------------------------------------------------------------------------
#  This ends the display table
# ---------------------------------------------------------------------------------
        
# ---------------------------------------------------------------------------------
#   if $addwines is true and $addpressed we write to the database
# ---------------------------------------------------------------------------------      

        if ($addwines && $addpressed) {

 #---------------------------------------------------------------------------------
 #    No need to update the ID, col or row.  We have found by id and inserting by id.
 #---------------------------------------------------------------------------------
          $upquery = "UPDATE CellarContents SET Date='$in_date', Winery='$in_winery', WineName='$in_winename', Varietal='$in_varietal', Year='$in_year', Country='$in_country', Region='$in_region', Review='$in_review', RedWhite='$in_redwhite', Price='$in_price' WHERE ID = $startid";

#  stmt means STatement Handle
            
         $stmt1 = $db->prepare($upquery);
    
#---------------------------------------------------------------------------------
#    Now we execute the input statement and commit it.
#---------------------------------------------------------------------------------
        $stmt1->execute();
        $stmt1->commit();
              
       } 
        
 
       $db = null; //close the database

  ?>

</section>

<footer>
  <p style = "text-align:center; color:red;">Add Bottles to the Wine Cellar</p>
</footer>

</body>
</html>  

