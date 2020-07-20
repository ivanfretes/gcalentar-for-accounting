# gcalendar-for-accounting
Inicialmente este paquete funciona con Google Calendar

### Todo

1. Almacenar el listado de eventos (con sus identificadores) - 
	- 15 semanal
2. Comparar si el evento ya fue agregado con anterioridad, y si la fecha de actualización es la misma, en caso que esto no sea asi, actualizar el evento en la db
3. Obtener 2(en principio calendarios), cuyos nombres deben ser 
'cuentas y pagos'
4. Crea una tabla contabilidad, donde se tendra la siguiente info 
	- Nombre del gasto / titulo
	- Monto
	- Fecha y hora



### Proceso
1. Registro
2. Completar con el nombre de los 2 calendarios a vincular, uno para egresos el otro para ingresos
3. 


### Mejoras
1. Agregar a estos dos calendarios procesos contables
2. Generar API, para consumir balances
3. Validar, si existe mas de 1 numero en la oracion, elegir el numero que tenga la moneda, despues
4. Posibilidad de multimoneda
5. Posibilidad de agregar un integrante, indicando, que el mismo formo parte de la transaccion
6. Posibilidad de agregar multiples creadores
7. Limitar a los dias del mes
8. Poder seleccionar un mes, para aplicar los gastos