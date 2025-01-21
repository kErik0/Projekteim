<?php
session_start();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagok</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="footer">
        <a href="index.php" class="btn btn-main_page">Csapatok</a>
        <a href="matches_show.php" class="btn btn-matches_page">Mérkőzések</a>
        <a href="members.php" class="btn btn-warning">Új tag felvétele</a>
        <a href="logout.php" class="btn btn-warning">Kijelentkezés</a>
    </div>
    
<div class="behuz">
    <div class="newteam"> 
      <?php
      require_once("newmember_register.php");
      ?>
      
    <table class="center" table-border="1px" style="width:1000px; line-height:40px;"> 
    <tr> 
          <th> Tag neve </th> 
          <th> Születési dátum </th> 
          <th> Állampolgársága </th> 
          <th> Posztja </th>
          <th> Személyiszám</th> 
          <th> Csapatnév </th>  
          
      </tr> 
      <?php 
    include_once('db.php'); 

    $sql = "SELECT Tagok.*, Csapat.csapatnév AS 'Csapatnév'
    FROM Tagok
    JOIN Csapat ON Tagok.Csapatszám = Csapat.Csapatszám
    ORDER BY Tagok.Születésidátum DESC
    LIMIT 5;";
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
      <tr>
      <td><?php echo $rows['Név']; ?></td> 
      <td><?php echo $rows['Születésidátum']; ?></td> 
      <td><?php echo $rows['Állampolgárság']; ?></td> 
      <td><?php echo $rows['Poszt']; ?></td> 
      <td><?php echo $rows['Személyiszám']; ?></td>  
      <td><?php echo $rows['Csapatnév']; ?></td> 
      </td> 
      </td> 
      </tr> 
      <?php
      }
      ?>
    </table> 
    
    </div>
        <br><br>Összes csapattag:<br><br>
    <table class="center" table-border="1px" style="width:1000px; line-height:40px;"> 
    <tr> 
          <th> Tag neve </th> 
          <th> Születési dátum </th> 
          <th> Állampolgársága </th> 
          <th> Posztja </th>
          <th> Személyiszám</th> 
          <th> Csapatszám </th>  
          
      </tr> 
      <?php 
    include_once('db.php'); 

    $sql = "SELECT * FROM tagok WHERE Csapatszám ORDER BY csapatszám ASC;";
    $result= mysqli_query($conn, $sql); 
?> 
<?php while($rows=mysqli_fetch_assoc($result)) 
      { 
      ?> 
      <tr>
      <td><?php echo $rows['Név']; ?></td> 
      <td><?php echo $rows['Születésidátum']; ?></td> 
      <td><?php echo $rows['Állampolgárság']; ?></td> 
      <td><?php echo $rows['Poszt']; ?></td> 
      <td><?php echo $rows['Személyiszám']; ?></td>  
      <td><?php echo $rows['Csapatszám']; ?></td> 
      <td> <a href="edit_member.php" class="btn btn-warning">Módosítás</a></td>  
      <td> 
      <form action="delete_member.php" method="post">
      <input type="text" name="personnumber" value="<?php echo htmlspecialchars($rows['Személyiszám'])?>" hidden>
      <input type="submit" name="delete_personnumber" value="Törlés" class="btn btn-warning">
      </form>
      </td> 
      </td> 
      </tr> 
      <?php
      }
      ?>
    </table> 
    </div> 
</body>
</html>