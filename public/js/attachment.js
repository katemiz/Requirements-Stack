

function removeFile(prefix,id) {

    if (filesToDelete[prefix].includes(id)) {
        filesToDelete[prefix].splice(filesToDelete[prefix].indexOf(id),1)
    } else {
        filesToDelete[prefix].push(id)
    }

    document.getElementById('filesToDelete').value = JSON.stringify(filesToDelete)

    Array.from(document.getElementById(prefix+id).children).forEach(element => {

        if (element.dataset.name !== undefined && element.dataset.name === 'buttons') {

            Array.from(element.children).forEach(el => {

                if (Array.from(el.classList).includes('is-hidden')) {
                    el.classList.remove('is-hidden')
                } else {
                    el.classList.add('is-hidden')
                }
            })
        } else {

            if (Array.from(element.classList).includes('iptal')) {
                element.classList.remove('iptal')
            } else {
                element.classList.add('iptal')
            }
        }
    });
}

function cancelFile(key,fname) {

    document.getElementById(`K${key}`).remove()

    if (filesToExclude.includes(fname)) {
        filesToExclude.splice(filesToExclude.indexOf(fname),1)
    } else {
        filesToExclude.push(fname)
    }

    if (filesToExclude.length > 0) {
        document.getElementById('filesToExclude').value = filesToExclude.join()
    } else {
        document.getElementById('filesToExclude').value = ''
    }

    document.getElementById('filesToUpload').value = document.getElementById('filesToUpload').value-1

    if (document.getElementById('filesToUpload').value == 0) {
        document.getElementById('noFile').classList.remove('is-hidden')
    }
}


function getNames() {

    var newFiles = document.getElementById('fupload')

    if (Object.entries(newFiles.files).length < 1) {
        document.getElementById('non_selected').classList.remove('is-hidden')
        return true
    }

    document.getElementById('non_selected').classList.add('is-hidden')

    let satir = ''
    dosyalar = []

    for (const [key, dosya] of Object.entries(newFiles.files)) {

        satir = satir +`
        <tr id="K${key}">
            <td>${dosya.name}</td>
            <td>${dosya.size}</td>
            <td>${dosya.type}</td>
            <td><a onclick="cancelFile('${key}','${dosya.name}')">x</a></td>
        </tr>`

        dosyalar.push({key:dosya})

        document.getElementById('upButton').classList.remove('is-hidden');
    }

    document.getElementById('filesToUpload').value = Object.entries(newFiles.files).length
    document.getElementById('filesToExclude').value = ''
    document.getElementById('filesList').innerHTML = satir
}
