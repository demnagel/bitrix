$(function() {

    var sessid = document.querySelector('[name="sessid"]').value;

    // Флаг запроса
    var ajaxWork = false;

    // Результирующие методы
    var resultFunction = {

        __newContent : function(selector, data){
            $(selector).empty(); // Очищаем блок
            $(selector).html(data); // Вставляем новый контент
        },

        editCompany : function (data) {
            if(data.result){
                alert('Изменения успешно сохранены');
            }
            else{
                alert('Ошибка при попытке внести изменения');
            }
        },

        usersUpdate : function (data) {
            this.__newContent('.users_parent', data);
        },

        docUpdate : function (data) {
            this.__newContent('.docs_parent', data);
        }

    };


    // Изменение полей компании
    $('#company_form').submit(function(event) {

        event.preventDefault();

        var params = {
            url: $(this).attr('action'),
            dataType: 'json',
            resultMethod: 'editCompany'
        };

        send($(this).serialize(), params);

    });


    // Изменение полей пользователя
    $(document).on("click", ".user_action", function(){

        var data = {
            sessid: sessid,
            IS_AJAX: 'Y',
            ACTION: 'usersUpdate',
            USER_ID: this.getAttribute('data-id'),
            METHOD: this.getAttribute('data-action')
        };

        var params = {
            url: '',
            dataType: 'html',
            resultMethod: 'usersUpdate'
        };

        send(data, params);

    });

    // Назначение договора компании
    $(document).on("click", ".doc-action-update", function() {

        var arrDocsId = [];
        var docs = document.querySelectorAll('[data-doc-id]');

        for (let doc of docs) {
            arrDocsId.push(doc.getAttribute('data-doc-id'));
        }

        var data = {
            sessid: sessid,
            IS_AJAX: 'Y',
            ACTION: 'docUpdate',
            DOC_ON: this.getAttribute('data-doc-id'),
            DOCS_ALL: arrDocsId
        };

        var params = {
            url: '/personal/organisation_profile/',
            dataType: 'html',
            resultMethod: 'docUpdate'
        };

        send(data, params);

    });



    function send(data, params){

        if(ajaxWork) {
            return false;
        }

        ajaxWork = true;

        $.ajax({
            type: 'POST',
            url: params.url,
            dataType: params.dataType,
            data: data,
            success: function(answer) {
                resultFunction[params.resultMethod](answer);
                ajaxWork = false;
            },

            error: function (jqXHR, exception) {
                if (jqXHR.status === 0) {
                    console.log('Not connect. Verify Network.');
                } else if (jqXHR.status == 404) {
                    console.log('Requested page not found (404).');
                } else if (jqXHR.status == 500) {
                    console.log('Internal Server Error (500).');
                } else if (exception === 'parsererror') {
                    console.log('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    console.log('Time out error.');
                } else if (exception === 'abort') {
                    console.log('Ajax request aborted.');
                } else {
                    console.log('Uncaught Error. ' + jqXHR.responseText);
                }
                ajaxWork = false;
            }

        });
    }


});