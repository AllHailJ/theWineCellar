<html lang="en">
<head>
<title>Wine Cellar</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}
/*
 Make Atkinson Hyperlegible the default font.  This is downloadable and free to use.
*/

body {
  font-family: Atkinson Hyperlegible, Arial, Helvetica, sans-serif;
}

header {
  background-color: #420;
  padding: 5px;
  text-align: center;
  font-size: 38px;
  color: white;
}

/*  Create two floating columns next to each other. */
nav {
  float: left;
  padding: 5px;
  width: 5%;
  background: #ccc;
}

/* Style menu list */
nav ul {
  padding: 0;
  list-style-type: none;
}

article {
  float: left;
  padding: 5px;
  width: 90%;
  background-color: #f1f1f1;
}

/* 
Clear floats after dual columns 
*/
section::after {
  content: "";
  display: table;
  clear: both;
}

footer {
  background-color: #eed202;
  padding: 5px;
  text-align: center;
  color: white;
}

/* 
Make the dual columns stack instead of side by side, on small screens 
*/
@media (max-width: 600px) {
  nav, article {
    width: 100%;
    height: auto;
  }
}
</style>
</head>

<body>

<header>
  <h1>the Wine Cellar</h1>
</header>

<section>
  <nav>
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="cellaradd.php">Add</a></li>
      <li><a href="cellardrink.php">Drink</a></li>
      <li><a href="cellar.php">List</a></li>
      <li><a href="cellarreview.php">Review</a></li>
      <li><a href="about.php">About</a></li>
    </ul>
  </nav>
  
