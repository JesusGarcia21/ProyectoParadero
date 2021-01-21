
//getData();
marcadores();
rut()

//ubicacion real
navigator.geolocation.getCurrentPosition(function(position)
{
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    //let marker = L.marker([latitude,longitude],{icon: Icono}).addTo(map);
    console.log(position)   
},
function(error)
{
    console.log(error)
}
);

//dibujadi del mapa 
var map = L.map('map',{
    center: [20.174091, -90.136502], 
    zoom: 8
})
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 10,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiamVzdXMyMTA5OTciLCJhIjoiY2tqZzJyeGR2MHF0aTJxdGdxemtiaWFyMSJ9.e1SWDjo_4E9lQdvtEm9FfQ'}).addTo(map);
    
    async function rut()
    {
        const respose = await fetch('/paraderos/rutas');
        const data = await respose.json();
        
      
       for (item of data)
        {
            //var hola = item;
            //console.log(hola);
            for (ruta of item)
             {
                 console.log(ruta)
                if(ruta.id == ruta.id_rutas)
                 {
                 //console.log(item[i]);
                var polylinePoints = [
                    [ruta.latitud_inicial, ruta.longitud_inicial],
                    [ruta.latitud_final, ruta.longitud_final]
                    
                  ];            
                  
                  var polyline = L.polyline(polylinePoints).addTo(map); 
                } 
            }
            
            
        }
        
        
    }
//dibujado de marcadores
async function marcadores()
{
    const respose = await fetch('/paraderos/ver');
    const data = await respose.json();

    console.log(data);
   
   var latitude;
    var longitude;
    var pe;
    navigator.geolocation.getCurrentPosition(function(position)
    {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        for(item of data)
        {
            for (sep of item)
            {
                if (sep.latitud == latitude && sep.longitud == longitude)
                {
                     pe = sep.id_rutas;
                    console.log(pe);
                    
                    
                }
                else{
                    console.log('eroro')
                }

            }
        }
        //console.log(item)
        
        
           for (sep of item)
            {
                //console.log(sep);
                if(pe == sep.id_rutas){
                    
                    let marker = L.marker([sep.latitud,sep.longitud],{icon: Icono}).addTo(map);
                    
                }
            }
            
    

    })
    
}

/*async function prueba()
{
    const respose = await fetch('/paraderos/prueba');
    const data = await respose.json();
    var latitude;
    var longitude;
    navigator.geolocation.getCurrentPosition(function(position)
    {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        for(item of data)
        {
            for (sep of item)
            {
                if(sep.latitud == latitude)
                {
                   // let marker = L.marker([sep.latitud,sep.longitud],{icon: Icono}).addTo(map);
                    //console.log(sep.latitud);
                }
                else
                {
                    console.log('No hay paraderos asignados');   
                }   
            }   
        }
    },
    function(error)
    {
        console.log(error)
    });   
}*/
//iconos
var Icono = L.icon({
    iconUrl: "img/paradero.png",
    iconSize: [30, 40],
    iconAnchor: [15, 40],
    popupAnchor: [0, -40]
    });
    
 /*Función para actualizar 
    function actualizar()
    {
    location.reload(true);
    }
 setInterval("actualizar()",6000);*/