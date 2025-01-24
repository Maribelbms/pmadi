document.getElementById('verification-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const spinner = document.getElementById('loading-spinner');
    const resultDiv = document.getElementById('verification-result');
    const ci = document.getElementById('ci').value;

    spinner.style.display = 'inline-block'; // Mostrar spinner

    fetch('/verificar-datos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ ci })
    })
        .then(response => response.json())
        .then(data => {
            spinner.style.display = 'none'; // Ocultar spinner
            resultDiv.style.display = 'block';

            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        <strong>Datos encontrados:</strong>
                        <p>Tutor: ${data.tutor.primer_nombre_tutor} ${data.tutor.primer_apellido_tutor}</p>
                        <p>Estudiantes: ${data.tutor.estudiantes.map(est => est.primer_nombre).join(', ')}</p>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="alert alert-danger">
                        ${data.message}
                    </div>
                `;
            }
        })
        .catch(error => {
            spinner.style.display = 'none'; // Ocultar spinner
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = `
                <div class="alert alert-danger">
                    Ocurrió un error. Por favor, inténtalo de nuevo.
                </div>
            `;
        });
});
