<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Student Arrivals - Login</title>

    <link rel="stylesheet" href="./src/assets/styles/styles.css">
</head>
<body>
    <span class="title">Student Arrivals - Login</span>

    <hr class="border">

    <form action="./src/plugins/profile.php" method="post">
        Name
        <hr class="small">
        <input type="text" name="name" autocomplete="off">
        <input type="hidden" name="action" value="null">
        <input class="submit" type="submit" value="Submit">
    </form>
</body>
</html>