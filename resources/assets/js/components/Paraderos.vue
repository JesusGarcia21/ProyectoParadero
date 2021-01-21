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
                                    <th>Latitud</th>
                                    <th>Longitud</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="paraderos in arrayParaderos" :key="paraderos.id">
                                    <td>
                                        <button type="button" @click="abrirModal('paraderos','actualizar',paraderos)" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button> &nbsp;
                                        <button type="button" class="btn btn-dark btn-sm" @click="eliminarParaderos(paraderos.id)"><i class="fa fa-trash-alt"></i></button>
                                        
                                        
                                        
                                        
                                        <template v-if="paraderos.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarParaderos(paraderos.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarParaderos(paraderos.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="paraderos.ubicacion"></td>
                                    <td v-text="paraderos.id_rutas"></td>
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
                            <div class="form-group row">
                                
                                <div class="col-md-6">
                                    <label class="col-md-3 form-control-label" for="email-input">Ubicación</label>
                                    <label v-if="error_ubicacion==1" class="form-control-label text-danger">*ubicacion</label>
                                        <select class="form-control" :class="{'invalid-input': error_ubicacion}" v-model="ubicacion">
                                        <!--<select class="form-control" v-model="ubicacion">-->       
                                        <option value="0" disabled>--Selecionar--</option>
                                        <option value="Campeche">Campeche</option>
                                        <option value="Hecelchakan">Hecelchakan</option>
                                        <option value="Dzitbalche">Dzitbalche</option>
                                        <option value="Pomuch">Pomuch</option>
                                        <option value="Tenabo">Tenabo</option> 
                                        <option value="Becal">Becal</option>
                                        <option value="halacho">Halacho</option> 
                                        <option value="Maxcanu">Maxcanu</option> 
                                        <option value="Merida">Merida</option>              
                                     </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="text-input">Ruta</label>
                                    <label v-if="error_ruta==1" class="form-control-label text-danger">*ruta</label>
                                    <select class="form-control" :class="{'invalid-input': error_ruta}" v-model="id_rutas">
                                        <option value="0">Seleccione</option>
                                        <option v-for="rutas in arrayRutas" :key="rutas.id" :value="rutas.id" v-text="rutas.ruta"></option>
                                    </select>
                                    </div>

                                <div class="col-md-6">
                                    <label class="form-control-label">Latitud</label>
                                    <label v-if="error_latitud==1" class="form-control-label text-danger">*latitud</label>
                                    <!--<input type="email" v-model="latitud" class="form-control" placeholder="Ingrese la latitud del autobús">-->
                                    <input type="text" maxlength="254" v-model="latitud" class="form-control" :class="{'invalid-input': error_latitud}" placeholder="Ingrese la latitud del autobus">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-control-label">Longitud</label>
                                    <label v-if="error_longitud==1" class="form-control-label text-danger">*longitud</label>
                                    <!--<input type="email" v-model="longitud" class="form-control" placeholder="Ingrese la longitud del autobús">-->
                                    <input type="text" maxlength="254" v-model="longitud" class="form-control" :class="{'invalid-input': error_longitud}" placeholder="Ingrese la longitud del autobus">
                                </div>
                            </div>
                                
                                <div v-show="errorParaderos" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjParaderos" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
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
                id_rutas : 0,
                ubicacion : '',
                latitud : '',
                longitud : '',
                arrayParaderos : [],
                arrayRutas : [],
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
                buscar : '',
                notificationClasses: null,
                error_ubicacion: 0,
                error_ruta: 0,
                error_latitud: 0,
                error_longitud: 0
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
            selectRuta()
            {
                let me=this;
                var url = '/paraderos/selectRuta';
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayRutas = respuesta.rutas;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            registrarParaderos(){
                if (this.validarParaderos()){
                    return;
                }
                
                let me = this;

                axios.post('/paraderos/registrar',{
                    'ubicacion': this.ubicacion,
                    'id_rutas': this.id_rutas,
                    'latitud': this.latitud,
                    'longitud': this.longitud
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarParaderos(1,'','ubicacion');
                    swal("Datos registrados", "¡Tu registro se realizo correctamente!");
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
                    'id_rutas': this.id_rutas,
                    'latitud': this.latitud,
                    'longitud': this.longitud,
                    'id': this.paraderos_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarParaderos(1,'','ubicacion');
                    swal("Datos actualizados", "¡Tu registros se han actualizado correctamente!");
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
            eliminarParaderos(id)
            {
                swal({
					title: '¿Está seguro de eliminar este Paradero?',
					text: "",
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
                    if (result.value) 
                    {
                        let me = this;
                        axios.delete('/paraderos/delete/'+id,{
                            //'id' : id,
                            
                        }).then(function (response) 
                        {
                            me.listarParaderos(1,'');
                            swal(
                        'Eliminado!',
                        'El Paradero ha sido eliminada con éxito.',
                        'success'
                        )
                        }).catch(function (error) 
                        {
                            me.listarParaderos(1,'');
                            swal("¡No se puede eliminar!", "Este paradero esta relacionada a un vehiculo", "info");
                        });
					} else {
						swal.close();
					}
				});
            },

            validarParaderos(){
                this.errorParaderos=0;
                this.errorMostrarMsjParaderos =[];

                //if (!this.ubicacion) this.errorMostrarMsjParaderos.push("La ubicación no puede estar vacia.");
                if (this.ubicacion == ''){ this.errorMostrarMsjParaderos.push("La ubicación no puede estar vacia."); this.error_ubicacion = 1;}
                else {this.error_ubicacion = 0;}

                //if (!this.latitud) this.errorMostrarMsjParaderos.push("La latitud no puede estar vacia.");
                if (this.latitud == ''){ this.errorMostrarMsjParaderos.push("La latitud no puede estar vacia."); this.error_latitud = 1;}
                else {this.error_latitud = 0;}

                //if (!this.longitud) this.errorMostrarMsjParaderos.push("La longitud no puede estar vacia.");
                if (this.longitud == ''){ this.errorMostrarMsjParaderos.push("La longitud no puede estar vacia."); this.error_longitud = 1;}
                else {this.error_longitud = 0;}

                if (this.errorMostrarMsjParaderos.length) this.errorParaderos = 1;

                return this.errorParaderos;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.ubicacion='';
                this.id_rutas=0;
                this.latitud='';
                this.longitud='';
                this.error_ubicacion = 0;
                this.error_latitud = 0;
                this.error_longitud = 0;
                this.errorMostrarMsjParaderos =[];
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
                                this.ubicacion= '0';
                                this.id_rutas=0;
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
                                this.id_rutas = data['id_rutas'];
                                this.latitud = data['latitud'];
                                this.longitud = data['longitud'];
                                break;
                            }
                        }
                    }
                    this.selectRuta();
                }
            }
        },

        notificationError(title_e,text_e)
            {
                this.notificationClasses = 'vue-notification error';
                this.$notify({
                    group: 'foo',
                    title: title_e,
                    text: text_e
                });
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
    .invalid-input{
    border: 1px solid #dc0e26;
    }

</style>