<!DOCTYPE html>

<?php include("style.php") ?>
    
  <div id="Home">
    <h1 style = "text-align:center;" > Welcome to the Wine Cellar.</h1>  

    <p style = "margin-left: 120px;"> This website was created to manage a home wine cellar through Home Assistant.  The philosopy was to keep the management of the data in a simple Sqlite database.  I display the data by columns in the cellar.  I number the cellar starting on the left and going clockwise around the room.  I number rows starting at the top and ending at the bottom. </p> 

    <p style = "margin-left: 120px;">The current database is setup with 31 columns and 23 rows.  This allows me to manage a total of 713 unique bottle of wine.  I use the maximum number of rows from all columns for each column.  N/A is used to indicate a spot that does not exist. This is all "hardcoded" in the system.</p>
    
    <p style = "margin-left: 120px;">In the wine reviews, the source is listed after the review in parenthesis and the rate is after the name.  WMN means wine makers notes, WE means Wine Enthusiast, W&S means Wine and Spirts, RP means Robert Parker, WS means Wine Spectator and WW means Wilford Wong of Wine.com</p>
  <div> 

</section>

<footer>
  <p style = "color:red;">Home</p>
</footer>


</body>
</html>

