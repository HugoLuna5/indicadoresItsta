$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


var varEne = "";
var varAgo = "";
var varFebJul = "";
$("#add-periodo").click(function(e) {
    e.preventDefault();

    /**
     <label for="ene" style="margin-left: 10px;">Enero</label>
     <input required class="form-control" type="text" id="Enero" placeholder="Escribe tu año del periodo">
     */
    var ene = $("#ene").val();
    var ago = $("#ago").val();


    if (ene != "" && ago != ""){
        $("#more").css("display", '');

        varEne = ene;
        varAgo = ago
        varFebJul = ene;
        $("#feb-jul").val(ene);




    }else{
        alert("Ingresa texto en los campos");

    }




});


$("#agregar").click(function(e) {
    e.preventDefault();

    $.ajax({
        type:'POST',
        dataType:'json',
        url: 'http://127.0.0.1:8080/administrador/agregar-periodo',
        data:{varAgo:varAgo,varEne:varEne,varFebJul:varFebJul},
        success: function (data) {


            swal("¡Buen trabajo!", "Haz agregado los periodos: \nAgosto "+varAgo+" - Enero "+varEne+"\n Febrero "+varFebJul+" - Julio "+varFebJul, "success");


            $("#more").css("display", 'none');
            $("#ene").val("");
            $("#ago").val("");


            setTimeout(
                function() {
                    console.log("This will run 300 milliseconds later");
                    window.location.href = "http://127.0.0.1:8080/administrador";
                },
                1000);
        }
    });




});

$("#eliminar").click(function(e) {
    e.preventDefault();
    alert("Te rediccionaremos a: \nhttp://127.0.0.1:8080/administrador");
    window.location.href = "http://127.0.0.1:8080/administrador";
});


/**
 swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete)=>{
            if (willDelete) {
                swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Your imaginary file is safe!");
    }
    });

 */
