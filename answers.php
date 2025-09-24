<!DOCTYPE html>
<head>Form response</head>
<html>
    <body>
        <p>who got you on the game: <?= htmlspecialchars($_POST['who'])?> </p>
        <p>Favorite boss: <?= htmlspecialchars($_POST['favboss'])?> </p>
        <p>worst boss: <?= htmlspecialchars($_POST['worstboss'])?> </p>
        <p>Hours on the game: <?= htmlspecialchars($_POST['hours'])?> </p>
        <p>How hyped you are: <?= htmlspecialchars($_POST['hypelevel'])?> </p>
    </body>
</html>