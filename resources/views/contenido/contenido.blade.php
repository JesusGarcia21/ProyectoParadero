    @extends('principal')
    @section('contenido')
        <template v-if="menu==0">
        <info></info>
        </template>

        <template v-if="menu==1">
        <vehiculo></vehiculo>
        </template>

        <template v-if="menu==2">
        <tipos></tipos>
            
        </template>

        <template v-if="menu==3">
            
            <paraderos></paraderos>
        </template>

        <template v-if="menu==4">
        <rutas></rutas>
        </template>

        <template v-if="menu==5">
            <horarios></horarios>
        </template>

        <template v-if="menu==6">
            <prueba></prueba>
        </template>

        <template v-if="menu==7">
            <ejemplo></ejemplo>
        </template>

        <template v-if="menu==8">
            <h1>Contenido del menú 8</h1>
        </template>

        <template v-if="menu==9">
            <h1>Contenido del menú 9</h1>
        </template>

        <template v-if="menu==10">
            <h1>Contenido del menú 10</h1>
        </template>

        <template v-if="menu==11">
            <h1>Contenido del menú 11</h1>
        </template>

        <template v-if="menu==12">
            <h1>Contenido del menú 12</h1>
        </template>
        
    @endsection
    
        