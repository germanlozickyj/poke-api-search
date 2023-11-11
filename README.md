# Proyecto Pokémon

## Instalación

Para que el proyecto funcione correctamente, instale todos los componentes necesarios ejecutando:

```bash
./install.sh
```

## Notes

Debido a que la API de PokeAPI no dispone de un endpoint para buscar un Pokémon por su nombre parcial, las solicitudes se realizan inicialmente obteniendo todos los Pokémon existentes y luego filtrándolos. Esta solicitud es bastante pesada. Una solución mas optima seria implementar una queue que almacene el nombre y el endpoint para obtener los detalles de ese personaje. Esta cola podría ejecutarse mensualmente para verificar si algún dato de la API ha cambiado. Sería una solución mucho más eficiente.

Con esto nos evitaríamos la request pesada y el buscador sería mucho más rápido.


## Running Tests

Para correr los test ejecute:

```bash
  ./vendor/bin/sail artisan test 
```