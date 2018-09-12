/* Tigra Menu items structure */
var MENU_ITEMS1 = [
	['Administración', null, null,
	 	['Usuarios', null, null,
			['Ingresar Usuario', 'makeUserForm.php', {'tt':'Ingresar Usuario'}],
			['Cambio Contraseña', 'cambio.php', {'tt':'Cambio Contraseña'}],
			['Actualizar Datos', 'buscarUsuario.php', {'tt':'Actualizar Datos'}],
			['Borrar Usuario', 'deleteUserForm.php', {'tt':'Borrar Usuario'}],
			['Listar Usuarios', 'listarUsuarios.php', {'tt':'Listar Usuario'}]
		],
		['Personal', null, null,
			['Ingresar Personal', 'makePersonalForm.php', {'tt':'Ingresar Personal'}],
			['Actualizar Datos', 'buscarPersonal.php', {'tt':'Actualizar Datos'}],
			['Borrar Personal', 'deletePersonalForm.php', {'tt':'Borrar Personal'}],
			['Listar Personal', 'listarPersonal.php', {'tt':'Listar Personal'}]
		]	
	],
	['Listados Base', null, null,
		['Categorías Producto', null, null,
			['Crear', 'crearCategoria.php', {'tt':'Crear Categoría de Producto'}],
			['Modificar', 'buscarCat.php', {'tt':'Modificar Categoría de Producto'}],
			['Eliminar', 'deleteCatForm.php', {'tt':'Eliminar Categoría de Producto'}],
			['Listar', 'listarcateg.php', {'tt':'Listar Categorías de Producto'}]
		],
		['Categorías M. Prima', null, null,
			['Crear', 'crearCategoria_MP.php', {'tt':'Crear Categoría de Materia Prima'}],
			['Modificar', 'buscarCat_MP.php', {'tt':'Modificar Categoría de Materia Prima'}],
			['Eliminar', 'deleteCatForm_MP.php', {'tt':'Eliminar Categoría de Materia Prima'}],
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categorías de Materia Prima'}]
		],
		['Categorías Distribución', null, null,
			['Crear', 'crearCategoria_DIS.php', {'tt':'Crear Categoría de Producto de Distribución'}],
			['Modificar', 'buscarCat_DIS.php', {'tt':'Modificar Categoría de Producto de Distribución'}],
			['Eliminar', 'deleteCatForm_DIS.php', {'tt':'Eliminar Categoría de Producto de Distribución'}],
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categorías de Producto de Distribución'}]
		],
		['Productos', null, null,
			['Crear', 'crearProd.php', {'tt':'Crear Producto'}],
			['Modificar', 'buscarProd.php', {'tt':'Modificar Producto'}],
			['Eliminar', 'deleteProdForm.php', {'tt':'Eliminar Producto'}],
			['Listar', 'listarProd.php', {'tt':'Listar Producto'}]
		],
		['Materias Primas', null, null,
			['Crear', 'crearMP.php', {'tt':'Crear Materia Prima'}],
			['Modificar', 'buscarMP.php', {'tt':'Modificar Materia Prima'}],
			['Eliminar', 'deleteMPForm.php', {'tt':'Eliminar Materia Prima'}],
			['Listar', 'listarMP.php', {'tt':'Listar Materia Prima'}]
		],
		['Envase', null, null,
			['Crear', 'crearEnv.php', {'tt':'Crear Envase'}],
			['Modificar', 'buscarEnv.php', {'tt':'Modificar Envase'}],
			['Eliminar', 'deleteEnvForm.php', {'tt':'Eliminar Envase'}],
			['Listar', 'listarEnv.php', {'tt':'Listar Envase'}]
		],
		['Válvulas y Tapas', null, null,
			['Crear', 'crearVal.php', {'tt':'Crear Válvula o Tapa'}],
			['Modificar', 'buscarVal.php', {'tt':'Modificar Válvula o Tapa'}],
			['Eliminar', 'deleteValForm.php', {'tt':'Eliminar Válvula o Tapa'}],
			['Listar', 'listarVal.php', {'tt':'Listar Válvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Crear', 'crearEtq.php', {'tt':'Crear Etiquetas'}],
			['Modificar', 'buscarEtq.php', {'tt':'Modificar Etiquetas'}],
			['Eliminar', 'deleteEtqForm.php', {'tt':'Eliminar Etiquetas'}],
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['Código genérico', null, null,
			['Crear', 'crearCod.php', {'tt':'Crear Medida'}],
			['Modificar', 'buscarCod.php', {'tt':'Modificar Medida'}],
			['Eliminar', 'deleteCodForm.php', {'tt':'Eliminar Medida'}],
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentación Producto', null, null,
			['Crear', 'crearMedida.php', {'tt':'Crear Presentación'}],
			['Modificar', 'buscarMed.php', {'tt':'Modificar Presentación'}],
			['Eliminar', 'deleteMedForm.php', {'tt':'Eliminar Presentación'}],
			['Listar', 'listarmed.php', {'tt':'Listar Presentación'}],
			['Activar', 'buscarMed1.php', {'tt':'Activar Presentación'}],
			['Desactivar', 'buscarMed2.php', {'tt':'Desactivar Presentación'}]
		],
		['Distribución', null, null,
			['Crear', 'crearDis.php', {'tt':'Crear Producto de Distribución'}],
			['Modificar', 'buscarDis.php', {'tt':'Modificar Producto de Distribución'}],
			['Eliminar', 'deleteDisForm.php', {'tt':'Eliminar Producto de Distribución'}],
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribución'}]
		],
		['Rel Envase Distribución', null, null,
			['Crear Relación', 'envaseDis.php', {'tt':'Crear Relación de Envase a Producto de Distribución'}],
			['Listar Relaciones', 'listarenvaseDis.php', {'tt':'Listar Envases en de Distribución'}]
		],
		['Relación Paca Producto', null, null,
			['Crear Relación', 'crearDes.php', {'tt':'Crear Relación de Paca a Producto de Distribución'}],
			['Listar Relaciones', 'listarDes.php', {'tt':'Listar Productos de Distribución'}]
		],
		['Tipos de Provedores', null, null,
			['Crear', 'crearCatProv.php', {'tt':'Crear Tipo de Proveedor'}],
			['Modificar', 'buscarCatProv.php', {'tt':'Modificar Tipo de Proveedor'}],
			['Eliminar', 'deleteCatProvForm.php', {'tt':'Eliminar Tipo de Proveedor'}],
			['Listar', 'listarCatProv.php', {'tt':'Listar Tipo de Proveedor'}]
		],
		['Tipos de Cliente', null, null,
			['Crear', 'crearCatCli.php', {'tt':'Crear Tipo de Cliente'}],
			['Modificar', 'buscarCatCli.php', {'tt':'Modificar Tipo de Cliente'}],
			['Eliminar', 'deleteCatCliForm.php', {'tt':'Eliminar Tipo de Cliente'}],
			['Listar', 'listarCatCli.php', {'tt':'Listar Tipo de Cliente'}]
		]
	],
	['Compras', null, null,
		['Proveedor', null, null,
			['Crear', 'makeProvForm.php', {'tt':'Ingresar Proveedor'}],
			['Actualizar', 'buscarProv.php', {'tt':'Actualizar Datos Proveedor'}],
			['Eliminar', 'deleteProvForm.php', {'tt':'Eliminar Proveedor'}],
			['Listar', 'listarProv.php', {'tt':'Listar Proveedores'}]
		],
		['Materia Prima', null, null,
			['Ingresar', 'compramp.php', {'tt':'Ingresar Compra Materia Prima'}],
			['Modificar', 'buscarcompramp.php', {'tt':'Modificar Compra Materia Prima'}],
			['Consulta Provedor', 'consultaMp.php', {'tt':'Consulta de Compras por Proveedor de Materia Prima'}],
			['Consultar', 'listacompramp.php', {'tt':'Listado de Compras de Materia Prima'}]
		],
		['Envase Válvulas / Tapas', null, null,
			['Ingresar', 'compraenv.php', {'tt':'Ingresar compra de Envase y tapas'}],
			['Modificar', 'buscarcompraenv.php', {'tt':'Modificar compra de Envase y tapas'}],
			['Consulta Provedor', 'consultaEnv.php', {'tt':'Consulta de Compras por Proveedor de Envase y Tapas'}],
			['Consultar', 'listacompraenv.php', {'tt':'Listado de Compras de Envase y tapas'}]
		],
		['Etiquetas', null, null,
			['Ingresar', 'compraetq.php', {'tt':'Ingresar compra de Etiquetas'}],
			['Modificar', 'buscarcompraetq.php', {'tt':'Modificar compra de Etiquetas'}],
			['Consulta Provedor', 'consultaEtq.php', {'tt':'Consulta de Compras por Proveedor de Etiqueta'}],
			['Consultar', 'listacompraetq.php', {'tt':'Listado de Compras de Etiquetas'}]
		],
		['Distribución', null, null,
			['Ingresar', 'compradist.php', {'tt':'Ingresar compra de Producto de Distribución'}],
			['Modificar', 'buscarcompradist.php', {'tt':'Modificar compra de Producto de Distribución'}],
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribución'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribución'}]
		],
		['Gastos', null, null,
			['Ingresar', 'gasto.php', {'tt':'Ingresar Gastos de Oficina'}],
			['Modificar', 'buscargasto.php', {'tt':'Modificar Gastos de Oficina'}],
			['Consulta Provedor', 'consultaGas.php', {'tt':'Consulta de Compras por Proveedor de Gastos'}],
			['Consultar', 'listagastos.php', {'tt':'Listado de Gastos de Oficina'}]
		],
		['Consultas', null, null,
			['Compras', 'consultaCompras.php', {'tt':'Consulta de Compras por Fecha'}],
			['Gastos', 'consultaGastos.php', {'tt':'Consulta de Gastos por Fecha'}],
			['Por Producto Distribución', 'buscarDist.php', {'tt':'Consulta de Compra por Producto de Distribución'}],
			['Por Materia Prima', 'buscarMateriaP.php', {'tt':'Consulta de Compra por Materia Prima'}],
			['Por Envase y Tapas', 'buscarEnvase_Tapas.php', {'tt':'Consulta de Compra de Envase Tapas'}]
		],
		['Tesorería', null, null,
			['Facturas por Pagar General', 'factXpagar.php', {'tt':'Lista de Facturas por Pagar General'}],
			['Facturas por Pagar Proveedor', 'buscarProv2.php', {'tt':'Lista de Facturas por Pagar por Proveedor'}],
			['Histórico de pagos General', 'histo_pagos.php', {'tt':'Histórico de Pagos General'}],
			['Histórico de pagos X Proveedor', 'buscarProv5.php', {'tt':'Histórico de Pagos por Proveedor'}],
			['Pagos de Compras General', 'pagosXcompras.php', {'tt':'Lista de Pagos realizados por Compras'}],
			['Pagos de Compras por Proveedor', 'buscarProv3.php', {'tt':'Lista de Pagos realizados por Compras por Proveedor'}],
			['Pagos de Gastos General', 'pagosXgastos.php', {'tt':'Lista de Pagos realizados por Compras'}],
			['Pagos de Gastos por Proveedor', 'buscarProv4.php', {'tt':'Lista de Pagos realizados por Compras por Proveedor'}]
		]
	],
	['Producción', null, null,
		['Formulaciones', null, null,
			['Crear Fórmula Producto', 'formula.php', {'tt':'Ingresar Fórmula de Producto'}],
			['Modificar Fórmula Producto', 'buscarform.php', {'tt':'Modificar la Fórmula de Producto'}],
			['Eliminar Fórmula Producto', 'deleteFormula.php', {'tt':'Eliminar Fórmula de Producto'}],
			['Crear Fórmula de Color', 'formula_col.php', {'tt':'Ingresar Fórmula de Producto'}],
			['Modificar Fórmula de Color', 'buscarform_col.php', {'tt':'Modificar la Fórmula de Producto'}],
			['Eliminar Fórmula de Color', 'deleteFormula_col.php', {'tt':'Eliminar Fórmula de Producto'}]
		],
		['Órdenes de Producción', null, null,
			['Crear O. Producción', 'o_produccion.php', {'tt':'Generar Orden de Producción'}],
			['Modificar uso de MP', 'buscarOprod.php', {'tt':'Modificar información de uso de materia prima por lote'}],
			['Anular O. Producción', 'anular_O_produccion.php', {'tt':'Anular Orden de Producción'}],
			['O. Producción anuladas', 'listarOrProdA.php', {'tt':'Listado de Órdenes de Producción Anuladas'}],
			['Listar O. Producción', 'listarOrProd.php', {'tt':'Listado de Órdenes de Producción'}]
		],
		['Soluciones de Color', null, null,
			['Crear Solución de Color', 'o_produccion_color.php', {'tt':'Generar Orden de Producción de Solución de Color'}],
			['Modificar uso de MP', 'buscarOprod_color.php', {'tt':'Modificar información de uso de materia prima por lote de solución'}],
			['Listar O. Producción Color', 'listarOrProd_color.php', {'tt':'Listado de Órdenes de Producción de Color'}]
		],
		['Envasado', null, null,
			['Envasado', 'Envasado.php', {'tt':'Envasado por Orden de Producción'}],
			['Listar productos por Lote', 'listarEnvasado.php', {'tt':'Listado de Productos por Órdenes de Producción'}],
			['O. Producción por envasar', 'listarOrProdsinE.php', {'tt':'Listado de Órdenes de Producción sin Envasar'}]
		],
		['Reenvase', null, null,
			['Crear', 'cambio_pres.php', {'tt':'Ingresar Cambios de Producto'}],
			['Listar', 'listarCambios.php', {'tt':'Listar cambios de Producto'}]
		],
		['Kits', null, null,
			['Crear Kits', 'crear_kits.php', {'tt':'Crear Kits'}],
			['Organización de Kits', 'org_kits.php', {'tt':'Organización de Kits'}],
			['Armado de Kits', 'arm_kits.php', {'tt':'Armado de Kits'}],
			['Listado de Armado de Kits', 'listar_arm_kits.php', {'tt':'Listado de Armado de Kits'}],
			['Desarmado de Kits', 'desarm_kits.php', {'tt':'Desarmado de Kits'}],
			['Listado de Desarmado de Kits', 'listar_desarm_kits.php', {'tt':'Listado de Armado de Kits'}],
			['Listado de Kits', 'listarkits.php', {'tt':'Listar Armado de Kits'}]
		],
		['Envasado Distribución', null, null,
		 	['Rel Distribución MP', 'rel_env_dist.php', {'tt':'Relación Materia Prima con producto de Distribución'}],
			['Envasar Prod Distribución', 'env_dist.php', {'tt':'Envasado de Productos de Distribución'}],
			['Lista Envasado Distrib', 'list_env_dist.php', {'tt':'Listado de Productos de Distribución Envasado'}]
		],
		['Consulta', null, null,
		 	['Producción por Producto', 'buscarProducto.php', {'tt':'Selección de Producto a revisar Producciones'}]
		],
		['Control de Calidad', null, null,
			['Materia Prima', 'Buscar_mp.php', {'tt':'Crear Kits'}],
			['Producción', 'buscar_lote.php', {'tt':'Organización de Kits'}],
			['Producto Terminado', 'buscar_lote2.php', {'tt':'Armado de Kits'}]
		]
	],
	['Inventarios', null, null,
		['Actuales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['En Fecha', null, null,
			['Materia Prima', 'fch_inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'fch_inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'fch_inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
			['Envase', 'fch_inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'fch_inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'fch_inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Ajuste de Inventario', null, null,
			['Materia Prima', 'a_inv_mp.php', {'tt':'Ajuste Inventario de Materia Prima'}],
			['Producto Terminado', 'a_inv_prod.php', {'tt':'Ajuste Inventario de Producto Terminado'}],
			['Distribución', 'a_inv_dist.php', {'tt':'Ajuste Inventario de Producto de Distribución'}],
			['Envase', 'a_inv_env.php', {'tt':'Ajuste Inventario de Envase'}],
			['Tapas y válvulas', 'a_inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'a_inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Salida Productos', null, null,
			['Remisión', 'remision.php', {'tt':'Generar Orden de Producción'}],
			['Modificar Remision', 'buscarRemision.php', {'tt':'Modificar Remisión'}],
			['Baja de Producto', 'baja.php', {'tt':'Modificar información de uso de materia prima por lote'}]
		],
		['Desempaque Productos', null, null,
			['Desempacar', 'desempacar.php', {'tt':'Desempacar Productos de Distribución'}],
			['Empacar', 'empacar.php', {'tt':'Empacar Producto de Distribución'}]
		],
		['Envase a Distribución', null, null,
			['Cargar Envase', 'cargarEnvase.php', {'tt':'Cargar envase como producto de Distribución'}]
		],
		['Trazabilidad', null, null,
			['Materia Prima', 'bus_traz_mp.php', {'tt':'Trazabilidad de Materia Prima'}],
			['Producto Terminado', 'bus_traz_prod.php', {'tt':'Trazabilidad de Producto Terminado'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Creación', 'makeClienForm.php', {'tt':'Crear Cliente'}],
			['Actualización', 'buscarClien.php', {'tt':'Actualizar Cliente'}],
			['Eliminación', 'deleteClienForm.php', {'tt':'Eliminar Cliente'}],
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes Activos'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotización', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Crear Clientes de Cotización'}],
			['Listar Clientes', 'listarClientCot.php', {'tt':'Listar Clientes de Cotización'}],
			['Crear Cotización', 'cotizacion.php', {'tt':'Crear Cotización'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotización'}],
			['Listar', 'listarCotiza.php', {'tt':'Listar Cotizaciones'}]
		],
		['Pedido', null, null,
			['Crear Pedido', 'pedido.php', {'tt':'Ingresar Pedido'}],
			['Modificar Pedido', 'buscarPedido.php', {'tt':'Modificar Pedido'}],
			['Anular Pedido', 'anulaPedido.php', {'tt':'Anular Pedido'}],
			['Pedidos Anulados', 'listarPedidoA.php', {'tt':'Listar Pedidos Anulados'}],
			['Listar Pedidos', 'listarPedido.php', {'tt':'Listar Pedido'}],
			['Listar Pedidos Pendientes', 'listarPedidoP.php', {'tt':'Listar Pedidos Pendientes'}],
			['Revisar Pedidos Pendientes', 'sellistarPedido.php', {'tt':'Revisar Pedidos Pendientes'}]
		],
		['Factura', null, null,
			['Crear Factura', 'crearFactura.php', {'tt':'Crear Factura'}],
			['Modificar Factura', 'buscarFactura.php', {'tt':'Modificar Factura'}],
			['Habilitar Pedido', 'facturar.php', {'tt':'Habilitar Factura en Rojo'}],
			['Anular Factura', 'anularFactura.php', {'tt':'Anular Factura'}],
			['Listar Facturas', 'listarFacturas.php', {'tt':'Lista de Facturas'}]
		],
		['Nota Crédito', null, null,
			['Crear Nota Crédito', 'crearNotaC.php', {'tt':'Crear Nota Credito'}],
			['Modificar Nota Crédito', 'buscarNotaC.php', {'tt':'Modificar Nota Crédito'}],
			['Listar Notas Crédito', 'listarNotasC.php', {'tt':'Lista de Notas Crédito'}]
		],
		['Consulta', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Consulta Vendedor', 'buscarVendedor.php', {'tt':'Consultar Vendedor'}],
			['Consulta Facturas', 'consultaFacturas.php', {'tt':'Consulta de Facturas'}],
			['Ventas por Familia', 'consultaFamilia.php', {'tt':'Ventas por Familia de Productos'}],
			['Ventas por Producto', 'consultaProducto.php', {'tt':'Ventas por Referencia de Producto'}],
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisión'}]
		]
	],
	['Cartera', null, null,
		['Consulta', null, null,
			['General', 'factXcobrar.php', {'tt':'Consulta General de Cartera'}],
			['Por Cliente', 'buscarClien2.php', {'tt':'Consulta por Cliente de Cartera'}],
			['Estado de Cuenta', 'buscarClien3.php', {'tt':'Estado de Cuenta por Cliente'}]
		],
		['Recibo de Caja', null, null,
			['Generación', 'buscarClien4.php', {'tt':'Cobros por Cliente'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS2 = [
	['Administración', null, null,
	 	['Usuarios', null, null,
			['Cambio Contraseña', 'cambio.php', {'tt':'Cambio Contraseña'}]
		],
		['Personal', null, null,
			['Ingresar Personal', 'makePersonalForm.php', {'tt':'Ingresar Personal'}],
			['Actualizar Datos', 'buscarPersonal.php', {'tt':'Actualizar Datos'}],
			['Borrar Personal', 'deletePersonalForm.php', {'tt':'Borrar Personal'}],
			['Listar Personal', 'listarPersonal.php', {'tt':'Listar Personal'}]
		]	
	],
	['Listados Base', null, null,
		['Categorías Producto', null, null,
			['Listar', 'listarcateg.php', {'tt':'Listar Categorías de Producto'}]
		],
		['Categorías M. Prima', null, null,
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categorías de Materia Prima'}]
		],
		['Categorías Distribución', null, null,
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categorías de Producto de Distribución'}]
		],
		['Productos', null, null,
			['Listar', 'listarProd.php', {'tt':'Listar Producto'}]
		],
		['Materias Primas', null, null,
			['Listar', 'listarMP.php', {'tt':'Listar Materia Prima'}]
		],
		['Envase', null, null,
			['Listar', 'listarEnv.php', {'tt':'Listar Envase'}]
		],
		['Válvulas y Tapas', null, null,
			['Listar', 'listarVal.php', {'tt':'Listar Válvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['Código genérico', null, null,
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentación Producto', null, null,
			['Listar', 'listarmed.php', {'tt':'Listar Medidas'}]
		],
		['Distribución', null, null,
			['Crear', 'crearDis.php', {'tt':'Crear Producto de Distribución'}],
			['Modificar', 'buscarDis.php', {'tt':'Modificar Producto de Distribución'}],
			['Eliminar', 'deleteDisForm.php', {'tt':'Eliminar Producto de Distribución'}],
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribución'}]
		],
		['Rel Envase Distribución', null, null,
			['Listar Relaciones', 'listarenvaseDis.php', {'tt':'Listar Envases en de Distribución'}]
		],
		['Relación Paca Producto', null, null,
			['Listar Relaciones', 'listarDes.php', {'tt':'Listar Productos de Distribución'}]
		],
		['Tipos de Provedores', null, null,
			['Listar', 'listarCatProv.php', {'tt':'Listar Tipo de Proveedor'}]
		],
		['Tipos de Cliente', null, null,
			['Listar', 'listarCatCli.php', {'tt':'Listar Tipo de Cliente'}]
		]
	],
	['Compras', null, null,
	    ['Proveedor', null, null,
			['Crear', 'makeProvForm.php', {'tt':'Ingresar Proveedor'}],
			['Actualizar', 'buscarProv.php', {'tt':'Actualizar Datos Proveedor'}],
			['Listar', 'listarProv.php', {'tt':'Listar Proveedores'}]
		],
		['Materia Prima', null, null,
			['Consulta Provedor', 'consultaMp.php', {'tt':'Consulta de Compras por Proveedor de Materia Prima'}],
			['Consultar', 'listacompramp.php', {'tt':'Listado de Compras de Materia Prima'}]
		],
		['Envase Válvulas / Tapas', null, null,
			['Consulta Provedor', 'consultaEnv.php', {'tt':'Consulta de Compras por Proveedor de Envase y Tapas'}],
			['Consultar', 'listacompraenv.php', {'tt':'Listado de Compras de Envase y tapas'}]
		],
		['Etiquetas', null, null,
			['Consulta Provedor', 'consultaEtq.php', {'tt':'Consulta de Compras por Proveedor de Etiqueta'}],
			['Consultar', 'listacompraetq.php', {'tt':'Listado de Compras de Etiquetas'}]
		],
		['Distribución', null, null,
			['Ingresar', 'compradist.php', {'tt':'Ingresar compra de Producto de Distribución'}],
			['Modificar', 'buscarcompradist.php', {'tt':'Modificar compra de Producto de Distribución'}],
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribución'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribución'}]
		],
		['Gastos', null, null,
			['Ingresar', 'gasto.php', {'tt':'Ingresar Gastos de Oficina'}],
			['Modificar', 'buscargasto.php', {'tt':'Modificar Gastos de Oficina'}],
			['Consulta Provedor', 'consultaGas.php', {'tt':'Consulta de Compras por Proveedor de Gastos'}],
			['Consultar', 'listagastos.php', {'tt':'Listado de Gastos de Oficina'}]
		],
		['Consultas', null, null,
			['Compras', 'consultaCompras.php', {'tt':'Consulta de Compras por Fecha'}],
			['Gastos', 'consultaGastos.php', {'tt':'Consulta de Gastos por Fecha'}],
			['Por Producto Distribución', 'buscarDist.php', {'tt':'Consulta de Compra por Producto de Distribución'}]
		],
		['Tesorería', null, null,
			['Facturas por Pagar General', 'factXpagar.php', {'tt':'Lista de Facturas por Pagar General'}],
			['Facturas por Pagar Proveedor', 'buscarProv2.php', {'tt':'Lista de Facturas por Pagar por Proveedor'}]
		]
	],
	['Producción', null, null,
		['Kits', null, null,
			['Crear Kits', 'crear_kits.php', {'tt':'Crear Kits'}],
			['Organización de Kits', 'org_kits.php', {'tt':'Organización de Kits'}],
			['Armado de Kits', 'arm_kits.php', {'tt':'Armado de Kits'}],
			['Desarmado de Kits', 'desarm_kits.php', {'tt':'Desarmado de Kits'}],
			['Listado de Kits', 'listarkits.php', {'tt':'Listar Armado de Kits'}]
		],
		['Envasado Distribución', null, null,
		 	['Rel Distribución MP', 'rel_env_dist.php', {'tt':'Relación Materia Prima con producto de Distribución'}],
			['Envasar Prod Distribución', 'env_dist.php', {'tt':'Envasado de Productos de Distribución'}],
			['Lista Envasado Distrib', 'list_env_dist.php', {'tt':'Listado de Productos de Distribución Envasado'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Salida Productos', null, null,
			['Remisión', 'remision.php', {'tt':'Generar Orden de Producción'}],
			['Baja de Producto', 'baja.php', {'tt':'Modificar información de uso de materia prima por lote'}]
		],
		['Desempaque Productos', null, null,
			['Desempacar', 'desempacar.php', {'tt':'Desempacar Productos de Distribución'}],
			['Empacar', 'empacar.php', {'tt':'Empacar Producto de Distribución'}]
		],
		['Envase a Distribución', null, null,
			['Cargar Envase', 'cargarEnvase.php', {'tt':'Cargar envase como producto de Distribución'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Creación', 'makeClienForm.php', {'tt':'Crear Cliente'}],
			['Actualización', 'buscarClien.php', {'tt':'Actualizar Cliente'}],
			['Eliminación', 'deleteClienForm.php', {'tt':'Eliminar Cliente'}],
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes Activos'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotización', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Crear Clientes de Cotización'}],
			['Listar Clientes', 'listarClientCot.php', {'tt':'Listar Clientes de Cotización'}],
			['Crear Cotización', 'cotizacion.php', {'tt':'Crear Cotización'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotización'}],
			['Listar', 'listarCotiza.php', {'tt':'Listar Cotizaciones'}]
		],
		['Pedido', null, null,
			['Crear Pedido', 'pedido.php', {'tt':'Ingresar Pedido'}],
			['Modificar Pedido', 'buscarPedido.php', {'tt':'Modificar Pedido'}],
			['Anular Pedido', 'anulaPedido.php', {'tt':'Anular Pedido'}],
			['Pedidos Anulados', 'listarPedidoA.php', {'tt':'Listar Pedidos Anulados'}],
			['Listar Pedidos', 'listarPedido.php', {'tt':'Listar Pedido'}],
			['Listar Pedidos Pendientes', 'listarPedidoP.php', {'tt':'Listar Pedidos Pendientes'}],
			['Revisar Pedidos Pendientes', 'sellistarPedido.php', {'tt':'Revisar Pedidos Pendientes'}]
		],
		['Factura', null, null,
			['Crear Factura', 'crearFactura.php', {'tt':'Crear Factura'}],
			['Modificar Factura', 'buscarFactura.php', {'tt':'Modificar Factura'}],
			['Anular Factura', 'anularFactura.php', {'tt':'Anular Factura'}],
			['Listar Facturas', 'listarFacturas.php', {'tt':'Lista de Facturas'}]
		],
		['Nota Crédito', null, null,
			['Crear Nota Crédito', 'crearNotaC.php', {'tt':'Crear Nota Credito'}],
			['Modificar Nota Crédito', 'buscarNotaC.php', {'tt':'Modificar Nota Crédito'}],
			['Listar Notas Crédito', 'listarNotasC.php', {'tt':'Lista de Notas Crédito'}]
		],
		['Consulta', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Consulta Facturas', 'consultaFacturas.php', {'tt':'Consulta de Facturas'}],
			['Ventas por Familia', 'consultaFamilia.php', {'tt':'Ventas por Familia de Productos'}],
			['Ventas por Producto', 'consultaProducto.php', {'tt':'Ventas por Referencia de Producto'}],
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisión'}]
		]
	],
	['Cartera', null, null,
		['Consulta', null, null,
			['General', 'factXcobrar.php', {'tt':'Consulta General de Cartera'}],
			['Por Cliente', 'buscarClien2.php', {'tt':'Consulta por Cliente de Cartera'}],
			['Estado de Cuenta', 'buscarClien3.php', {'tt':'Estado de Cuenta por Cliente'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS3 = [
	['Administración', null, null,
	 	['Usuarios', null, null,
			['Cambio Contraseña', 'cambio.php', {'tt':'Cambio Contraseña'}]
		]
	],
	['Producción', null, null,
		['Orden de Producción', null, null,
			['Crear O. Producción', 'o_produccion.php', {'tt':'Generar Orden de Producción'}],
			['Anular O. Producción', 'anular_O_produccion.php', {'tt':'Anular Orden de Producción'}],
			['O. Producción anuladas', 'listarOrProdA.php', {'tt':'Listado de Órdenes de Producción Anuladas'}],
			['Listar O. Producción', 'listarOrProd.php', {'tt':'Listado de Órdenes de Producción'}]
		],
		['Soluciones de Color', null, null,
			['Crear Solución de Color', 'o_produccion_color.php', {'tt':'Generar Orden de Producción de Solución de Color'}],
			['Listar O. Producción Color', 'listarOrProd_color.php', {'tt':'Listado de Órdenes de Producción de Color'}]
		],
		['Envasado', null, null,
			['Listar productos por Lote', 'listarEnvasado.php', {'tt':'Listado de Productos por Órdenes de Producción'}]
		],
		['Kits', null, null,
			['Armado de Kits', 'arm_kits.php', {'tt':'Armado de Kits'}],
			['Listado de Kits', 'listarkits.php', {'tt':'Listar Armado de Kits'}]
		],
		['Envasado Distribución', null, null,
			['Envasar Prod Distribución', 'env_dist.php', {'tt':'Envasado de Productos de Distribución'}],
			['Lista Envasado Distrib', 'list_env_dist.php', {'tt':'Listado de Productos de Distribución Envasado'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS4 = [
	['Administración', null, null,
		['Usuarios', null, null,
			['Cambio Contraseña', 'cambio.php', {'tt':'Cambio Contraseña'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes'}]
		],
		['Factura', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Listar', 'listarFacturas.php', {'tt':'Lista de Facturas'}]
		]
	],
	['Cartera', null, null,
		['Consulta', null, null,
			['General', 'factXcobrar.php', {'tt':'Consulta General de Cartera'}],
			['Por Cliente', 'buscarClien2.php', {'tt':'Consulta por Cliente de Cartera'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS5 = [
	['Administración', null, null,
		['Usuarios', null, null,
			['Cambio Contraseña', 'cambio.php', {'tt':'Cambio Contraseña'}]
		]
	],
	['Listados Base', null, null,
		['Categorías Producto', null, null,
			['Listar', 'listarcateg.php', {'tt':'Listar Categorías de Producto'}]
		],
		['Categorías M. Prima', null, null,
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categorías de Materia Prima'}]
		],
		['Categorías Distribución', null, null,
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categorías de Producto de Distribución'}]
		],
		['Productos', null, null,
			['Listar', 'listarProd.php', {'tt':'Listar Producto'}]
		],
		['Materias Primas', null, null,
			['Listar', 'listarMP.php', {'tt':'Listar Materia Prima'}]
		],
		['Envase', null, null,
			['Listar', 'listarEnv.php', {'tt':'Listar Envase'}]
		],
		['Válvulas y Tapas', null, null,
			['Listar', 'listarVal.php', {'tt':'Listar Válvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['Código genérico', null, null,
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentación Producto', null, null,
			['Listar', 'listarmed.php', {'tt':'Listar Medidas'}]
		],
		['Distribución', null, null,
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribución'}]
		],
		['Tipos de Provedores', null, null,
			['Listar', 'listarCatProv.php', {'tt':'Listar Tipo de Proveedor'}]
		],
		['Tipos de Cliente', null, null,
			['Listar', 'listarCatCli.php', {'tt':'Listar Tipo de Cliente'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Creación', 'makeClienForm.php', {'tt':'Crear Cliente'}],
			['Actualización', 'buscarClien.php', {'tt':'Actualizar Cliente'}],
			['Eliminación', 'deleteClienForm.php', {'tt':'Eliminar Cliente'}],
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes Activos'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotización', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Crear Clientes de Cotización'}],
			['Listar Clientes', 'listarClientCot.php', {'tt':'Listar Clientes de Cotización'}],
			['Crear Cotización', 'cotizacion.php', {'tt':'Crear Cotización'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotización'}],
			['Listar', 'listarCotiza.php', {'tt':'Listar Cotizaciones'}]
		],
		['Pedido', null, null,
			['Crear Pedido', 'pedido.php', {'tt':'Ingresar Pedido'}],
			['Modificar Pedido', 'buscarPedido.php', {'tt':'Modificar Pedido'}],
			['Anular Pedido', 'anulaPedido.php', {'tt':'Anular Pedido'}],
			['Pedidos Anulados', 'listarPedidoA.php', {'tt':'Listar Pedidos Anulados'}],
			['Listar Pedidos', 'listarPedido.php', {'tt':'Listar Pedido'}],
			['Listar Pedidos Pendientes', 'listarPedidoP.php', {'tt':'Listar Pedidos Pendientes'}]
		],
		['Factura', null, null,
			['Crear Factura', 'crearFactura.php', {'tt':'Crear Factura'}],
			['Modificar Factura', 'buscarFactura.php', {'tt':'Modificar Factura'}],
			['Habilitar Pedido', 'facturar.php', {'tt':'Habilitar Factura en Rojo'}],
			['Anular Factura', 'anularFactura.php', {'tt':'Anular Factura'}],
			['Listar Facturas', 'listarFacturas.php', {'tt':'Lista de Facturas'}]
		],
		['Consulta', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Consulta Vendedor', 'buscarVendedor.php', {'tt':'Consultar Vendedor'}],
			['Consulta Facturas', 'consultaFacturas.php', {'tt':'Consulta de Facturas'}],
			['Ventas por Familia', 'consultaFamilia.php', {'tt':'Ventas por Familia de Productos'}],
			['Ventas por Producto', 'consultaProducto.php', {'tt':'Ventas por Referencia de Producto'}],
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisión'}]
		]
	],
	['Cartera', null, null,
		['Consulta', null, null,
			['General', 'factXcobrar.php', {'tt':'Consulta General de Cartera'}],
			['Por Cliente', 'buscarClien2.php', {'tt':'Consulta por Cliente de Cartera'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];

var MENU_ITEMS6 = [
	['Administración', null, null,
	 	['Usuarios', null, null,
			['Cambio Contraseña', 'cambio.php', {'tt':'Cambio Contraseña'}]
		]
	],
	['Listados Base', null, null,
		['Categorías Producto', null, null,
			['Listar', 'listarcateg.php', {'tt':'Listar Categorías de Producto'}]
		],
		['Categorías M. Prima', null, null,
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categorías de Materia Prima'}]
		],
		['Categorías Distribución', null, null,
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categorías de Producto de Distribución'}]
		],
		['Productos', null, null,
			['Listar', 'listarProd.php', {'tt':'Listar Producto'}]
		],
		['Materias Primas', null, null,
			['Listar', 'listarMP.php', {'tt':'Listar Materia Prima'}]
		],
		['Envase', null, null,
			['Listar', 'listarEnv.php', {'tt':'Listar Envase'}]
		],
		['Válvulas y Tapas', null, null,
			['Listar', 'listarVal.php', {'tt':'Listar Válvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['Código genérico', null, null,
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentación Producto', null, null,
			['Listar', 'listarmed.php', {'tt':'Listar Medidas'}]
		],
		['Distribución', null, null,
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribución'}]
		],
		['Tipos de Provedores', null, null,
			['Listar', 'listarCatProv.php', {'tt':'Listar Tipo de Proveedor'}]
		],
		['Tipos de Cliente', null, null,
			['Listar', 'listarCatCli.php', {'tt':'Listar Tipo de Cliente'}]
		]
	],
	['Compras', null, null,
		['Proveedor', null, null,
			['Listar', 'listarProv.php', {'tt':'Listar Proveedores'}]
		],
		['Materia Prima', null, null,
			['Consulta Provedor', 'consultaMp.php', {'tt':'Consulta de Compras por Proveedor de Materia Prima'}],
			['Consultar', 'listacompramp.php', {'tt':'Listado de Compras de Materia Prima'}]
		],
		['Envase Válvulas / Tapas', null, null,
			['Consulta Provedor', 'consultaEnv.php', {'tt':'Consulta de Compras por Proveedor de Envase y Tapas'}],
			['Consultar', 'listacompraenv.php', {'tt':'Listado de Compras de Envase y tapas'}]
		],
		['Etiquetas', null, null,
			['Consulta Provedor', 'consultaEtq.php', {'tt':'Consulta de Compras por Proveedor de Etiqueta'}],
			['Consultar', 'listacompraetq.php', {'tt':'Listado de Compras de Etiquetas'}]
		],
		['Distribución', null, null,
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribución'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribución'}]
		],
		['Gastos', null, null,
			['Consulta Provedor', 'consultaGas.php', {'tt':'Consulta de Compras por Proveedor de Gastos'}],
			['Consultar', 'listagastos.php', {'tt':'Listado de Gastos de Oficina'}]
		],
		['Consultas', null, null,
			['Compras', 'consultaCompras.php', {'tt':'Consulta de Compras por Fecha'}],
			['Gastos', 'consultaGastos.php', {'tt':'Consulta de Gastos por Fecha'}],
			['Por Producto Distribución', 'buscarDist.php', {'tt':'Consulta de Compra por Producto de Distribución'}],
			['Por Materia Prima', 'buscarMateriaP.php', {'tt':'Consulta de Compra por Materia Prima'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes Activos'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotización', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Crear Clientes de Cotización'}],
			['Listar Clientes', 'listarClientCot.php', {'tt':'Listar Clientes de Cotización'}],
			['Crear Cotización', 'cotizacion.php', {'tt':'Crear Cotización'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotización'}],
			['Listar', 'listarCotiza.php', {'tt':'Listar Cotizaciones'}]
		],
		['Pedido', null, null,
			['Crear Pedido', 'pedido.php', {'tt':'Ingresar Pedido'}],
			['Modificar Pedido', 'buscarPedido.php', {'tt':'Modificar Pedido'}],
			['Anular Pedido', 'anulaPedido.php', {'tt':'Anular Pedido'}],
			['Pedidos Anulados', 'listarPedidoA.php', {'tt':'Listar Pedidos Anulados'}],
			['Listar Pedidos', 'listarPedido.php', {'tt':'Listar Pedido'}],
			['Listar Pedidos Pendientes', 'listarPedidoP.php', {'tt':'Listar Pedidos Pendientes'}]
		],
		['Factura', null, null,
			['Crear Factura', 'crearFactura.php', {'tt':'Crear Factura'}],
			['Modificar Factura', 'buscarFactura.php', {'tt':'Modificar Factura'}],
			['Habilitar Pedido', 'facturar.php', {'tt':'Habilitar Factura en Rojo'}],
			['Anular Factura', 'anularFactura.php', {'tt':'Anular Factura'}],
			['Listar Facturas', 'listarFacturas.php', {'tt':'Lista de Facturas'}]
		],
		['Consulta', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Consulta Facturas', 'consultaFacturas.php', {'tt':'Consulta de Facturas'}],
			['Ventas por Familia', 'consultaFamilia.php', {'tt':'Ventas por Familia de Productos'}],
			['Ventas por Producto', 'consultaProducto.php', {'tt':'Ventas por Referencia de Producto'}],
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisión'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS7 = [
	['Administración', null, null,
	 	['Usuarios', null, null,
			['Cambio Contraseña', 'cambio.php', {'tt':'Cambio Contraseña'}],
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
		],
		['Consulta de Stock', null, null,
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Creación', 'makeClienForm.php', {'tt':'Crear Cliente'}],
			['Actualización', 'buscarClien.php', {'tt':'Actualizar Cliente'}],
			['Eliminación', 'deleteClienForm.php', {'tt':'Eliminar Cliente'}],
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotización', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Ingresar Cotización'}],
			['Crear Cotización', 'cotizacion.php', {'tt':'Ingresar Cotización'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotización'}],
			['Listar', 'listarCotiza.php', {'tt':'Listar Cotizaciones'}]
		],
		['Pedido', null, null,
			['Crear', 'pedido.php', {'tt':'Ingresar Pedido'}],
			['Modificar', 'buscarPedido.php', {'tt':'Modificar Pedido'}],
			['Listar', 'listarPedido.php', {'tt':'Listar Pedido'}]
		],
		['Factura', null, null,
			['Crear', 'crearFactura.php', {'tt':'Crear Factura'}],
			['Modificar', 'buscarFactura.php', {'tt':'Modificar Factura'}],
			['Anular', 'anularFactura.php', {'tt':'Anular Factura'}],
			['Listar', 'listarFacturas.php', {'tt':'Lista de Facturas'}]
		],
		['Consulta', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Consulta Vendedor', 'buscarVendedor.php', {'tt':'Consultar Vendedor'}],
			['Consulta Facturas', 'consultaFacturas.php', {'tt':'Consulta de Facturas'}],
			['Ventas por Familia', 'consultaFamilia.php', {'tt':'Ventas por Familia de Productos'}],
			['Ventas por Producto', 'consultaProducto.php', {'tt':'Ventas por Referencia de Producto'}],
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisión'}]
		]
	],
	['Cartera', null, null,
		['Consulta', null, null,
			['General', 'factXcobrar.php', {'tt':'Consulta General de Cartera'}],
			['Por Cliente', 'buscarClien2.php', {'tt':'Consulta por Cliente de Cartera'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS8 = [
	['Administración', null, null,
	 	['Usuarios', null, null,
			['Cambio Contraseña', 'cambio.php', {'tt':'Cambio Contraseña'}]
		]
	],
	['Compras', null, null,
		['Proveedor', null, null,
			['Listar', 'listarProv.php', {'tt':'Listar Proveedores'}]
		],
		['Materia Prima', null, null,
			['Consulta Provedor', 'consultaMp.php', {'tt':'Consulta de Compras por Proveedor de Materia Prima'}],
			['Consultar', 'listacompramp.php', {'tt':'Listado de Compras de Materia Prima'}]
		],
		['Envase Válvulas / Tapas', null, null,
			['Consulta Provedor', 'consultaEnv.php', {'tt':'Consulta de Compras por Proveedor de Envase y Tapas'}],
			['Consultar', 'listacompraenv.php', {'tt':'Listado de Compras de Envase y tapas'}]
		],
		['Etiquetas', null, null,
			['Consulta Provedor', 'consultaEtq.php', {'tt':'Consulta de Compras por Proveedor de Etiqueta'}],
			['Consultar', 'listacompraetq.php', {'tt':'Listado de Compras de Etiquetas'}]
		],
		['Distribución', null, null,
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribución'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribución'}]
		],
		['Gastos', null, null,
			['Consulta Provedor', 'consultaGas.php', {'tt':'Consulta de Compras por Proveedor de Gastos'}],
			['Consultar', 'listagastos.php', {'tt':'Listado de Gastos de Oficina'}]
		],
		['Consultas', null, null,
			['Compras', 'consultaCompras.php', {'tt':'Consulta de Compras por Fecha'}],
			['Gastos', 'consultaGastos.php', {'tt':'Consulta de Gastos por Fecha'}],
			['Por Producto Distribución', 'buscarDist.php', {'tt':'Consulta de Compra por Producto de Distribución'}],
			['Por Materia Prima', 'buscarMateriaP.php', {'tt':'Consulta de Compra por Materia Prima'}]
		],
		['Tesorería', null, null,
			['Facturas por Pagar General', 'factXpagar.php', {'tt':'Lista de Facturas por Pagar General'}],
			['Facturas por Pagar Proveedor', 'buscarProv2.php', {'tt':'Lista de Facturas por Pagar por Proveedor'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Pedido', null, null,
			['Listar', 'listarPedido.php', {'tt':'Listar Pedido'}]
		],
		['Factura', null, null,
			['Listar', 'listarFacturas.php', {'tt':'Lista de Facturas'}]
		],
		['Consulta', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Consulta Facturas', 'consultaFacturas.php', {'tt':'Consulta de Facturas'}],
			['Ventas por Familia', 'consultaFamilia.php', {'tt':'Ventas por Familia de Productos'}],
			['Ventas por Producto', 'consultaProducto.php', {'tt':'Ventas por Referencia de Producto'}],
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisión'}]
		]
	],
	['Cartera', null, null,
		['Consulta', null, null,
			['General', 'factXcobrar.php', {'tt':'Consulta General de Cartera'}],
			['Por Cliente', 'buscarClien2.php', {'tt':'Consulta por Cliente de Cartera'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS9 = [
	
	['Listados Base', null, null,
		['Categorías Producto', null, null,
			['Listar', 'listarcateg.php', {'tt':'Listar Categorías de Producto'}]
		],
		['Categorías M. Prima', null, null,
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categorías de Materia Prima'}]
		],
		['Categorías Distribución', null, null,
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categorías de Producto de Distribución'}]
		],
		['Productos', null, null,
			['Listar', 'listarProd.php', {'tt':'Listar Producto'}]
		],
		['Materias Primas', null, null,
			['Crear', 'crearMP.php', {'tt':'Crear Materia Prima'}],
			['Modificar', 'buscarMP.php', {'tt':'Modificar Materia Prima'}],
			['Eliminar', 'deleteMPForm.php', {'tt':'Eliminar Materia Prima'}],
			['Listar', 'listarMP.php', {'tt':'Listar Materia Prima'}]
		],
		['Envase', null, null,
			['Crear', 'crearEnv.php', {'tt':'Crear Envase'}],
			['Modificar', 'buscarEnv.php', {'tt':'Modificar Envase'}],
			['Eliminar', 'deleteEnvForm.php', {'tt':'Eliminar Envase'}],
			['Listar', 'listarEnv.php', {'tt':'Listar Envase'}]
		],
		['Válvulas y Tapas', null, null,
			['Crear', 'crearVal.php', {'tt':'Crear Válvula o Tapa'}],
			['Modificar', 'buscarVal.php', {'tt':'Modificar Válvula o Tapa'}],
			['Eliminar', 'deleteValForm.php', {'tt':'Eliminar Válvula o Tapa'}],
			['Listar', 'listarVal.php', {'tt':'Listar Válvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Crear', 'crearEtq.php', {'tt':'Crear Etiquetas'}],
			['Modificar', 'buscarEtq.php', {'tt':'Modificar Etiquetas'}],
			['Eliminar', 'deleteEtqForm.php', {'tt':'Eliminar Etiquetas'}],
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['Código genérico', null, null,
			['Crear', 'crearCod.php', {'tt':'Crear Medida'}],
			['Modificar', 'buscarCod.php', {'tt':'Modificar Medida'}],
			['Eliminar', 'deleteCodForm.php', {'tt':'Eliminar Medida'}],
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentación Producto', null, null,
			['Crear', 'crearMedida.php', {'tt':'Crear Medida'}],
			['Modificar', 'buscarMed.php', {'tt':'Modificar Medida'}],
			['Eliminar', 'deleteMedForm.php', {'tt':'Eliminar Medida'}],
			['Listar', 'listarmed.php', {'tt':'Listar Medidas'}]
		],
		['Distribución', null, null,
			['Crear', 'crearDis.php', {'tt':'Crear Producto de Distribución'}],
			['Modificar', 'buscarDis.php', {'tt':'Modificar Producto de Distribución'}],
			['Eliminar', 'deleteDisForm.php', {'tt':'Eliminar Producto de Distribución'}],
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribución'}]
		],
		['Rel Envase Distribución', null, null,
			['Crear Relación', 'envaseDis.php', {'tt':'Crear Relación de Envase a Producto de Distribución'}],
			['Listar Relaciones', 'listarenvaseDis.php', {'tt':'Listar Envases en de Distribución'}]
		],
		['Relación Paca Producto', null, null,
			['Crear Relación', 'crearDes.php', {'tt':'Crear Relación de Paca a Producto de Distribución'}],
			['Listar Relaciones', 'listarDes.php', {'tt':'Listar Productos de Distribución'}]
		],
		['Tipos de Provedores', null, null,
			['Crear', 'crearCatProv.php', {'tt':'Crear Tipo de Proveedor'}],
			['Modificar', 'buscarCatProv.php', {'tt':'Modificar Tipo de Proveedor'}],
			['Eliminar', 'deleteCatProvForm.php', {'tt':'Eliminar Tipo de Proveedor'}],
			['Listar', 'listarCatProv.php', {'tt':'Listar Tipo de Proveedor'}]
		],
		['Tipos de Cliente', null, null,
			['Crear', 'crearCatCli.php', {'tt':'Crear Tipo de Cliente'}],
			['Modificar', 'buscarCatCli.php', {'tt':'Modificar Tipo de Cliente'}],
			['Eliminar', 'deleteCatCliForm.php', {'tt':'Eliminar Tipo de Cliente'}],
			['Listar', 'listarCatCli.php', {'tt':'Listar Tipo de Cliente'}]
		]
	],
	['Compras', null, null,
		['Proveedor', null, null,
			['Crear', 'makeProvForm.php', {'tt':'Ingresar Proveedor'}],
			['Actualizar', 'buscarProv.php', {'tt':'Actualizar Datos Proveedor'}],
			['Eliminar', 'deleteProvForm.php', {'tt':'Eliminar Proveedor'}],
			['Listar', 'listarProv.php', {'tt':'Listar Proveedores'}]
		],
		['Materia Prima', null, null,
			['Ingresar', 'compramp.php', {'tt':'Ingresar Compra Materia Prima'}],
			['Modificar', 'buscarcompramp.php', {'tt':'Modificar Compra Materia Prima'}],
			['Consulta Provedor', 'consultaMp.php', {'tt':'Consulta de Compras por Proveedor de Materia Prima'}],
			['Consultar', 'listacompramp.php', {'tt':'Listado de Compras de Materia Prima'}]
		],
		['Envase Válvulas / Tapas', null, null,
			['Ingresar', 'compraenv.php', {'tt':'Ingresar compra de Envase y tapas'}],
			['Modificar', 'buscarcompraenv.php', {'tt':'Modificar compra de Envase y tapas'}],
			['Consulta Provedor', 'consultaEnv.php', {'tt':'Consulta de Compras por Proveedor de Envase y Tapas'}],
			['Consultar', 'listacompraenv.php', {'tt':'Listado de Compras de Envase y tapas'}]
		],
		['Etiquetas', null, null,
			['Ingresar', 'compraetq.php', {'tt':'Ingresar compra de Etiquetas'}],
			['Modificar', 'buscarcompraetq.php', {'tt':'Modificar compra de Etiquetas'}],
			['Consulta Provedor', 'consultaEtq.php', {'tt':'Consulta de Compras por Proveedor de Etiqueta'}],
			['Consultar', 'listacompraetq.php', {'tt':'Listado de Compras de Etiquetas'}]
		],
		['Distribución', null, null,
			['Ingresar', 'compradist.php', {'tt':'Ingresar compra de Producto de Distribución'}],
			['Modificar', 'buscarcompradist.php', {'tt':'Modificar compra de Producto de Distribución'}],
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribución'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribución'}]
		]
	],
	['Producción', null, null,
		['Formulaciones', null, null,
			['Crear Fórmula Producto', 'formula.php', {'tt':'Ingresar Fórmula de Producto'}],
			['Modificar Fórmula Producto', 'buscarform.php', {'tt':'Modificar la Fórmula de Producto'}],
			['Eliminar Fórmula Producto', 'deleteFormula.php', {'tt':'Eliminar Fórmula de Producto'}],
			['Crear Fórmula de Color', 'formula_col.php', {'tt':'Ingresar Fórmula de Producto'}],
			['Modificar Fórmula de Color', 'buscarform_col.php', {'tt':'Modificar la Fórmula de Producto'}],
			['Eliminar Fórmula de Color', 'deleteFormula_col.php', {'tt':'Eliminar Fórmula de Producto'}]
		],
		['Órdenes de Producción', null, null,
			['Crear O. Producción', 'o_produccion.php', {'tt':'Generar Orden de Producción'}],
			['Modificar uso de MP', 'buscarOprod.php', {'tt':'Modificar información de uso de materia prima por lote'}],
			['Anular O. Producción', 'anular_O_produccion.php', {'tt':'Anular Orden de Producción'}],
			['O. Producción anuladas', 'listarOrProdA.php', {'tt':'Listado de Órdenes de Producción Anuladas'}],
			['Listar O. Producción', 'listarOrProd.php', {'tt':'Listado de Órdenes de Producción'}]
		],
		['Soluciones de Color', null, null,
			['Crear Solución de Color', 'o_produccion_color.php', {'tt':'Generar Orden de Producción de Solución de Color'}],
			['Modificar uso de MP', 'buscarOprod_color.php', {'tt':'Modificar información de uso de materia prima por lote de solución'}],
			['Listar O. Producción Color', 'listarOrProd_color.php', {'tt':'Listado de Órdenes de Producción de Color'}]
		],
		['Envasado', null, null,
			['Envasado', 'Envasado.php', {'tt':'Envasado por Orden de Producción'}],
			['Listar productos por Lote', 'listarEnvasado.php', {'tt':'Listado de Productos por Órdenes de Producción'}],
			['O. Producción por envasar', 'listarOrProdsinE.php', {'tt':'Listado de Órdenes de Producción sin Envasar'}]
		],
		['Reenvase', null, null,
			['Crear', 'cambio_pres.php', {'tt':'Ingresar Cambios de Producto'}],
			['Listar', 'listarCambios.php', {'tt':'Listar cambios de Producto'}]
		],
		['Kits', null, null,
			['Crear Kits', 'crear_kits.php', {'tt':'Crear Kits'}],
			['Organización de Kits', 'org_kits.php', {'tt':'Organización de Kits'}],
			['Armado de Kits', 'arm_kits.php', {'tt':'Armado de Kits'}],
			['Desarmado de Kits', 'desarm_kits.php', {'tt':'Desarmado de Kits'}],
			['Listado de Kits', 'listarkits.php', {'tt':'Listar Armado de Kits'}]
		],
		['Envasado Distribución', null, null,
		 	['Rel Distribución MP', 'rel_env_dist.php', {'tt':'Relación Materia Prima con producto de Distribución'}],
			['Envasar Prod Distribución', 'env_dist.php', {'tt':'Envasado de Productos de Distribución'}],
			['Lista Envasado Distrib', 'list_env_dist.php', {'tt':'Listado de Productos de Distribución Envasado'}]
		],
		['Consulta', null, null,
		 	['Producción por Producto', 'buscarProducto.php', {'tt':'Selección de Producto a revisar Producciones'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribución', 'inv_dist.php', {'tt':'Inventario Productos de Distribución'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y válvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Ajuste de Inventario', null, null,
			['Materia Prima', 'a_inv_mp.php', {'tt':'Ajuste Inventario de Materia Prima'}],
			['Producto Terminado', 'a_inv_prod.php', {'tt':'Ajuste Inventario de Producto Terminado'}],
			['Distribución', 'a_inv_dist.php', {'tt':'Ajuste Inventario de Producto de Distribución'}],
			['Envase', 'a_inv_env.php', {'tt':'Ajuste Inventario de Envase'}],
			['Tapas y válvulas', 'a_inv_tap.php', {'tt':'Inventario de Tapas y/o Válvulas'}],
			['Etiquetas', 'a_inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Salida Productos', null, null,
			['Remisión', 'remision.php', {'tt':'Generar Orden de Producción'}],
			['Baja de Producto', 'baja.php', {'tt':'Modificar información de uso de materia prima por lote'}]
		],
		['Desempaque Productos', null, null,
			['Desempacar', 'desempacar.php', {'tt':'Desempacar Productos de Distribución'}],
			['Empacar', 'empacar.php', {'tt':'Empacar Producto de Distribución'}]
		],
		['Envase a Distribución', null, null,
			['Cargar Envase', 'cargarEnvase.php', {'tt':'Cargar envase como producto de Distribución'}]
		]
	],

	['Salir', 'exit.php', {'tt':'Salir'}]
];