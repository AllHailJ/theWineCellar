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

      $query = "SELECT count(Varietal) FROM CellarContents WHERE RedWhite LIKE 'White'";
     
      $stmt = $db->prepare($query);
     
      $stmt->execute(); 
            
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);
      
      foreach ($wines as $row) {
        $white = $row[0];
      }
 
      $red = $count - $white;

# -------------------------------------------------------------------------------
#   Get Varietal
# -------------------------------------------------------------------------------      

      $query = "SELECT count(DISTINCT(Varietal)) FROM CellarContents WHERE Winery NOT LIKE 'Empty' AND Winery NOT LIKE 'N/A'";
     
      $stmt = $db->prepare($query);
     
      $stmt->execute(); 
            
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);
      
      foreach ($wines as $row) {
        $varietal = $row[0];
      }      

# -------------------------------------------------------------------------------
#   Get Winecellar Value
# -------------------------------------------------------------------------------      

      $query = "SELECT sum(Price) FROM CellarContents";
     
      $stmt = $db->prepare($query);
     
      $stmt->execute(); 
            
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);
      
      foreach ($wines as $row) {
        $value = $row[0];
      }      

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
      
      echo "<table border=1 style='width:25%;'>";
      
        echo "<tr>";
          echo "<td>Bottles</td>";
          echo "<td>Red</td>";            
          echo "<td>White</td>";
          echo "<td>Varietal</td>";            
          echo "<td>Country</td>";
          echo "<td>CellarValue</td>";            
        echo "</tr>";

        echo "<tr >";
          for ($i=1; $i<=6; $i++) {
            if ($i = 1) {echo "<td> $count </td>";}
            if ($i = 2) {echo "<td> $red </td>";}
            if ($i = 3) {echo "<td> $white </td>";}
            if ($i = 4) {echo "<td> $varietal </td>";}
            if ($i = 5) {echo "<td> $country </td>";}
            if ($i = 6) {echo "<td> $ $value </td>";}
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
 
      echo "<table border=1 style='width:60%;'>";
      
        echo "<tr>";
        echo "<td>Country</td>";
        foreach ($wines as $row) {
          echo "<td> $row[0] </td>";
        }
        echo "</tr>";
                 
        echo "<tr>";
        echo "<td>Count</td>";
        foreach ($wines as $row) {
          echo "<td> $row[1] </td>";
        }
        echo "</tr>";

      echo"</table>";      


# -------------------------------------------------------------------------------
#   Get wines by Varietal
# -------------------------------------------------------------------------------      
#
      $query = "SELECT Varietal,count(*) FROM CellarContents WHERE Winery NOT LIKE 'Empty' AND Winery NOT LIKE 'N/A' GROUP BY Varietal";

      $stmt = $db->prepare($query);

      $stmt->execute();
      
      $wines = $stmt->fetchAll(PDO::FETCH_NUM);
 
      echo "<table border=1 style='width:50%;'>";

        echo "<tr>";
        echo "<td>Varietal</td>";
        foreach ($wines as $row) {
          echo "<td> $row[0] </td>";
        }
        echo "</tr>";
                 
        echo "<tr>";
        echo "<td>Count</td>";
        foreach ($wines as $row) {
          echo "<td> $row[1] </td>";
        }
        echo "</tr>";
      
      echo"</table>"; 
      
      $db = null; //close the database

  ?>

</section>

<footer>
  <p style = "text-align:center; color:red;">Review Cellar</p>
</footer>

</body>
</html>  

