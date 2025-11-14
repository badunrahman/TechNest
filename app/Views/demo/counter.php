<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>
    <h1>Visit Counter</h1>
    <p>You have visited this page <strong><?= $counter ?></strong> times.</p>

    <form method="POST" action="reset">
        <button type="submit">Reset Counter</button>
    </form>
</body>
</html>
