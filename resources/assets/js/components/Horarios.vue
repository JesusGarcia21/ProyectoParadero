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
                        <i class="fa fa-align-justify"></i> Lista de Horarios
                        <button type="button" @click="abrirModal('horario','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="inicio">inicio</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarHorario(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarHorario(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                
                             <tr>
                                    <th>Opciones</th>
                                    <th>Dias</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                           <tbody>
                                <tr v-for="horarios in arrayHorario" :key="horarios.id">
                                    <td>
                                        <button type="button" @click="abrirModal('horario','actualizar',horarios)" class="btn btn-warning btn-sm">
                                          <i class="fas fa-edit"></i>
                                        </button> &nbsp;
                                        <button type="button" class="btn btn-dark btn-sm" @click="eliminarHorario(horarios.id)"><i class="fa fa-trash-alt"></i></button>

                                        <template v-if="horarios.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarHorario(horarios.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarHorario(horarios.id)">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="horarios.dias"></td>
                                    <td v-text="horarios.inicio"></td>
                                     <td v-text="horarios.fin"></td>
                                    <td>
                                        <div v-if="horarios.condicion">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Dias de servicio</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="dias" class="form-control" placeholder="Ingrese el numero de placa">
                                    </div>
                                </div>
                                <!--<div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Hora de inicio</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="inicio" class="form-control" placeholder="Ingrese el numero de placa">
                                    </div>
                                </div>-->
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Hora de inicio</label>
                                    <input type="radio" id="uno" value="Uno" v-model="inicio">
                                    <label for="uno">Uno</label>
                                </div>    
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Hora de finalización</label>
                                    <div class="col-md-9">
                                        <input type="time" v-model="fin" class="form-control" placeholder="Ingrese el nombre del conductor">
                                    </div>
                                </div>
                                <div v-show="errorHorario" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjHorario" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarHorario()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarHorario()">Actualizar</button>
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
                dias : '',
                inicio: '',
                fin: '',
                arrayHorario : [],
                arrarDias : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorHorario : 0,
                errorMostrarMsjHorario : [],
                tab: null,
        items: [
          'web', 'shopping', 'videos', 'images', 'news',
        ],
        text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
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
            listarHorario (page,buscar,criterio){
                let me=this;
                var url= '/horario?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayHorario = respuesta.horarios.data;
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
                me.listarHorario(page,buscar,criterio);
            },
            registrarHorario(){
                if (this.validarHorario()){
                    return;
                }
                
                let me = this;

                axios.post('/horario/registrar',{
                    'dias': this.dias,
                    'inicio': this.inicio,
                    'fin': this.fin,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHorario(1,'','inicio');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarHorario(){
               if (this.validarHorario()){
                    return;
                }
                
                let me = this;

                axios.put('/horario/actualizar',{
                    'dias': this.dias,
                    'inicio': this.inicio,
                    'fin': this.fin,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHorario(1,'','inicio');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarHorario(id){
               swal({
                title: 'Esta seguro de desactivar este horaio?',
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

                    axios.put('/horario/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarHorario(1,'','inicio');
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
            activarHorario(id){
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

                    axios.put('/horario/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarHorario(1,'','inicio');
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

            eliminarHorario(id)
            {
                swal({
					title: '¿Está seguro de eliminar este vehiculo?',
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
                        axios.delete('/horario/delete/'+id,{
                            //'id' : id,
                            
                        }).then(function (response) 
                        {
                            me.listarHorario(1,'');
                            swal(
                        'Eliminado!',
                        'El vehiculo ha sido eliminado con éxito.',
                        'success'
                        )
                        }).catch(function (error) 
                        {
                            console.log(error);
                           
                        });
					} else {
						swal.close();
					}
				});
            },

            validarHorario(){
                this.errorHorario=0;
                this.errorMostrarMsjHorario =[];

                if (this.errorMostrarMsjHorario.length) this.errorHorario = 1;
                if (!this.dias) this.errorMostrarMsjHorario.push("El numero de placa no puede estar vacío.");

                if (this.errorMostrarMsjHorario.length) this.errorHorario = 1;
                if (!this.inicio) this.errorMostrarMsjHorario.push("El nombre del conductor no puede estar vacío.");

                if (this.errorMostrarMsjHorario.length) this.errorHorario = 1;
                if (!this.fin) this.errorMostrarMsjHorario.push("El destino no puede estar vacío.");

                if (this.errorMostrarMsjHorario.length) this.errorHorario = 1;

                return this.errorHorario;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.dias='';
                this.inicio='';
                this.fin= '';
                this.errorHorario=0;
                this.errorMostrarMsjHorario = [];
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "horario":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Vehiculo';
                                this.dias='';
                                this.inicio='';
                                this.fin= '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Horario';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.dias = data['dias'];
                                this.inicio= data['inicio'];
                                this.fin= data['fin'];
                                break;
                            }
                        }
                    }
                    
                }
            }
        },
        mounted() {
            this.listarHorario(1,this.buscar,this.criterio);
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
