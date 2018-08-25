Dropzone.options.myDropzone = {

    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 20,
    maxFilesize: 60,
    previewTemplate: document.querySelector('#preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Remover archivo',
    dictFileTooBig: 'El archivo es más grande que 60MB',
    timeout: 5000,

    init: function () {
        var submitBtn = document.querySelector("#submit");
        myDropzone = this;
        submitBtn.addEventListener("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        });
        this.on("addedfile", function(file) {
            //alert("file uploaded");
        });

        this.on("complete", function(file) {
            myDropzone.removeFile(file);
        });

        this.on("success",function (file) {

                myDropzone.processQueue.bind(myDropzone);

            }


        );


    }
};