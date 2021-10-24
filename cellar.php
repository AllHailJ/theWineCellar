<!DOCTYPE html>

<?php include("style.php") ?>

  <form target="_self">
    Col:<input type="number" size="2" maxlength="2" min="1" max= "31" name="icol">
<!--    Row:<input type="number" size="2" maxlength="2" min="1" max= "23" name="irow"> -->
    <input type="submit" name="submit" id="submit" value="submit">
  </form>
 
  <?php
      
      if ($_GET["icol"]) {
        $selectcol = $_GET["icol"];
      } else {
        $selectcol = 1;
      }

      $startid = ($selectcol - 1) * 23 + 1;
      $endid = $selectcol * 23;
      
      
      for ($i = 0; $i < 3; $i++) {
        echo "<br />";
      }
 
      $dbname = "/var/www/html/winecellar/WineCellar.db";
      $myquery  = "SELECT * FROM CellarContents WHERE ID >= ? AND ID <= ?";
     
      $db = new PDO('sqlite:' . $dbname);
      
      if (!$db) {
        echo "Failed to Open $myname";
        die();
      }

      $stmt = $db->prepare($myquery);
     
      $stmt->execute(array($startid,$endid)); 
            
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);

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
        echo "<td>Red-White</td>";
        echo "<td>Price</td>";
      echo "</tr>";

      foreach ($wines as $row) {
        echo "<tr >";
          for ($i=0; $i<=12; $i++) {
            if ($i == 6) { 
              $row[6] = str_replace("z t", "zt", $row[6]);
              $row[6] = str_replace("d o", "do", $row[6]);
              $row[6] = str_replace("u v", "uv", $row[6]);
              $row[6] = str_replace("i t", "it", $row[6]);
              $row[6] = str_replace("m p", "mp", $row[6]);
              $row[6] = str_replace("n f", "nf", $row[6]);
              $row[6] = str_replace("p r", "pr", $row[6]);
              $row[6] = str_replace("i o", "io", $row[6]);
            }
            echo "<td> $row[$i] </td>";
          }
        echo "</tr>";
      }

       echo"</table>";
# ---------------------------------------------------------------------------------
#  This ends the display table
# ---------------------------------------------------------------------------------

        $db = null; //close the database
      
  ?>

</section>

<footer>
  <p style = "text-align:center; color:red;">Managing Your Wine Cellar in Home Assistant</p>
</footer>

</body>
</html>  

