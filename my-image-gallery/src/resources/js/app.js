// VER DETALLES: https://es.javascript.info/xmlhttprequest#progreso-de-carga

const fileInput = document.querySelector('#file');
const filesContainer = document.querySelector('#files-container');

fileInput.addEventListener('change', e => {
    const files = e.target.files;
    processFiles(files);
});

function processFiles(files) {
    for (const file of files) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(file);

        fileReader.addEventListener('load', e => {
            const url = fileReader.result;
            const sizePrep = file.size / 1024;
            const size = parseInt(sizePrep) > 1000 ? parseFloat(sizePrep / 1024).toFixed(2) + ' MiB' : parseFloat(sizePrep).toFixed(2) + ' KiB'
            const id = 'id-' + crypto.randomUUID();
            // <a href="/img/original/${id}" ></a>
            console.log(id);

            const html = `
                <div class="flex flex-col justify-center w-80 mb-4">
                    <img src="${url}" class="w-60 h-60 object-cover rounded-xl mx-auto" />
                    <div class="flex flex-col mt-4 px-16 gap-1">
                        <div>${file.name}</div>
                        <div>${size}</div>
                        <div id="size-${id}">0%</div>
                        <div class="w-1 h-3 bg-sky-400" id="${id}"></div>
                    </div>
                </div>                   
            `;

            filesContainer.innerHTML += html;

            upload(file, id)
        });
    }
}

function upload(file, id) {
    return new Promise((resolve, reject) => {
        /* De forma nativa la API de Fetch no nos da la capacidad de
        seguir el progreso de la carga. Por lo tanto, usamos la
        la API XMLHttpRequest (AJAX). VER RAZONES:
        https://es.javascript.info/xmlhttprequest */
        const xhr = new XMLHttpRequest();

        // listen for `upload.load` event
        xhr.upload.onload = () => {
            console.log(`The upload is completed: ${xhr.status} ${xhr.response}`);
            resolve();
        }

        // listen for `upload.error` event
        xhr.upload.onerror = () => {
            console.error('Upload failed');
            reject();
        }

        // listen for `upload.abort` event
        xhr.upload.onabort = () => {
            console.error('Upload cancelled');

        }

        // listen for `progress` event
        xhr.upload.onprogress = (e) => {
            const container = document.querySelector('#' + id);
            const sizeDiv = document.querySelector('#size-' + id);

            // event.loaded devuelve cuántos bytes se han descargado
            // evento.total devuelve el número total de bytes
            // event.total solo está disponible si el servidor envía el encabezado (header) `Content-Length`
            console.log(`Uploaded ${e.loaded} of ${e.total} bytes, ${container.id}`);
            // container.style.height = '10px'; // estilos con Tailwindcss
            // container.style.backgroundColor = 'blue';
            container.style.width = ((e.loaded / e.total) * 100) + '%';
            sizeDiv.textContent = ((e.loaded / e.total) * 100).toFixed(0) + '%';
        }

        // open request
        xhr.open('POST', '?view=upload');

        // prepare a file object
        const formData = new FormData();
        formData.append('file', file);

        // send request
        xhr.send(formData);
    });
}