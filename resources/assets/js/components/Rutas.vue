<template>
            <main class="main">
                <notifications group="foo" :classes="notificationClasses"/>
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
                                    <th>Latitud Inicial</th>
                                    <th>Longitud Incial</th>
                                    <th>Latitud Final</th>
                                    <th>Longitud Final</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rutas in arrayRutas" :key="rutas.id">
                                    <td>
                                        <button type="button" @click="abrirModal('rutas','actualizar',rutas)" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button> &nbsp;
                                        <button type="button" class="btn btn-dark btn-sm" @click="eliminarRutas(rutas.id)"><i class="fa fa-trash-alt"></i></button>
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
                                    <td v-text="rutas.latitud_inicial"></td>
                                    <td v-text="rutas.longitud_inicial"></td>
                                    <td v-text="rutas.latitud_final"></td>
                                    <td v-text="rutas.longitud_final"></td>
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
                            <div class="form-group row">

                                <div class="col-md-6">
                                    <label class="col-md-3 form-control-label" for="email-input">Direccion</label>
                                    <label v-if="error_direccion==1" class="form-control-label text-danger">*direccion</label>
                                        <select class="form-control" :class="{'invalid-input': error_direccion}" v-model="direccion">
                                        <!--<select class="form-control" v-model="direccion">-->       
                                        <option value="0" disabled>--Selecionar hacia donde va--</option>
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
                                    <label class="form-control-label">Ruta</label>
                                    <label v-if="error_ruta==1" class="form-control-label text-danger">*ruta</label>
                                    <!--<input type="email" v-model="ruta" class="form-control" placeholder="Ejemplo Merida-Campeche">-->
                                    <input type="text" maxlength="254" v-model="ruta" class="form-control" :class="{'invalid-input': error_ruta}" placeholder="Ejemplo Merida-Campeche">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-control-label">Latitud Inicial</label>
                                    <label v-if="error_latitud_inicial==1" class="form-control-label text-danger">*latitud inicial</label>
                                    <!--<input type="email" v-model="latitud_inicial" class="form-control" placeholder="Ingrese la latitud del autobús">-->
                                    <input type="text" maxlength="254" v-model="latitud_inicial" class="form-control" :class="{'invalid-input': error_latitud_inicial}" placeholder="Ingrese la latitud del autobús">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-control-label">longitud Inicial</label>
                                    <label v-if="error_longitud_inicial==1" class="form-control-label text-danger">*longitud inicial</label>
                                    <!--<input type="email" v-model="longitud_inicial" class="form-control" placeholder="Ingrese la longitud del autobús">-->
                                    <input type="text" maxlength="254" v-model="longitud_inicial" class="form-control" :class="{'invalid-input': error_longitud_inicial}" placeholder="Ingrese la longitud del autobús">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-control-label">Latitud Final</label>
                                    <label v-if="error_latitud_final==1" class="form-control-label text-danger">*latitud final</label>
                                    <!--<input type="email" v-model="latitud_final" class="form-control" placeholder="Ingrese la latitud del autobús">-->
                                    <input type="text" maxlength="254" v-model="latitud_final" class="form-control" :class="{'invalid-input': error_latitud_final}" placeholder="Ingrese la latitud del autobús">
                                </div>
                                
                                <div class="col-md-12">
                                    <label class="form-control-label">longitud Final</label>
                                    <label v-if="error_longitud_final==1" class="form-control-label text-danger">*longitud final</label>
                                    <!--<input type="email" v-model="longitud_final" class="form-control" placeholder="Ingrese la longitud del autobús">-->
                                    <input type="text" maxlength="254" v-model="longitud_final" class="form-control" :class="{'invalid-input': error_longitud_final}" placeholder="Ingrese la longitud del autobús">
                                </div>
                            </div>
                                
                                <div v-show="errorRutas" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjRutas" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
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
                latitud_inicial : '',
                longitud_inicial : '',
                latitud_final : '',
                longitud_final : '',
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
                buscar : '',
                notificationClasses: null,
                error_direccion: 0,
                error_ruta: 0,
                error_paradero: 0,
                error_latitud_inicial: 0,
                error_longitud_inicial: 0,
                error_latitud_final: 0,
                error_longitud_final: 0
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
                    'latitud_inicial': this.latitud_inicial,
                    'longitud_inicial': this.longitud_inicial,
                    'latitud_final': this.latitud_final,
                    'longitud_final': this.longitud_final
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRutas(1,'','direccion');
                    swal("Datos registrados", "¡Tu registro se realizo correctamente!");
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
                    'latitud_inicial': this.latitud_inicial,
                    'longitud_inicial': this.longitud_inicial,
                    'latitud_final': this.latitud_final,
                    'longitud_final': this.longitud_final,
                    'id': this.rutas_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarRutas(1,'','direccion');
                    swal("Datos actualizados", "¡Tu registros se han actualizado correctamente!");
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarRutas(id){
               swal({
                title: 'Esta seguro de desactivar esta ruta?',
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
                title: 'Esta seguro de activar esta ruta?',
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
            eliminarRutas(id)
            {
                swal({
					title: '¿Está seguro de eliminar esta Ruta?',
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
                        axios.delete('/rutas/delete/'+id,{
                            //'id' : id,
                            
                        }).then(function (response) 
                        {
                            me.listarRutas(1,'');
                            swal(
                        'Eliminado!',
                        'La ruta ha sido eliminada con éxito.',
                        'success'
                        )
                        }).catch(function (error) 
                        {
                            me.listarRutas(1,'');
                            swal("¡No se puede eliminar!", "Esta ruta esta relacionada a un vehiculo", "info");
                        });
					} else {
                        swal.close();
					}
				});
            },
            /*eliminarRutas(id)
            {
                swal({
					title: '¿Está seguro de eliminar esta ruta?',
					text: "",
					type: 'warning',
					buttons:{
						confirm: {
							text : 'Si, aceptar',
							className : 'btn btn-success'
						},
						cancel: {
                            visible: true,
                            text : 'No, cancelar!',
							className: 'btn btn-danger'
						}
					}
				}).then((Delete) => {
                    if (Delete) 
                    {
                        let me = this;
                        axios.delete('/rutas/delete/'+id,{
                            //'id' : id,
                            
                        }).then(function (response) 
                        {
                            me.listarRutas(1,'');
                            swal({
							    title: 'Eliminado',
							    text: 'Su ruta ha sido eliminado',
							    type: 'success',
							    buttons : {
								    confirm: {
									    className : 'btn btn-success'
								    }
							    }
						    });
                        }).catch(function (error) 
                        {
                            console.log(error);
                            me.notificationError('Error','La ruta esta asignado a un vehiculo');
                        });
					} else {
						swal.close();
					}
				});
            },*/
            validarRutas(){
                this.errorRutas=0;
                this.errorMostrarMsjRutas =[];
                //if (!this.direccion) this.errorMostrarMsjRutas.push("La direccion de la categoría no puede estar vacía.");
                if (this.direccion == ''){ this.errorMostrarMsjRutas.push("La direccion de la categoría no puede estar vacía."); this.error_direccion = 1;}
                else {this.error_direccion = 0;}

                //if (!this.ruta) this.errorMostrarMsjRutas.push("La ruta de la categoría no puede estar vacío.");
                if (this.ruta == ''){ this.errorMostrarMsjRutas.push("La ruta de la categoría no puede estar vacío."); this.error_ruta = 1;}
                else {this.error_ruta = 0;}

                //if (!this.latitud_inicial) this.errorMostrarMsjRutas.push("La latitud de la categoría no puede estar vacía.");
                if (this.latitud_inicial == ''){ this.errorMostrarMsjRutas.push("La latitud de la categoría no puede estar vacía."); this.error_latitud_inicial = 1;}
                else {this.error_latitud_inicial = 0;}

                //if (!this.longitud_inicial) this.errorMostrarMsjRutas.push("La longitud de la categoría no puede estar vacía.");
                if (this.longitud_inicial == ''){ this.errorMostrarMsjRutas.push("La longitud de la categoría no puede estar vacía."); this.error_longitud_inicial = 1;}
                else {this.error_longitud_inicial = 0;}

                //if (!this.latitud_final) this.errorMostrarMsjRutas.push("La latitud de la categoría no puede estar vacía.");
                if (this.latitud_final == ''){ this.errorMostrarMsjRutas.push("La latitud de la categoría no puede estar vacía."); this.error_latitud_final = 1;}
                else {this.error_latitud_final = 0;}

                //if (!this.longitud_final) this.errorMostrarMsjRutas.push("La longitud de la categoría no puede estar vacía.");
                if (this.longitud_final == ''){ this.errorMostrarMsjRutas.push("La longitud de la categoría no puede estar vacía."); this.error_longitud_final = 1;}
                else {this.error_longitud_final = 0;}

                if (this.errorMostrarMsjRutas.length) this.errorRutas = 1;
                return this.errorRutas;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.direccion='';
                this.ruta='';
                this.latitud_inicial='';
                this.longitud_inicial='';
                this.latitud_final='';
                this.longitud_final='';
                this.error_direccion = 0;
                this.error_ruta = 0;
                this.error_direccion = 0;
                this.error_latitud_inicial= 0;
                this.error_longitud_inicial = 0;
                this.error_latitud_final= 0;
                this.error_longitud_final = 0;
                this.errorMostrarMsjRutas =[];
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "rutas":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Rutas';
                                this.direccion= '0';
                                this.ruta= '';
                                this.latitud_inicial= '';
                                this.longitud_inicial= '';
                                this.latitud_final= '';
                                this.longitud_final= '';
                                this.tipoAccion = 1;
                                this.notificationClasses = null;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Rutas';
                                this.tipoAccion=2;
                                this.rutas_id=data['id'];
                                this.direccion = data['direccion'];
                                this.ruta = data['ruta'];
                                this.latitud_inicial = data['latitud_inicial'];
                                this.longitud_inicial = data['longitud_inicial'];
                                this.latitud_final = data['latitud_final'];
                                this.longitud_final = data['longitud_final'];
                                this.notificationClasses = null;
                                break;
                            }
                        }
                    }
                    this.selectParadero();
                }
            }
        },
        notificationSuccess(title_s,text_s)
            {
                this.notificationClasses = 'vue-notification success';
                this.$notify({
                    group: 'foo',
                    title: title_s,
                    text: text_s
                });
            },
            notificationWarning(title_w,text_w)
            {
                this.notificationClasses = 'vue-notification warn';
                this.$notify({
                    group: 'foo',
                    title: title_w,
                    text: text_w
                });
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
    .invalid-input{
    border: 1px solid #dc0e26;
    }
</style>