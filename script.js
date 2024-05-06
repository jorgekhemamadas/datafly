document.getElementById('file').addEventListener('change', function(event) {
    var formData = new FormData();
    formData.append('file', this.files[0]);

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('output').innerHTML = `<a href="${data.url}" download>Descargar Archivo</a>`;
    })
    .catch(error => console.error('Error:', error));
});
