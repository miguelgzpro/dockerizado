<?php
// public/index.php

// Listado de URLs de imágenes
$images = [
    'https://pandorafms.com/blog/wp-content/uploads/2020/02/docker.webp',
            'https://okitup.com/wp-content/uploads/2024/03/04b8b7c5-c62c-4bd3-b745-21df929fb950.jpeg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7j0jbPlYutPt1f25fVGmWkb9IsjOW5EBLLw&s'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar análisis de imágenes
    $apiKey = 'acc_9e68e62dd7033d7';
    $apiSecret = '70705b2df8999b1706cfd94c8624f1b8';
    $endpoint = 'https://api.imagga.com/v2/tags';

    $results = [];

    foreach ($images as $imageUrl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic " . base64_encode("$apiKey:$apiSecret")
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'image_url' => $imageUrl
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $data = json_decode($response, true);
            $tags = $data['result']['tags'] ?? [];
            usort($tags, function ($a, $b) {
                return $b['confidence'] <=> $a['confidence'];
            });
            $results[$imageUrl] = array_slice($tags, 0, 2); // Solo los dos tags con mayor confianza
        } else {
            $results[$imageUrl] = [];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Analysis</title>
</head>
<body>
    <h1>Image Analysis with Imagga</h1>
    <form method="post">
        <button type="submit">Analizar Imágenes</button>
    </form>

    <?php if (!empty($results)): ?>
        <h2>Resultados del Análisis</h2>
        <?php foreach ($results as $imageUrl => $tags): ?>
            <div>
                <h3>Imagen: <a href="<?= htmlspecialchars($imageUrl) ?>" target="_blank"><?= htmlspecialchars($imageUrl) ?></a></h3>
                <img src="<?= htmlspecialchars($imageUrl) ?>" alt="Image" style="max-width: 200px;">
                <ul>
                    <?php foreach ($tags as $tag): ?>
                        <li><?= htmlspecialchars($tag['tag']) ?> (<?= htmlspecialchars($tag['confidence']) ?>%)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
