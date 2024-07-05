<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Analysis</title>
</head>
<body>
    <h1>Image Analysis</h1>
    <form method="post">
        <?php foreach ($images as $image): ?>
            <div>
                <img src="<?php echo $image; ?>" alt="Image" width="200"><br>
                <?php if (isset($results[$image])): ?>
                    <p>Tags:</p>
                    <ul>
                        <?php foreach ($results[$image]['result']['tags'] as $tag): ?>
                            <li><?php echo $tag['tag']['en']; ?> (<?php echo $tag['confidence']; ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" name="analyze">Analyze</button>
    </form>
</body>
</html>
