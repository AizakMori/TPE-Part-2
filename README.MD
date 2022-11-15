# Postman:
# Endpoint base
*GET* trae todos los valores actuales

    http://localhost/tpe2/api/invocacion

*GET + ID* trae el valor seleccionado

    http://localhost/tpe2/api/invocacion/5


*GET + seleccion de columna y disposicion ASC y DESC* trae todos los valores seleccionando el orden ascendente y descendente de una columna.
* En este caso traería todos los valores ordenados de forma *ascendente* por *nombre*

    http://localhost/tpe2/api/invocacion?orderby=nombre&ordermode=asc

*GET + seleccion de columna y disposicion ASC y DESC + paginacion*trae todos los valores seleccionando el order ascendente y descendente de una columna + la seleccion del punto de inicio y cantidad de valores deseados.
* En este caso traeria todos los valores ordenados de forma *ascendente* por *ID*, empezando por el 1 y mostrando solo 3 valores

    http://localhost/tpe2/api/invocacion?orderby=id&ordermode=asc&limit=3&offset=0


*POST + PUT*

*POST* introducir en el body formato raw el siguiente JSON de ejemplo, el id se le coloca automaticamente y se le coloca la categoria 1 por defecto

{
    "nombre":"invocacion generica",
    "elemento":"normal",
    "velocidad":"media",
    "habilidad":"golpe serio"
}


*PUT* para modificar se debe colocar el ID del valor seleccionado y a partir de ahi es el mismo metodo que POST

    http://localhost/tpe2/api/invocacion/:ID

{
    "nombre":"invocacion no tan generica",
    "elemento":"normal",
    "velocidad":"media",
    "habilidad":"golpe mas serio"
}

*DELETE* elimina el valor seleccionado por medio de su ID

    http://localhost/tpe2/api/invocacion/:ID