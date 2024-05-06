<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataFly</title>
<style>
    /* Estilo para centrar la imagen */
    .centered-image {
        display: block;
        margin: 0 auto; /* Esto centra horizontalmente */
    }
</style>

<?php
// Código PHP para mostrar la imagen centrada
$imagePath = 'anon.jpg';
echo '<img src="' . $imagePath . '" alt="Imagen" class="centered-image">'; 
?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black; /* Fondo negro */
            color: white; /* Texto blanco */
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        #downloadLink, #copyButton {
            display: block;
            margin: 20px auto;
            text-align: center;
            background-color: white; /* Estilo del botón invertido */
            color: black; /* Texto en negro */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Open Sans', sans-serif; /* Tipo de letra cool */
        }
        #copyButton:hover {
            background-color: #333; /* Cambio de color al pasar el cursor */
        }
        input[type="file"] {
            display: none; /* Ocultar el input de tipo file */
        }
        label {
            display: block;
            margin: 20px auto;
            text-align: center;
            background-color: white; /* Estilo del botón invertido */
            color: black; /* Texto en negro */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 150px;
            font-family: 'Open Sans', sans-serif; /* Tipo de letra cool */
        }
        label:hover {
            background-color: #333; /* Cambio de color al pasar el cursor */
        }

        label {
    display: block;
    margin: 20px auto;
    text-align: center;
    background-color: white; /* Estilo del botón invertido */
    color: black; /* Texto en negro */
    border: none;
    padding: 10px 100px; /* Ajusta el padding horizontal para hacer el botón más largo */
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-family: 'Open Sans', sans-serif; /* Tipo de letra cool */
}
    </style>
</head>
<body>
    <form id="uploadForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <h5 style="text-align: center;">Sube tus archivos de forma anónima en DataFly!</h5>
        <h5 style="text-align: center;">Límite de tamaño de archivo 30GB</h5>
        <input type="file" name="files[]" id="fileInput" multiple onchange="submitForm()">
        <!-- Mostrar solo el botón "Subir archivos" -->
        <label for="fileInput">Ｕ Ｐ Ｌ Ｏ Ａ Ｄ</label>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
        $uploadDir = '/var/www/html/archivos/';
        $userPrefix = 'datafly.jorge-';

        // Obtener el nombre del usuario (puedes obtenerlo de tu sistema de autenticación)
        $userName = 'usuario01';

        // Crear el nombre del archivo zip con el prefijo del usuario y un número único
        $zipFileName = $uploadDir . $userPrefix . uniqid() . '.zip';

        // Crear un nuevo archivo zip
        $zip = new ZipArchive();
        if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            echo 'Error al crear el archivo zip.';
            exit;
        }

        // Iterar sobre cada archivo subido y agregarlo al archivo zip
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['files']['name'][$key];
            $filePath = $_FILES['files']['tmp_name'][$key];
            // Agregar el archivo al archivo zip
            if (!$zip->addFile($filePath, $fileName)) {
                echo '<span style="color: red;">Error! selecciona por lo menos ' . $fileName . ' un archivo.</span>';
                $zip->close();
                exit;
            }
        }

        // Cerrar el archivo zip
        $zip->close();

        // Generar el enlace de descarga del archivo zip
        $downloadLink = 'https://vps-50bc0927.vps.ovh.net/archivos/' . urlencode(basename($zipFileName));
        echo '<a id="downloadLink" href="' . $downloadLink . '" download>𝗗𝗲𝘀𝗰𝗮𝗿𝗴𝗮𝗿 𝗮𝗿𝗰𝗵𝗶𝘃𝗼𝘀 𝗰𝗼𝗺𝗽𝗿𝗶𝗺𝗶𝗱𝗼𝘀</a>';
        echo '<button id="copyButton" onclick="copyToClipboard(\'' . $downloadLink . '\')">𝘾𝙤𝙥𝙞𝙖𝙧 𝙚𝙣𝙡𝙖𝙘𝙚 𝙙𝙚 𝙙𝙚𝙨𝙘𝙖𝙧𝙜𝙖</button>';
        echo '<br>';
    } else {
        echo '';
    }
    ?>

    <script>
        function submitForm() {
            document.getElementById("uploadForm").submit();
        }

        function copyToClipboard(text) {
            var textarea = document.createElement("textarea");
            textarea.textContent = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert("Enlace copiado al portapapeles: " + text);
        }
    </script>
</body>
</html>
