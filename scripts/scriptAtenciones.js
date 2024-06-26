var idSeleccionado;
            
function getId(fila)
{
    if(idSeleccionado != null)
        document.getElementById('idAtencion:' + idSeleccionado).classList.remove('fila-seleccionada');

    document.getElementById(fila.id).classList.add('fila-seleccionada');
    idSeleccionado = fila.id.replace('idAtencion:', '');
    
    if (fila.getElementsByTagName('td')[4].getAttribute('data-personal_habilitado') == '1'){
        document.getElementById('btnModificarAtencion').style.display = 'inline';
        document.getElementById('btnEliminarAtencion').style.display = 'inline';
    }
    else{
        document.getElementById('btnModificarAtencion').style.display = 'none';
        document.getElementById('btnEliminarAtencion').style.display = 'none';
    }
}

function mostrarModalEliminar(boton){
    if (boton.id == "btnEliminarAtencion" && idSeleccionado){
        document.getElementById("id_eliminar").value = idSeleccionado;

        var myModal = new bootstrap.Modal(document.getElementById("modalEliminarAtencion"), {});
        myModal.show();
    }
    else{
        Swal.fire({
            icon: "error",
            title: "Ups...",
            text: "Seleccione una fila de la tabla",     
            confirmButtonColor: "#f0ad4e",           
        });
    }
}

function mostrarModalAtencion(boton)
{
    if (boton.id == 'btnAnadirAtencion')
    {
        var fecHoraMinima = new Date();
        fecHoraMinima.setHours(fecHoraMinima.getHours() - 2); // + 1 - 3 (resto 3 por hora UTC)
        fecHoraMinima = fecHoraMinima.toISOString().slice(0, -8);

        var modal = document.getElementById('modalAtencion');
        
        modal.querySelector('[name=operacion').value = 'insertar';
        modal.querySelector('[name=id_modificar]').value = null;

        modal.querySelector('[name=cliente_id]').value = "";
        modal.querySelector('[name=mascota_id]').value = "";
        modal.querySelector('[name=servicio_id]').value = "";
        
        modal.getElementsByClassName('contenedor_dt')[0].style.display = 'none';
        modal.querySelector('[name=fecha_hora_salida]').required = false;
        modal.querySelector('[name=fecha_hora_salida]').value = '';
        modal.querySelector('[name=fecha_hora_salida]').min = fecHoraMinima;

        modal.querySelector('[name=titulo]').value = null;
        modal.querySelector('[name=descripcion]').value = null;
        
        modal.querySelector('[name=btn_enviar').classList.remove('btn-primary');
        modal.querySelector('[name=btn_enviar').classList.add('btn-success');
        modal.querySelector('[name=btn_enviar').textContent = 'Guardar';
        document.getElementById('labelModalAtencion').textContent = 'Nueva atención';

        option = document.getElementById('select_mascota').getElementsByTagName('option');
        for (i = 0; i < option.length; i++)
            option[i].style.display = 'block';

        $('#select_mascota').trigger("chosen:updated");
        $('#select_servicio').trigger("chosen:updated");
        document.getElementById('select_mascota').dispatchEvent(new Event('change'));

        
        var myModal = new bootstrap.Modal(modal, {});
        myModal.show();
    }
    else if (boton.id == 'btnModificarAtencion' && idSeleccionado)
    {
        if (document.getElementById('idAtencion:' + idSeleccionado).getAttribute('data-modificable') == '1')
        {
            var atencion = document.getElementById('idAtencion:' + idSeleccionado).getElementsByTagName('td');
            var modal = document.getElementById('modalAtencion');
            
            aux = atencion[0].textContent;
            aux = aux.split(' ');
            aux[0] = aux[0].split('/').reverse().join('-');
            aux = aux[0] + ' ' + aux[1];
            
            var fecHoraMinima = new Date(aux);

            fecHoraMinima.setHours(fecHoraMinima.getHours() - 2); // + 1 - 3 (resto 3 por hora UTC)
            fecHoraMinima = fecHoraMinima.toISOString().slice(0, -8);
            modal.querySelector('[name=fecha_hora_salida]').min = fecHoraMinima;

            modal.querySelector('[name=operacion').value = 'modificar';
            modal.querySelector('[name=id_modificar]').value = idSeleccionado;
            
            modal.querySelector('[name=mascota_id]').value = atencion[1].getAttribute('data-mascota_id');
            modal.querySelector('[name=servicio_id]').value = atencion[3].getAttribute('data-servicio_id');
            modal.querySelector('[name=titulo]').value = atencion[5].textContent;
            modal.querySelector('[name=descripcion]').value = atencion[6].textContent;

            var fec_hora_salida;
            aux = atencion[7].textContent;
            if (aux){
                aux = aux.split(' ');
                aux[0] = aux[0].split('/').reverse().join('-');
                fec_hora_salida = aux[0] + ' ' + aux[1];
            }

            if (fec_hora_salida)
            {
                modal.getElementsByClassName('contenedor_dt')[0].style.display = 'block';
                modal.querySelector('[name=fecha_hora_salida]').required = true;
                modal.querySelector('[name=fecha_hora_salida]').value = fec_hora_salida;
            }
            else
            {
                modal.getElementsByClassName('contenedor_dt')[0].style.display = 'none';
                modal.querySelector('[name=fecha_hora_salida]').required = false;
                modal.querySelector('[name=fecha_hora_salida]').value = '';
            }

            modal.querySelector('[name=btn_enviar').classList.add('btn-primary');
            modal.querySelector('[name=btn_enviar').classList.remove('btn-success');
            modal.querySelector('[name=btn_enviar').textContent = 'Modificar';
            document.getElementById('labelModalAtencion').textContent = 'Modificar atención';

            $('#select_mascota').trigger("chosen:updated");
            $('#select_servicio').trigger("chosen:updated");
            document.getElementById('select_mascota').dispatchEvent(new Event('change'));

            var myModal = new bootstrap.Modal(modal, {});
            myModal.show();
        }
        else
        {
            Swal.fire({
                icon: "error",
                title: "Atención",
                text: "La mascota seleccionada ha fallecido. No se puede modificar la atención.",     
                confirmButtonColor: "#f0ad4e",           
            });
        }
    }
    else
    {
        Swal.fire({
            icon: "error",
            title: "Ups...",
            text: "Seleccione una fila de la tabla",     
            confirmButtonColor: "#f0ad4e",           
        });
    }
}

