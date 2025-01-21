<?php
session_start();
require_once('db.php');
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
        <a href="logout.php" class="btn btn-warning">Kijelentkezés</a>
        
    </div>
    
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
    <div class="newteam">

        <form action="newmember_register.php" method="post">

            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="Tag neve">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="nationality" placeholder="Állampolgársága">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="position" placeholder="Pozíciója">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="personnumber" placeholder="Személyi száma">
            </div>
            <div class="form-group">
                <input type="date" class="form-control" name="birthday" placeholder="Születésnapja">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="team_id" placeholder="Csapatszáma">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-warning" value="Felvétel" name="submit">
            </div>
        </form>
                </div>
</body>
</html>