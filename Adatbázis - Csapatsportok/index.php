
<?php
session_start();
if (isset($_GET["logout"]) && $_GET["logout"] == "success") {
    echo "<div class='alert alert-success'>Sikeresen kijelentkeztél!</div>";
}
?>


<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="footer">
        <a href="index.php" class="btn btn-main_page">Csapatok</a>
        <a href="matches_show.php" class="btn btn-matches_page">Mérkőzések</a>
        <a href="teams.php" class="btn btn-warning">Új csapat felvétele</a>
        <a href="member_show.php" class="btn btn-warning">Tagok</a>
        <a href="logout.php" class="btn btn-warning">Kijelentkezés</a>
    </div>
    
<div class="behuz">
    <div class="newteam"> 
      <?php
      require_once("newteam.php");
      ?>
      <?php
    if (isset($_GET["login"]) && $_GET["login"] == "success") {
        echo "<div class='alert alert-success'>Sikeres bejelentkezés!</div>";
    }
    ?>
      
    <table class="center" table-border="1px" style="width:1000px; line-height:40px;"> 
    <tr> 
          <th> Csapat név </th> 
          <th> Város </th> 
          <th> Alapítás éve </th> 
          <th> Csapatszám </th>  
          
      </tr> 
      <?php 
    include_once('db.php'); 
    $sql="SELECT * FROM csapat"; 
    $result= mysqli_query($conn, $sql); 
?> 
<?php 
                    if(isset($_SESSION['status']))
                    {
                        ?>
                            <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['status']; ?>
                            </div>
                        <?php
                         unset($_SESSION['status']);
                    }
                ?>
      <?php while($rows=mysqli_fetch_assoc($result)) 
      { 
      ?> 
      <tr> <td><?php echo $rows['csapatnév']; ?></td> 
      <td><?php echo $rows['Város']; ?></td> 
      <td><?php echo $rows['Év']; ?></td> 
      <td><?php echo $rows['Csapatszám']; ?></td> 
      <td> <a href="edit_team.php" class="btn btn-warning">Módosítás</a></td>  
      <td>
      <form action="delete_teams.php" method="post">
    <input type="text" name="teamid" value="<?php echo htmlspecialchars($rows['Csapatszám'])?>" hidden>
    <input type="submit" name="delete_id" value="Törlés" class="btn btn-warning">
      </form>
      </td> 
      </tr> 
      <?php
      }
      ?>
    </table> 
    </div>

        <br><br>Legrégebben alapított csapat tagjai:<br><br>
    <table class="center" table-border="1px" style="width:1000px; line-height:40px;"> 
    <tr> 
          <th> Csapat név </th> 
          <th> Alapítás éve </th> 
          <th> Csapattagok </th>  
          
      </tr> 
      <?php
      include_once('db.php');
      $sql="SELECT Csapat.Csapatnév, Csapat.Év , Tagok.Név FROM Csapat JOIN Tagok ON Csapat.Csapatszám = Tagok.Csapatszám WHERE Csapat.Év = (SELECT MIN(Év) FROM Csapat) ORDER BY Tagok.Név ASC;"; 
      $result= mysqli_query($conn, $sql); 
      while($rows=mysqli_fetch_assoc($result)) {
       
      ?> 
      <tr> <td><?php echo $rows['Csapatnév']; ?></td> 
      <td><?php echo $rows['Év']; ?></td> 
      <td><?php echo $rows['Név']; ?></td> 
      </tr>
    <?php
      }
      ?>
        </div>

  
</body>
</html>