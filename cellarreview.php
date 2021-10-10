<!DOCTYPE html>

<?php include("style.php") ?>

  <?php
      
      $dbname = "/var/www/html/winecellar/WineCellar.db";
      $query  = "SELECT COUNT(*) FROM CellarContents WHERE Winery NOT LIKE 'Empty' AND Winery NOT LIKE 'N/A'";
      
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
#   Get The Bottles of Wine
# -------------------------------------------------------------------------------      

      $stmt = $db->prepare($query);
     
      $stmt->execute(); 
            
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);
      
      foreach ($wines as $row) {
        $count = $row[0];
      }
      
# -------------------------------------------------------------------------------
#   Get White Wine
# -------------------------------------------------------------------------------      

      $query = "SELECT count(DISTINCT(Varietal)) FROM CellarContents WHERE Varietal LIKE 'Rose' OR Varietal LIKE 'Chardonnay' OR Varietal LIKE 'White Zinfandel' OR Varietal LIKE 'Grenache Gris' OR Varietal LIKE 'Champagne' OR Varietal LIKE 'Riesling' OR Varietal LIKE 'Gewurztraminer' OR Varietal LIKE 'Sauvignon Blanc' OR Varietal LIKE 'Semillon' OR Varietal LIKE 'Pinot Grigio' OR Varietal LIKE 'Chablis' OR Varietal LIKE 'Chenin Blanc'";
     
      $stmt = $db->prepare($query);
     
      $stmt->execute(); 
            
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);
      
      foreach ($wines as $row) {
        $white = $row[0];
      }
 
      $red = $count - $white;
      
# -------------------------------------------------------------------------------
#   Get The Countries
# -------------------------------------------------------------------------------      
      
      $query = "SELECT count(DISTINCT(Country)) FROM CellarContents WHERE Winery NOT LIKE 'Empty' AND Winery NOT LIKE 'N/A'";      
 
      $stmt = $db->prepare($query);
     
      $stmt->execute(); 
            
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);
      
      foreach ($wines as $row) {
        $country = $row[0];
      }
      
      echo "<table border=1 style='width:20%;'>";
      
        echo "<tr>";
          echo "<td>Bottles</td>";
          echo "<td>Red</td>";            
          echo "<td>White</td>";            
          echo "<td>Country</td>";            
        echo "</tr>";

        echo "<tr >";
          for ($i=1; $i<=4; $i++) {
            if ($i = 1) {echo "<td> $count </td>";}
            if ($i = 2) {echo "<td> $red </td>";}
            if ($i = 3) {echo "<td> $white </td>";}
            if ($i = 4) {echo "<td> $country </td>";}
          }
        echo "</tr>";

      echo"</table>";    

# -------------------------------------------------------------------------------
#   Get the wines by country
# -------------------------------------------------------------------------------      
#
      $query = "SELECT Country,count(*) FROM CellarContents WHERE Winery NOT LIKE 'Empty' AND Winery NOT LIKE 'N/A' GROUP BY Country";

      $stmt = $db->prepare($query);

      $stmt->execute();
      
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);
 
      echo "<table border=1 style='width:12%;'>";
      
        echo "<tr>";
          echo "<td>Country</td>";
          echo "<td>Count</td>";            
        echo "</tr>";

        foreach ($wines as $row) {
          echo "<tr >";
            for ($i=0; $i<=1; $i++) {
              echo "<td> $row[$i] </td>";
            }
          echo "</tr>";
        }

      echo"</table>";      

      $db = null; //close the database

  ?>

</section>

<footer>
  <p style = "text-align:center; color:red;">Review Cellar</p>
</footer>

</body>
</html>  

