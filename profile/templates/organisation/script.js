(function () {
    let inputFile = document.getElementById('file-input');
    let dropzoneForm = document.querySelector('.company-profile__dropzone');
    let dropzoneUnavailable = document.querySelector('.company-profile__dropzone-unavailable');
    let fileName = document.getElementById('file-name');
    let fileType = document.getElementById('file-type');
    let fileSize = document.getElementById('file-size');
    let deleteFileButton = dropzoneUnavailable.querySelector('.company-profile__btn-delete');
    let saveFileButton = dropzoneUnavailable.querySelector('.company-profile__btn-save');

    inputFile.onchange = function () {

        if(inputFile.value !== 0) {
            dropzoneUnavailable.classList.remove('hidden');
            fileName.innerHTML = inputFile.files[0].name
            fileType.innerHTML = inputFile.files[0].type
            fileSize.innerHTML = inputFile.files[0].size
        }

        deleteFileButton.addEventListener("click", function(evt) {
            evt.preventDefault();
            inputFile.value = "";
            dropzoneUnavailable.classList.add('hidden');
        });
    };

    // Добавление карточки
    dropzoneForm.addEventListener("submit", function(evt) {
        evt.preventDefault();
        let formData = new FormData($(dropzoneForm)[0]);

        $.ajax({
            type: "POST",
            data: formData,
            dataType: 'json',
            async: false,
            success: function (data) {
                if(data.result){
                    $(deleteFileButton).attr("id", 'file_delete');
                    $(deleteFileButton).attr("data-file-id", data.id);
                    $(saveFileButton).addClass('hidden')
                }
                else{
                    alert(data.error);
                }
            },
            error: function(msg) {
                console.log(msg);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        inputFile.value = "";
    });


    // Удаление карточки
    $(document).on("click", "#file_delete", function(e){

        e.preventDefault();

        let data = {
            sessid: document.querySelector("input[name='sessid']").value,
            IS_AJAX: 'Y',
            ACTION: 'fileDelete',
            FILE_ID: this.getAttribute('data-file-id'),
        };

        $.ajax({
            type: "POST",
            data: data,
            dataType: 'json',
            async: false,
            success: function (data) {
                if(data.result){
                    $(deleteFileButton).removeAttr("id");
                    $(deleteFileButton).removeAttr("data-file-id");
                    $(saveFileButton).removeClass('hidden');
                }
                else{
                    alert(data.error);
                }
            },
            error: function(msg) {
                console.log(msg);
            }

        });

        dropzoneUnavailable.classList.add('hidden');

    });

})();