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
                        <i class="fa fa-align-justify"></i> Lista de vehiculos
                        <button type="button" @click="abrirModal('vehiculo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="ruta">Ruta</option>
                                      <option value="placa">Placas</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarVehiculo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarVehiculo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Ruta</th>
                                    <th>Tipo</th>
                                    <th>placa</th>
                                    <th>Conductor</th>
                                    <th>Destino</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="vehiculo in arrayVehiculo" :key="vehiculo.id">
                                    <td>
                                        <button type="button" @click="abrirModal('vehiculo','actualizar',vehiculo)" class="btn btn-warning btn-sm">
                                          <i class="fas fa-edit"></i>
                                        </button> &nbsp;
                                        <template v-if="vehiculo.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarVehiculo(vehiculo.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarVehiculo(vehiculo.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="vehiculo.ruta"></td>
                                    <td v-text="vehiculo.tipo"></td>
                                    <td v-text="vehiculo.placa"></td>
                                    <td v-text="vehiculo.conductor"></td>
                                    <td v-text="vehiculo.destino"></td>
                                    <td>
                                        <div v-if="vehiculo.condicion">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Ruta</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="ruta" class="form-control" placeholder="Nombreel nombre o numero de ruta">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="tipo" class="form-control" placeholder="Ingrese el tipo de vehiculo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">placa</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="placa" class="form-control" placeholder="Ingrese el numero de placa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">conductor</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="conductor" class="form-control" placeholder="Ingrese el nombre del conductor">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">destino</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="destino" class="form-control" placeholder="Ingrese el destino">
                                    </div>
                                </div>
                                <div v-show="errorVehiculo" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjVehiculo" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarVehiculo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarVehiculo()">Actualizar</button>
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
                id: 0,
                ruta : '',
                tipo : '',
                placa : '',
                conductor: '',
                destino: '',
                arrayVehiculo : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVehiculo : 0,
                errorMostrarMsjVehiculo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'placa',
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
            listarVehiculo (page,buscar,criterio){
                let me=this;
                var url= '/vehiculo?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVehiculo = respuesta.vehiculos.data;
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
                me.listarVehiculo(page,buscar,criterio);
            },
            registrarVehiculo(){
                if (this.validarVehiculo()){
                    return;
                }
                
                let me = this;

                axios.post('/vehiculo/registrar',{
                    'ruta': this.ruta,
                    'tipo': this.tipo,
                    'placa': this.placa,
                    'conductor': this.conductor,     
                    'destino': this.destino
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarVehiculo(1,'','placa');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarVehiculo(){
               if (this.validarVehiculo()){
                    return;
                }
                
                let me = this;

                axios.put('/vehiculo/actualizar',{
                    'ruta': this.ruta,
                    'tipo': this.tipo,
                    'placa': this.placa,
                    'conductor': this.conductor,     
                    'destino': this.destino,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarVehiculo(1,'','placa');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarVehiculo(id){
               swal({
                title: 'Esta seguro de desactivar este vehiculo?',
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

                    axios.put('/vehiculo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarVehiculo(1,'','placa');
                        swal(
                        'Desactivado!',
                        'El vehiculo ha sido desactivado con éxito.',
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
            activarVehiculo(id){
               swal({
                title: 'Esta seguro de activar este vehiculo?',
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

                    axios.put('/vehiculo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarvehiculo(1,'','placa');
                        swal(
                        'Activado!',
                        'El vehiculo ha sido activado con éxito.',
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
            validarVehiculo(){
                this.errorVehiculo=0;
                this.errorMostrarMsjVehiculo =[];

                if (!this.ruta) this.errorMostrarMsjVehiculo.push("La ruta no puede estar vacío.");

                if (this.errorMostrarMsjVehiculo.length) this.errorVehiculo = 1;
                if (!this.tipo) this.errorMostrarMsjVehiculo.push("El tipo de vehiculo no puede estar vacío.");

                if (this.errorMostrarMsjVehiculo.length) this.errorVehiculo = 1;
                if (!this.placa) this.errorMostrarMsjVehiculo.push("El numero de placa no puede estar vacío.");

                if (this.errorMostrarMsjVehiculo.length) this.errorVehiculo = 1;
                if (!this.conductor) this.errorMostrarMsjVehiculo.push("El nombre del conductor no puede estar vacío.");

                if (this.errorMostrarMsjVehiculo.length) this.errorVehiculo = 1;
                if (!this.destino) this.errorMostrarMsjVehiculo.push("El destino no puede estar vacío.");

                if (this.errorMostrarMsjVehiculo.length) this.errorVehiculo = 1;

                return this.errorVehiculo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.ruta='';
                this.tipo='';
                this.placa= 0;
                this.conductor= '';
                this.destino='';
                this.errorVehiculo=0;
                this.errorMostrarMsjVehiculo = [];
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "vehiculo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Vehiculo';
                                 this.ruta='';
                                this.tipo='';
                                this.placa= 0;
                                this.conductor= '';
                                this.destino='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Vehiculo';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.ruta = data['ruta'];
                                this.tipo= data['tipo'];
                                this.placa= data['placa'];
                                this.conductor= data['conductor'];
                                this.destino= data['destino'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarVehiculo(1,this.buscar,this.criterio);
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
