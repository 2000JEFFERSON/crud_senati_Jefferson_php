<?php
// Define el espacio de nombres del controlador
namespace App\Http\Controllers;

// Importa las clases necesarias para la Base de Datos, el Cliente HTTP y las Vistas
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

// Definición de la clase del controlador
class PokemonController extends Controller
{
    
    // Método principal: sincroniza datos de la API a la DB local y muestra la vista
    public function index():View{
        // Bloque try-catch para manejar errores de conexión o de la base de datos
        try{
            // 1. PETICIÓN INICIAL: Solicita la lista base de Pokémon (nombres y URLs).
            // NOTA: Esta llamada es Sincrónica (bloqueante).
            $res= Http::get('https://pokeapi.co/api/v2/pokemon/');
            
            if ($res->successful()){
                $apidata = $res->json();
                $pokemonResults = $apidata['results'] ?? [];
                
                // 2. INICIO DEL BUCLE DE PROCESAMIENTO
                // Se recorre cada Pokémon obtenido de la lista inicial.
                foreach ($pokemonResults as $pokemon) {
                    
                    // 2.1. PETICIÓN DETALLADA (EL CUELLO DE BOTELLA)
                    // Para obtener las imágenes, se hace una SEGUNDA petición Sincrónica 
                    // a la URL individual de cada Pokémon. Esto hace que el proceso sea lento.
                    $detailRes = Http::get($pokemon['url']); 
                    
                    if ($detailRes->successful()) {
                        // Se decodifican los datos detallados del Pokémon
                        $pokemonDetails = $detailRes->json(); 
                    } else {
                        // Si la petición falla para este Pokémon, se salta al siguiente
                        continue; 
                    }
                    
                    // Se extraen las URLs de las imágenes de alta calidad (Official Artwork)
                    $imageDefault = $pokemonDetails['sprites']['other']['official-artwork']['front_default'] ?? null;
                    $imageShiny   = $pokemonDetails['sprites']['other']['official-artwork']['front_shiny'] ?? null;
                    
                    // 2.2. PERSISTENCIA: Se usa updateOrInsert para guardar/actualizar en la DB
                    DB::table('pokemon_list')->updateOrInsert(
                        // Condición de búsqueda: se usa el 'name' como identificador único
                        ['name' => $pokemon['name']], 
                        [
                            // Campos a actualizar/insertar
                            'url'    => $pokemon['url'],
                            'image'  => $imageDefault, 
                            'imageS' => $imageShiny,
                        ]
                    );

                } // Fin del bucle foreach

            } // Fin del if ($res->successful())
                
        } 
        /* Manejo de Excepciones: Si hay un error de conexión, se establece $apidata a null 
           para que la vista pueda manejar la ausencia de datos sin romperse. */
        catch(\Exception $e){
            $apidata = null;
        }

        // 3. RECUPERACIÓN DE DATOS LOCALES
        // Se obtienen todos los Pokémon guardados en la base de datos local para mostrarlos
        $local = DB::table('pokemon_list')->get();
        
        // 4. RETORNO DE VISTA
        // Se carga la vista 'pokemon' y se le pasa la lista de Pokémon locales.
        return view("pokemon", [
            "LocalPokemon"=> $local, // Lista de Pokémon obtenida de la DB
            "apiResults"=> $apidata  // Datos originales de la API (opcional)
        ]);
    } 

}