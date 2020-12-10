<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Paraderos
                        <button type="button" @click="abrirModal('paraderos','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="ubicacion">Ubicación</option>
                                      <option value="ruta">Ruta</option>
                                      <option value="serie">Serie</option>
                                      <option value="latitud">Latitud</option>
                                      <option value="longitud">Longitud</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarParaderos(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarParaderos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Ubicación</th>
                                    <th>Ruta</th>
                                    <th>Serie</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="paraderos in arrayParaderos" :key="paraderos.id">
                                    <td>
                                        <button type="button" @click="abrirModal('paraderos','actualizar',paraderos)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="paraderos.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarParaderos(paraderos.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarParaderos(paraderos.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="paraderos.ubicacion"></td>
                                    <td v-text="paraderos.ruta"></td>
                                    <td v-text="paraderos.serie"></td>
                                    <td v-text="paraderos.latitud"></td>
                                    <td v-text="paraderos.longitud"></td>
                                    <td>
                                        <div v-if="paraderos.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                             <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ubicación</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="ubicacion" class="form-control" placeholder="ubicacion del autobús"> 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Ruta</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="ruta" class="form-control" placeholder="Ingrese la ruta del autobus">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Serie</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="serie" class="form-control" placeholder="Ingrese la serie del autobus">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Latitud</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="latitud" class="form-control" placeholder="Ingrese la latitud del autobús">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">longitud</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="longitud" class="form-control" placeholder="Ingrese la longitud del autobús">
                                    </div>
                                </div>

                                <div v-show="errorParaderos" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjParaderos" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarParaderos()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarParaderos()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data (){
            return {
                paraderos_id: 0,
                ubicacion : '',
                ruta : '',
                serie : '',
                latitud : '',
                longitud : '',
                arrayParaderos : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorParaderos : 0,
                errorMostrarMsjParaderos : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'ubicacion',
                buscar : ''
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarParaderos (page,buscar,criterio){
                let me=this;
                var url= '/paraderos?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayParaderos = respuesta.paraderos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarParaderos(page,buscar,criterio);
            },
            registrarParaderos(){
                if (this.validarParaderos()){
                    return;
                }
                
                let me = this;

                axios.post('/paraderos/registrar',{
                    'ubicacion': this.ubicacion,
                    'ruta': this.ruta,
                    'serie': this.serie,
                    'latitud': this.latitud,
                    'longitud': this.longitud
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarParaderos(1,'','ubicacion');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarParaderos(){
               if (this.validarParaderos()){
                    return;
                }
                
                let me = this;

                axios.put('/paraderos/actualizar',{
                    'ubicacion': this.ubicacion,
                    'ruta': this.ruta,
                    'serie': this.serie,
                    'latitud': this.latitud,
                    'longitud': this.longitud,
                    'id': this.paraderos_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarParaderos(1,'','ubicacion');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarParaderos(id){
               swal({
                title: 'Esta seguro de desactivar esta paradero?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/paraderos/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarParaderos(1,'','ubicacion');
                        swal(
                        'Desactivado!',
                        'El paradero ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            activarParaderos(id){
               swal({
                title: 'Esta seguro de activar este paradero?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/paraderos/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarParaderos(1,'','ubicacion');
                        swal(
                        'Activado!',
                        'El paradero ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarParaderos(){
                this.errorParaderos=0;
                this.errorMostrarMsjParaderos =[];

                if (!this.ubicacion) this.errorMostrarMsjParaderos.push("La ubicación no puede estar vacia.");
                if (!this.ruta) this.errorMostrarMsjParaderos.push("La ruta no puede estar vacia.");
                if (!this.serie) this.errorMostrarMsjParaderos.push("La serie no puede estar vacia.");
                if (!this.latitud) this.errorMostrarMsjParaderos.push("La latitud no puede estar vacia.");
                if (!this.longitud) this.errorMostrarMsjParaderos.push("La longitud no puede estar vacia.");

                if (this.errorMostrarMsjParaderos.length) this.errorParaderos = 1;

                return this.errorParaderos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.ubicacion='';
                this.ruta='';
                this.serie='';
                this.latitud='';
                this.longitud='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "paraderos":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Paradero';
                                this.ubicacion= '';
                                this.ruta= '';
                                this.serie= '';
                                this.latitud= '';
                                this.longitud= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Paradero';
                                this.tipoAccion=2;
                                this.paraderos_id=data['id'];
                                this.ubicacion = data['ubicacion'];
                                this.ruta = data['ruta'];
                                this.serie = data['serie'];
                                this.latitud = data['latitud'];
                                this.longitud = data['longitud'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarParaderos(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>