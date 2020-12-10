<template>
            <main class="main">
            <!-- Breadcrumb -->
            <!--<ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>-->
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Rutas
                        <button type="button" @click="abrirModal('rutas','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="direccion">Dirección</option>
                                      <option value="ruta">Ruta</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRutas(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarRutas(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Dirección</th>
                                    <th>Ruta</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rutas in arrayRutas" :key="rutas.id">
                                    <td>
                                        <button type="button" @click="abrirModal('rutas','actualizar',rutas)" class="btn btn-warning btn-sm">
                                          <i class="fas fa-edit"></i>
                                        </button> &nbsp;
                                        <template v-if="rutas.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarRutas(rutas.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarRutas(rutas.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="rutas.direccion"></td>
                                    <td v-text="rutas.ruta"></td>
                                    <td v-text="rutas.latitud"></td>
                                    <td v-text="rutas.longitud"></td>
                                    <td>
                                        <div v-if="rutas.condicion">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Dirección</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="direccion del autobús"> 
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Ruta</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="ruta" class="form-control" placeholder="Ingrese la ruta del autobus">
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
                                
                                <div v-show="errorRutas" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjRutas" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarRutas()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRutas()">Actualizar</button>
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
                rutas_id: 0,
                direccion : '',
                ruta : '',
                latitud : '',
                longitud : '',
                arrayRutas : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorRutas : 0,
                errorMostrarMsjRutas : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'direccion',
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
            listarRutas (page,buscar,criterio){
                let me=this;
                var url= '/rutas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRutas = respuesta.rutas.data;
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
                me.listarRutas(page,buscar,criterio);
            },
            registrarRutas(){
                if (this.validarRutas()){
                    return;
                }
                
                let me = this;

                axios.post('/rutas/registrar',{
                    'direccion': this.direccion,
                    'ruta': this.ruta,
                    'latitud': this.latitud,
                    'longitud': this.longitud
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRutas(1,'','direccion');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarRutas(){
               if (this.validarRutas()){
                    return;
                }
                
                let me = this;

                axios.put('/rutas/actualizar',{
                    'direccion': this.direccion,
                    'ruta': this.ruta,
                    'latitud': this.latitud,
                    'longitud': this.longitud,
                    'id': this.rutas_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRutas(1,'','direccion');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarRutas(id){
               swal({
                title: 'Esta seguro de desactivar esta categoría?',
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

                    axios.put('/rutas/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarRutas(1,'','direccion');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
            activarRutas(id){
               swal({
                title: 'Esta seguro de activar esta categoría?',
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

                    axios.put('/rutas/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarRutas(1,'','direccion');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
            validarRutas(){
                this.errorRutas=0;
                this.errorMostrarMsjRutas =[];

                if (!this.direccion) this.errorMostrarMsjRutas.push("El direccion de la categoría no puede estar vacío.");
                if (!this.ruta) this.errorMostrarMsjRutas.push("El ruta de la categoría no puede estar vacío.");
                if (!this.latitud) this.errorMostrarMsjRutas.push("El latitud de la categoría no puede estar vacío.");
                if (!this.longitud) this.errorMostrarMsjRutas.push("El longitud de la categoría no puede estar vacío.");

                if (this.errorMostrarMsjRutas.length) this.errorRutas = 1;

                return this.errorRutas;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.direccion='';
                this.descripcion='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "rutas":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Categoría';
                                this.direccion= '';
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar categoría';
                                this.tipoAccion=2;
                                this.rutas_id=data['id'];
                                this.direccion = data['direccion'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarRutas(1,this.buscar,this.criterio);
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