function borrarFiltros(){
    window.location.replace(location.pathname);
}

function mostrarAtencion()
{
    if (idSeleccionado)
    {
        var atencion = document.getElementById('idAtencion:' + idSeleccionado).getElementsByTagName('td');
        var modal = document.getElementById('modalDatos');
    
        modal.querySelector('[name=fecha_hora]').value = atencion[0].textContent;
        modal.querySelector('[name=mascota]').value = atencion[1].textContent;
        modal.querySelector('[name=cliente]').value = atencion[2].textContent;
        modal.querySelector('[name=servicio]').value = atencion[3].textContent;
        modal.querySelector('[name=personal]').value = atencion[4].textContent;
        modal.querySelector('[name=titulo]').value = atencion[5].textContent;
        modal.querySelector('[name=descripcion]').value = atencion[6].textContent;
        modal.querySelector('[name=precio]').value = atencion[8].textContent;

        fec_hora_salida = atencion[7].textContent;
        
        if (fec_hora_salida)
        {
            modal.getElementsByClassName('contenedor_dt')[0].style.display = 'block';
            modal.querySelector('[name=fecha_hora_salida]').value = fec_hora_salida;
        }
        else
        {
            modal.getElementsByClassName('contenedor_dt')[0].style.display = 'none';
            modal.querySelector('[name=fecha_hora_salida]').value = '';
        }

        var myModal = new bootstrap.Modal(modal, {});
        myModal.show();
    }
    else{
        Swal.fire({
            icon: "error",
            title: "Ups...",
            text: "Seleccione una fila de la tabla",     
            confirmButtonColor: "#f0ad4e",           
        });
    }
}

$('#modalAtencion').on('shown.bs.modal', function () {
    $('.chosen-select', this).chosen();
});


$('#select_cliente').on('change', function(e) {
    cliente_id = document.getElementById('select_cliente').value;
    option = document.getElementById('select_mascota').getElementsByTagName('option');
    valor_seleccionado = document.getElementById('select_mascota').value;

    for (i = 0; i < option.length; i++)
    {
        if (option[i].value == valor_seleccionado && option[i].getAttribute('data-cliente_id') != cliente_id){
            document.getElementById('select_mascota').value = "";
        }

        if (option[i].getAttribute('data-cliente_id') != cliente_id)
            option[i].style.display = 'none';
        else
            option[i].style.display = '';
    }

    $('#select_mascota').trigger("chosen:updated");
});


$('#select_mascota').on('change', function(e) {
    mascota_id = document.getElementById('select_mascota').value;
    option = document.getElementById('select_mascota').getElementsByTagName('option');
    
    for (i = 0; i < option.length; i++)
    {    
        if (option[i].value == mascota_id){
            cliente_id = option[i].getAttribute('data-cliente_id');
            document.getElementById('select_cliente').value = cliente_id;
            break;
        }
    }
    $('#select_cliente').trigger("chosen:updated");
});


$('#select_servicio').on('change', function(e) {
    servicio_id = document.getElementById('select_servicio').value;
    option = document.getElementById('select_servicio').getElementsByTagName('option');
    
    for (i = 0; i < option.length; i++)
    {
        if (option[i].value == servicio_id)
        {
            modal = document.getElementById('modalAtencion');
            if (option[i].getAttribute('data-fec_salida') == true)
            {
                modal.getElementsByClassName('contenedor_dt')[0].style.display = 'block';
                modal.querySelector('[name=fecha_hora_salida]').required = true;
                modal.querySelector('[name=fecha_hora_salida]').value = fec_hora_salida;
            }
            else
            {
                modal.getElementsByClassName('contenedor_dt')[0].style.display = 'none';
                modal.querySelector('[name=fecha_hora_salida]').required = false;
                modal.querySelector('[name=fecha_hora_salida]').value = '';
            }
        }
    }
});


$('#formFiltro').on('shown.bs.collapse', function(e){
    $('.chosen-select', this).chosen();
});