<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
</head>
<body>

<h1>Book Details</h1>

<p><strong>Title:</strong> <?= esc($book['title']) ?></p>
<p><strong>Author:</strong> <?= esc($book['author']) ?></p>
<p><strong>Available:</strong> <?= $book['available'] == 1 ? 'Available' : 'Not Available' ?></p>

<a href="<?= site_url('books') ?>">Back to List</a>

</body>
</html>
