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
                        <button type="button" @click="abrirModal('horarios','registrar')" class="btn btn-secondary">
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
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miercoles</th>
                                    <th>Jueves</th>
                                    <th>viernes</th>
                                    <th>sabado</th>
                                    <th>domingo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                           <tbody>
                                <tr v-for="horarios in arrayHorario" :key="horarios.id">
                                    <td>
                                        <button type="button" @click="abrirModal('horarios','actualizar',horarios)" class="btn btn-warning btn-sm">
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
                                    <td  >
                                        <template>
                                            <tr v-text="horarios.iniciol">
                                            </tr>
                                        
                                            <tr v-text="horarios.finl">
                                            </tr>
                                        </template>
                                    </td>
                                    <td>
                                        <template>
                                            <tr v-text="horarios.iniciom">
                                            </tr>
                                        
                                            <tr v-text="horarios.finm">
                                            </tr>
                                        </template>
                                    </td>
                                    <td>
                                        <template>
                                            <tr v-text="horarios.iniciomi">
                                            </tr>
                                            <tr v-text="horarios.finmi">
                                            </tr>
                                        </template>
                                    </td>
                                    <td>
                                        <template>
                                            <tr v-text="horarios.inicioj">
                                            </tr>
                                            <tr v-text="horarios.finj">
                                            </tr>
                                        </template>
                                    </td>
                                    <td>
                                        <template>
                                            <tr v-text="horarios.iniciov">
                                            </tr>
                                            <tr v-text="horarios.finv">
                                            </tr>
                                        </template>
                                    </td>
                                    <td>
                                        <template>
                                            <tr v-text="horarios.inicios">
                                            </tr>
                                            <tr v-text="horarios.fins">
                                            </tr>
                                        </template>
                                    </td>
                                    <td>
                                        <template>
                                            <tr v-text="horarios.iniciod">
                                            </tr>
                                            <tr v-text="horarios.iniciod">
                                            </tr>
                                        </template>
                                    </td>
                                    
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
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: scroll;"  aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close" data-dismiss="modal">
                              <span aria-hidden="true">x</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" metdod="post" enctype="multipart/form-data" class="form-horizontal">

                                
                                   <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Lunes</label>
                                    <div class="custom-control custom-checkbox mr-sm-2">                                       
                                        <input type="checkbox" class="form-check-input " id="switch-lunes" v-model="lunes">
                                         <template v-if="lunes">
                                            <div class="form-check">
                                            <label class="form-check-label" for="switch-lunes" value='activo'></label>
                                            <div class="col-md-12">inicio
                                                    <input type="time" v-model="iniciol" class="form-control" >
                                                </div>
                                                <div class="col-md-12">fin
                                                    <input type="time" v-model="finl" class="form-control" >
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <label class="custom-control-label" for="switch-lunes"></label>
                                        </template>
                                    </div>
                                    </div>

                                <!--<div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Hora de inicio</label>
                                    <div class="col-md-6">
                                        <input type="text" v-model="inicio" class="form-control" placeholder="Ingrese el numero de placa">
                                    </div>
                                </div>-->
                                   
                                   <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Martes</label>
                                    <div class="custom-control custom-checkbox mr-sm-2">                                       
                                        <input type="checkbox" class="form-check-input " id="switch-martes" v-model="martes">
                                         <template v-if="martes">
                                            <div class="form-check">
                                            <label class="form-check-label" for="switch-martes" value='activo'></label>
                                            <div class="col-md-12">inicio
                                                    <input type="time" v-model="iniciom" class="form-control" >
                                                </div>
                                                <div class="col-md-12">fin
                                                    <input type="time" v-model="finm" class="form-control" >
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <label class="custom-control-label" for="switch-martes"></label>
                                        </template>
                                    </div>
                                    </div>

                                   <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Miercoles</label>
                                    <div class="custom-control custom-checkbox mr-sm-2">                                       
                                        <input type="checkbox" class="form-check-input " id="switch-miercoles" v-model="miercoles">
                                         <template v-if="miercoles">
                                            <div class="form-check">
                                            <label class="form-check-label" for="switch-miercoles" value='activo'></label>
                                            <div class="col-md-12">inicio
                                                    <input type="time" v-model="iniciomi" class="form-control" >
                                                </div>
                                                <div class="col-md-12">fin
                                                    <input type="time" v-model="finmi" class="form-control" >
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <label class="custom-control-label" for="switch-miercoles"></label>
                                        </template>
                                    </div>
                                    </div>

                                
                                   <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Jueves</label>
                                    <div class="custom-control custom-checkbox mr-sm-2">                                       
                                        <input type="checkbox" class="form-check-input " id="switch-jueves" v-model="jueves">
                                         <template v-if="jueves">
                                            <div class="form-check">
                                            <label class="form-check-label" for="switch-jueves" value='activo'></label>
                                            <div class="col-md-12">inicio
                                                    <input type="time" v-model="inicioj" class="form-control" >
                                                </div>
                                                <div class="col-md-12">fin
                                                    <input type="time" v-model="finj" class="form-control" >
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <label class="custom-control-label" for="switch-jueves"></label>
                                        </template>
                                    </div>
                                    </div>

                                    
                                   <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Viernes</label>
                                    <div class="custom-control custom-checkbox mr-sm-2">                                       
                                        <input type="checkbox" class="form-check-input " id="switch-viernes" v-model="viernes">
                                         <template v-if="viernes">
                                            <div class="form-check">
                                            <label class="form-check-label" for="switch-viernes" value='activo'></label>
                                            <div class="col-md-12">inicio
                                                    <input type="time" v-model="iniciov" class="form-control" >
                                                </div>
                                                <div class="col-md-12">fin
                                                    <input type="time" v-model="finv" class="form-control" >
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <label class="custom-control-label" for="switch-viernes"></label>
                                        </template>
                                    </div>
                                    </div>

                                    
                                   <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sabado</label>
                                    <div class="custom-control custom-checkbox mr-sm-2">                                       
                                        <input type="checkbox" class="form-check-input " id="switch-sabado" v-model="sabado">
                                         <template v-if="sabado">
                                            <div class="form-check">
                                            <label class="form-check-label" for="switch-sabado" value='activo'></label>
                                            <div class="col-md-12">inicio
                                                    <input type="time" v-model="inicios" class="form-control" >
                                                </div>
                                                <div class="col-md-12">fin
                                                    <input type="time" v-model="fins" class="form-control" >
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <label class="custom-control-label" for="switch-sabado"></label>
                                        </template>
                                    </div>
                                    </div>

                                    
                                   <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Domingo</label>
                                    <div class="custom-control custom-checkbox mr-sm-2">                                       
                                        <input type="checkbox" class="form-check-input " id="switch-domingo" v-model="domingo">
                                         <template v-if="domingo">
                                            <div class="form-check">
                                            <label class="form-check-label" for="switch-domingo" value='activo'></label>
                                            <div class="col-md-12">inicio
                                                    <input type="time" v-model="iniciod" class="form-control" >
                                                </div>
                                                <div class="col-md-12">fin
                                                    <input type="time" v-model="find" class="form-control" >
                                                </div>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <label class="custom-control-label" for="switch-domingo"></label>
                                        </template>
                                    </div>
                                    </div>

                               
                                <!--<div v-show="errorHorario" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjHorario" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>-->

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
                lunes:'',
                martes:'',
                miercoles:'',
                jueves:'',
                viernes:'',
                sabado: '',
                domingo: '',
                iniciol:'',
                finl:'',
                iniciom:'',
                finm:'',
                iniciomi:'',
                finmi:'',
                inicioj:'',
                finj:'',
                iniciov:'',
                finv:'',
                inicios:'',
                fins:'',
                iniciod:'',
                find:'',
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
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'lunes',
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
                /*if (this.validarHorario()){
                    return;
                }*/
                
                let me = this;

                axios.post('/horario/registrar',{
                    'lunes': this.lunes,
                    'martes': this.martes,
                    'miercoles': this.miercoles,
                    'jueves': this.jueves,
                    'viernes': this.viernes,
                    'sabado': this.sabado,
                    'domingo': this.domingo,
                    'iniciol': this.iniciol,
                    'finl': this.finl,
                    'iniciom': this.iniciom,
                    'finm': this.finm,
                    'iniciomi': this.iniciomi,
                    'finmi': this.finmi,
                    'inicioj': this.inicioj,
                    'finj': this.finj,
                    'iniciov': this.iniciov,
                    'finv': this.finv,
                    'inicios': this.inicios,
                    'fins': this.fins,
                    'iniciod': this.iniciod,
                    'find': this.find,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHorario(1,'','lunes');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarHorario(){
              /* if (this.validarHorario()){
                    return;
                }
                */
                let me = this;

                axios.put('/horario/actualizar',{
                      'lunes': this.lunes,
                    'martes': this.martes,
                    'miercoles': this.miercoles,
                    'jueves': this.jueves,
                    'viernes': this.viernes,
                    'sabado': this.sabado,
                    'domingo': this.domingo,
                    'iniciol': this.iniciol,
                    'finl': this.finl,
                    'iniciom': this.iniciom,
                    'finm': this.finm,
                    'iniciomi': this.iniciomi,
                    'finmi': this.finmi,
                    'inicioj': this.inicioj,
                    'finj': this.finj,
                    'iniciov': this.iniciov,
                    'finv': this.finv,
                    'inicios': this.inicios,
                    'fins': this.fins,
                    'iniciod': this.iniciod,
                    'find': this.find,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHorario(1,'','lunes');
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
                        me.listarHorario(1,'','lunes');
                        swal(
                        'Desactivado!',
                        'El Horario ha sido desactivado con éxito.',
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
                title: 'Esta seguro de activar este horario?',
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
                        me.listarHorario(1,'','lunes');
                        swal(
                        'Activado!',
                        'El horario ha sido activado con éxito.',
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
					title: '¿Está seguro de eliminar este horario?',
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
                        'El horario ha sido eliminado con éxito.',
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

           /* validarHorario(){
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
            },*/
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.lunes='';
                this.martes='';
                this.miercoles= '';
                /*this.errorHorario=0;
                this.errorMostrarMsjHorario = [];*/
                this.jueves='';
                this.viernes='';
                this.sabado='';
                this.domingo='';
                this.iniciol='';
                this.finl='';
                this.iniciom='';
                this.finm='';
                this.iniciomi='';
                this.finmi='';
                this.inicioj='';
                this.finj='';
                this.iniciov='';
                this.finv='';
                this.inicios='';
                this.fins='';
                this.iniciod='';
                this.find='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "horarios":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Horario';
                                 this.tipoAccion = 1;
                                this.lunes='';
                                this.martes='';
                                this.miercoles= '';              
                                this.jueves='';
                                this.viernes='';
                                this.sabado='';
                                this.domingo='';
                                this.iniciol='';
                                this.finl='';
                                this.iniciom='';
                                this.finm='';
                                this.iniciomi='';
                                this.finmi='';
                                this.inicioj='';
                                this.finj='';
                                this.iniciov='';
                                this.finv='';
                                this.inicios='';
                                this.fins='';
                                this.iniciod='';
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Horario';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.lunes = data['lunes'];
                                this.martes= data['martes'];
                                this.miercoles= data['miercoles'];
                                this.jueves= data['jueves'];
                                this.viernes= data['viernes'];
                                this.sabado= data['sabado'];
                                this.domingo= data['domingo'];
                                this.iniciol= data['iniciol'];
                                this.finl= data['miercoles'];
                                this.iniciom= data['iniciom'];
                                this.finm= data['finm'];
                                this.iniciomi= data['iniciomi'];
                                this.finmi= data['miercoles'];
                                this.inicioj= data['inicioj'];
                                this.finj= data['finj'];
                                this.iniciov= data['iniciov'];
                                this.finv= data['finv'];
                                this.inicios= data['inicios'];
                                this.fins= data['fins'];
                                this.iniciod= data['iniciod'];
                                this.find= data['find'];

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
