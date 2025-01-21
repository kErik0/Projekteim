

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mérkőzések</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="footer">
        <a href="index.php" class="btn btn-main_page">Csapatok</a>
        <a href="matches_show.php" class="btn btn-matches_page">Mérkőzések</a>
        <a href="matches.php" class="btn btn-warning">Új meccs felvétele</a>
        <a href="logout.php" class="btn btn-warning">Kijelentkezés</a>
    </div>
    
<div class="behuz">
    <div class="newteam"> 
      <?php
      require_once("newmatches_register.php");
      ?>
      
    <table class="center" table-border="1px" style="width:1000px; line-height:40px;"> 
    <tr> 
          <th> Eredmény </th> 
          <th> Dátum </th> 
          <th> Helyszín </th> 
          <th> Itthoni csapat neve</th> 
          <th> Vendég csapat neve</th>  
          <th> Mérkőzésszám </th>  
          
      </tr> 
      <?php 
    include_once('db.php'); 
    $sql="SELECT * FROM mérkőzések WHERE Dátum BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 WEEK);";
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
      <tr> <td><?php echo $rows['Eredmény']; ?></td> 
      <td><?php echo $rows['Dátum']; ?></td> 
      <td><?php echo $rows['Helyszín']; ?></td> 
      <td><?php echo $rows['Csapat_1_id']; ?></td>
      <td><?php echo $rows['Csapat_2_id']; ?></td>
      <td><?php echo $rows['Mérkőzésszám']; ?></td> 
      <td> <a href="edit_matches.php" class="btn btn-warning">Módosítás</a></td>  
      <td>
      <form action="delete_matches.php" method="post">
        <input type="text" name="match" value="<?php echo htmlspecialchars($rows['Mérkőzésszám'])?>" hidden>
        <input type="submit" name="match_id" value="Törlés" class="btn btn-warning">
      </form>
      </td> 
      </tr> 
      <?php
      }
      ?>
    </table> 
    </div>
    </div>
  </div>

  
</body>
</html>