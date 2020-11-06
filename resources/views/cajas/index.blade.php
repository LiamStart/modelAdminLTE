@extends('adminlte::page')
@section('content')

<div class="container-fluid ">
    
</div>
    <script>
        function abrir(id){
            $.ajax({
                    type: "get",
                    url: "{{route('factura_ingreso.edit')}}",
                    data:{id:id},
                    datatype: "html",
                    success: function(datahtml, data){
                        //console.log(data);
                        $("#content").html(datahtml);
                        $("#modaleditar").modal("show");
                    },
                    error:  function(data){
                        Swal.fire('Error','Error al cargar','error');
                        console.log(data);
                    }
            });

        }

        $('#modaleditar').on('hidden.bs.modal', function(){
        $(this).removeData('bs.modal');
        });
    </script>
@endsection
