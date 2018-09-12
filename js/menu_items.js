/* Tigra Menu items structure */
var MENU_ITEMS1 = [
	['Administraci�n', null, null,
	 	['Usuarios', null, null,
			['Ingresar Usuario', 'makeUserForm.php', {'tt':'Ingresar Usuario'}],
			['Cambio Contrase�a', 'cambio.php', {'tt':'Cambio Contrase�a'}],
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
		['Categor�as Producto', null, null,
			['Crear', 'crearCategoria.php', {'tt':'Crear Categor�a de Producto'}],
			['Modificar', 'buscarCat.php', {'tt':'Modificar Categor�a de Producto'}],
			['Eliminar', 'deleteCatForm.php', {'tt':'Eliminar Categor�a de Producto'}],
			['Listar', 'listarcateg.php', {'tt':'Listar Categor�as de Producto'}]
		],
		['Categor�as M. Prima', null, null,
			['Crear', 'crearCategoria_MP.php', {'tt':'Crear Categor�a de Materia Prima'}],
			['Modificar', 'buscarCat_MP.php', {'tt':'Modificar Categor�a de Materia Prima'}],
			['Eliminar', 'deleteCatForm_MP.php', {'tt':'Eliminar Categor�a de Materia Prima'}],
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categor�as de Materia Prima'}]
		],
		['Categor�as Distribuci�n', null, null,
			['Crear', 'crearCategoria_DIS.php', {'tt':'Crear Categor�a de Producto de Distribuci�n'}],
			['Modificar', 'buscarCat_DIS.php', {'tt':'Modificar Categor�a de Producto de Distribuci�n'}],
			['Eliminar', 'deleteCatForm_DIS.php', {'tt':'Eliminar Categor�a de Producto de Distribuci�n'}],
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categor�as de Producto de Distribuci�n'}]
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
		['V�lvulas y Tapas', null, null,
			['Crear', 'crearVal.php', {'tt':'Crear V�lvula o Tapa'}],
			['Modificar', 'buscarVal.php', {'tt':'Modificar V�lvula o Tapa'}],
			['Eliminar', 'deleteValForm.php', {'tt':'Eliminar V�lvula o Tapa'}],
			['Listar', 'listarVal.php', {'tt':'Listar V�lvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Crear', 'crearEtq.php', {'tt':'Crear Etiquetas'}],
			['Modificar', 'buscarEtq.php', {'tt':'Modificar Etiquetas'}],
			['Eliminar', 'deleteEtqForm.php', {'tt':'Eliminar Etiquetas'}],
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['C�digo gen�rico', null, null,
			['Crear', 'crearCod.php', {'tt':'Crear Medida'}],
			['Modificar', 'buscarCod.php', {'tt':'Modificar Medida'}],
			['Eliminar', 'deleteCodForm.php', {'tt':'Eliminar Medida'}],
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentaci�n Producto', null, null,
			['Crear', 'crearMedida.php', {'tt':'Crear Presentaci�n'}],
			['Modificar', 'buscarMed.php', {'tt':'Modificar Presentaci�n'}],
			['Eliminar', 'deleteMedForm.php', {'tt':'Eliminar Presentaci�n'}],
			['Listar', 'listarmed.php', {'tt':'Listar Presentaci�n'}],
			['Activar', 'buscarMed1.php', {'tt':'Activar Presentaci�n'}],
			['Desactivar', 'buscarMed2.php', {'tt':'Desactivar Presentaci�n'}]
		],
		['Distribuci�n', null, null,
			['Crear', 'crearDis.php', {'tt':'Crear Producto de Distribuci�n'}],
			['Modificar', 'buscarDis.php', {'tt':'Modificar Producto de Distribuci�n'}],
			['Eliminar', 'deleteDisForm.php', {'tt':'Eliminar Producto de Distribuci�n'}],
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribuci�n'}]
		],
		['Rel Envase Distribuci�n', null, null,
			['Crear Relaci�n', 'envaseDis.php', {'tt':'Crear Relaci�n de Envase a Producto de Distribuci�n'}],
			['Listar Relaciones', 'listarenvaseDis.php', {'tt':'Listar Envases en de Distribuci�n'}]
		],
		['Relaci�n Paca Producto', null, null,
			['Crear Relaci�n', 'crearDes.php', {'tt':'Crear Relaci�n de Paca a Producto de Distribuci�n'}],
			['Listar Relaciones', 'listarDes.php', {'tt':'Listar Productos de Distribuci�n'}]
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
		['Envase V�lvulas / Tapas', null, null,
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
		['Distribuci�n', null, null,
			['Ingresar', 'compradist.php', {'tt':'Ingresar compra de Producto de Distribuci�n'}],
			['Modificar', 'buscarcompradist.php', {'tt':'Modificar compra de Producto de Distribuci�n'}],
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribuci�n'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribuci�n'}]
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
			['Por Producto Distribuci�n', 'buscarDist.php', {'tt':'Consulta de Compra por Producto de Distribuci�n'}],
			['Por Materia Prima', 'buscarMateriaP.php', {'tt':'Consulta de Compra por Materia Prima'}],
			['Por Envase y Tapas', 'buscarEnvase_Tapas.php', {'tt':'Consulta de Compra de Envase Tapas'}]
		],
		['Tesorer�a', null, null,
			['Facturas por Pagar General', 'factXpagar.php', {'tt':'Lista de Facturas por Pagar General'}],
			['Facturas por Pagar Proveedor', 'buscarProv2.php', {'tt':'Lista de Facturas por Pagar por Proveedor'}],
			['Hist�rico de pagos General', 'histo_pagos.php', {'tt':'Hist�rico de Pagos General'}],
			['Hist�rico de pagos X Proveedor', 'buscarProv5.php', {'tt':'Hist�rico de Pagos por Proveedor'}],
			['Pagos de Compras General', 'pagosXcompras.php', {'tt':'Lista de Pagos realizados por Compras'}],
			['Pagos de Compras por Proveedor', 'buscarProv3.php', {'tt':'Lista de Pagos realizados por Compras por Proveedor'}],
			['Pagos de Gastos General', 'pagosXgastos.php', {'tt':'Lista de Pagos realizados por Compras'}],
			['Pagos de Gastos por Proveedor', 'buscarProv4.php', {'tt':'Lista de Pagos realizados por Compras por Proveedor'}]
		]
	],
	['Producci�n', null, null,
		['Formulaciones', null, null,
			['Crear F�rmula Producto', 'formula.php', {'tt':'Ingresar F�rmula de Producto'}],
			['Modificar F�rmula Producto', 'buscarform.php', {'tt':'Modificar la F�rmula de Producto'}],
			['Eliminar F�rmula Producto', 'deleteFormula.php', {'tt':'Eliminar F�rmula de Producto'}],
			['Crear F�rmula de Color', 'formula_col.php', {'tt':'Ingresar F�rmula de Producto'}],
			['Modificar F�rmula de Color', 'buscarform_col.php', {'tt':'Modificar la F�rmula de Producto'}],
			['Eliminar F�rmula de Color', 'deleteFormula_col.php', {'tt':'Eliminar F�rmula de Producto'}]
		],
		['�rdenes de Producci�n', null, null,
			['Crear O. Producci�n', 'o_produccion.php', {'tt':'Generar Orden de Producci�n'}],
			['Modificar uso de MP', 'buscarOprod.php', {'tt':'Modificar informaci�n de uso de materia prima por lote'}],
			['Anular O. Producci�n', 'anular_O_produccion.php', {'tt':'Anular Orden de Producci�n'}],
			['O. Producci�n anuladas', 'listarOrProdA.php', {'tt':'Listado de �rdenes de Producci�n Anuladas'}],
			['Listar O. Producci�n', 'listarOrProd.php', {'tt':'Listado de �rdenes de Producci�n'}]
		],
		['Soluciones de Color', null, null,
			['Crear Soluci�n de Color', 'o_produccion_color.php', {'tt':'Generar Orden de Producci�n de Soluci�n de Color'}],
			['Modificar uso de MP', 'buscarOprod_color.php', {'tt':'Modificar informaci�n de uso de materia prima por lote de soluci�n'}],
			['Listar O. Producci�n Color', 'listarOrProd_color.php', {'tt':'Listado de �rdenes de Producci�n de Color'}]
		],
		['Envasado', null, null,
			['Envasado', 'Envasado.php', {'tt':'Envasado por Orden de Producci�n'}],
			['Listar productos por Lote', 'listarEnvasado.php', {'tt':'Listado de Productos por �rdenes de Producci�n'}],
			['O. Producci�n por envasar', 'listarOrProdsinE.php', {'tt':'Listado de �rdenes de Producci�n sin Envasar'}]
		],
		['Reenvase', null, null,
			['Crear', 'cambio_pres.php', {'tt':'Ingresar Cambios de Producto'}],
			['Listar', 'listarCambios.php', {'tt':'Listar cambios de Producto'}]
		],
		['Kits', null, null,
			['Crear Kits', 'crear_kits.php', {'tt':'Crear Kits'}],
			['Organizaci�n de Kits', 'org_kits.php', {'tt':'Organizaci�n de Kits'}],
			['Armado de Kits', 'arm_kits.php', {'tt':'Armado de Kits'}],
			['Listado de Armado de Kits', 'listar_arm_kits.php', {'tt':'Listado de Armado de Kits'}],
			['Desarmado de Kits', 'desarm_kits.php', {'tt':'Desarmado de Kits'}],
			['Listado de Desarmado de Kits', 'listar_desarm_kits.php', {'tt':'Listado de Armado de Kits'}],
			['Listado de Kits', 'listarkits.php', {'tt':'Listar Armado de Kits'}]
		],
		['Envasado Distribuci�n', null, null,
		 	['Rel Distribuci�n MP', 'rel_env_dist.php', {'tt':'Relaci�n Materia Prima con producto de Distribuci�n'}],
			['Envasar Prod Distribuci�n', 'env_dist.php', {'tt':'Envasado de Productos de Distribuci�n'}],
			['Lista Envasado Distrib', 'list_env_dist.php', {'tt':'Listado de Productos de Distribuci�n Envasado'}]
		],
		['Consulta', null, null,
		 	['Producci�n por Producto', 'buscarProducto.php', {'tt':'Selecci�n de Producto a revisar Producciones'}]
		],
		['Control de Calidad', null, null,
			['Materia Prima', 'Buscar_mp.php', {'tt':'Crear Kits'}],
			['Producci�n', 'buscar_lote.php', {'tt':'Organizaci�n de Kits'}],
			['Producto Terminado', 'buscar_lote2.php', {'tt':'Armado de Kits'}]
		]
	],
	['Inventarios', null, null,
		['Actuales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribuci�n', 'inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['En Fecha', null, null,
			['Materia Prima', 'fch_inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'fch_inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribuci�n', 'fch_inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
			['Envase', 'fch_inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'fch_inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'fch_inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Ajuste de Inventario', null, null,
			['Materia Prima', 'a_inv_mp.php', {'tt':'Ajuste Inventario de Materia Prima'}],
			['Producto Terminado', 'a_inv_prod.php', {'tt':'Ajuste Inventario de Producto Terminado'}],
			['Distribuci�n', 'a_inv_dist.php', {'tt':'Ajuste Inventario de Producto de Distribuci�n'}],
			['Envase', 'a_inv_env.php', {'tt':'Ajuste Inventario de Envase'}],
			['Tapas y v�lvulas', 'a_inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'a_inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Salida Productos', null, null,
			['Remisi�n', 'remision.php', {'tt':'Generar Orden de Producci�n'}],
			['Modificar Remision', 'buscarRemision.php', {'tt':'Modificar Remisi�n'}],
			['Baja de Producto', 'baja.php', {'tt':'Modificar informaci�n de uso de materia prima por lote'}]
		],
		['Desempaque Productos', null, null,
			['Desempacar', 'desempacar.php', {'tt':'Desempacar Productos de Distribuci�n'}],
			['Empacar', 'empacar.php', {'tt':'Empacar Producto de Distribuci�n'}]
		],
		['Envase a Distribuci�n', null, null,
			['Cargar Envase', 'cargarEnvase.php', {'tt':'Cargar envase como producto de Distribuci�n'}]
		],
		['Trazabilidad', null, null,
			['Materia Prima', 'bus_traz_mp.php', {'tt':'Trazabilidad de Materia Prima'}],
			['Producto Terminado', 'bus_traz_prod.php', {'tt':'Trazabilidad de Producto Terminado'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Creaci�n', 'makeClienForm.php', {'tt':'Crear Cliente'}],
			['Actualizaci�n', 'buscarClien.php', {'tt':'Actualizar Cliente'}],
			['Eliminaci�n', 'deleteClienForm.php', {'tt':'Eliminar Cliente'}],
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes Activos'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotizaci�n', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Crear Clientes de Cotizaci�n'}],
			['Listar Clientes', 'listarClientCot.php', {'tt':'Listar Clientes de Cotizaci�n'}],
			['Crear Cotizaci�n', 'cotizacion.php', {'tt':'Crear Cotizaci�n'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotizaci�n'}],
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
		['Nota Cr�dito', null, null,
			['Crear Nota Cr�dito', 'crearNotaC.php', {'tt':'Crear Nota Credito'}],
			['Modificar Nota Cr�dito', 'buscarNotaC.php', {'tt':'Modificar Nota Cr�dito'}],
			['Listar Notas Cr�dito', 'listarNotasC.php', {'tt':'Lista de Notas Cr�dito'}]
		],
		['Consulta', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Consulta Vendedor', 'buscarVendedor.php', {'tt':'Consultar Vendedor'}],
			['Consulta Facturas', 'consultaFacturas.php', {'tt':'Consulta de Facturas'}],
			['Ventas por Familia', 'consultaFamilia.php', {'tt':'Ventas por Familia de Productos'}],
			['Ventas por Producto', 'consultaProducto.php', {'tt':'Ventas por Referencia de Producto'}],
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisi�n'}]
		]
	],
	['Cartera', null, null,
		['Consulta', null, null,
			['General', 'factXcobrar.php', {'tt':'Consulta General de Cartera'}],
			['Por Cliente', 'buscarClien2.php', {'tt':'Consulta por Cliente de Cartera'}],
			['Estado de Cuenta', 'buscarClien3.php', {'tt':'Estado de Cuenta por Cliente'}]
		],
		['Recibo de Caja', null, null,
			['Generaci�n', 'buscarClien4.php', {'tt':'Cobros por Cliente'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS2 = [
	['Administraci�n', null, null,
	 	['Usuarios', null, null,
			['Cambio Contrase�a', 'cambio.php', {'tt':'Cambio Contrase�a'}]
		],
		['Personal', null, null,
			['Ingresar Personal', 'makePersonalForm.php', {'tt':'Ingresar Personal'}],
			['Actualizar Datos', 'buscarPersonal.php', {'tt':'Actualizar Datos'}],
			['Borrar Personal', 'deletePersonalForm.php', {'tt':'Borrar Personal'}],
			['Listar Personal', 'listarPersonal.php', {'tt':'Listar Personal'}]
		]	
	],
	['Listados Base', null, null,
		['Categor�as Producto', null, null,
			['Listar', 'listarcateg.php', {'tt':'Listar Categor�as de Producto'}]
		],
		['Categor�as M. Prima', null, null,
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categor�as de Materia Prima'}]
		],
		['Categor�as Distribuci�n', null, null,
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categor�as de Producto de Distribuci�n'}]
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
		['V�lvulas y Tapas', null, null,
			['Listar', 'listarVal.php', {'tt':'Listar V�lvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['C�digo gen�rico', null, null,
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentaci�n Producto', null, null,
			['Listar', 'listarmed.php', {'tt':'Listar Medidas'}]
		],
		['Distribuci�n', null, null,
			['Crear', 'crearDis.php', {'tt':'Crear Producto de Distribuci�n'}],
			['Modificar', 'buscarDis.php', {'tt':'Modificar Producto de Distribuci�n'}],
			['Eliminar', 'deleteDisForm.php', {'tt':'Eliminar Producto de Distribuci�n'}],
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribuci�n'}]
		],
		['Rel Envase Distribuci�n', null, null,
			['Listar Relaciones', 'listarenvaseDis.php', {'tt':'Listar Envases en de Distribuci�n'}]
		],
		['Relaci�n Paca Producto', null, null,
			['Listar Relaciones', 'listarDes.php', {'tt':'Listar Productos de Distribuci�n'}]
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
		['Envase V�lvulas / Tapas', null, null,
			['Consulta Provedor', 'consultaEnv.php', {'tt':'Consulta de Compras por Proveedor de Envase y Tapas'}],
			['Consultar', 'listacompraenv.php', {'tt':'Listado de Compras de Envase y tapas'}]
		],
		['Etiquetas', null, null,
			['Consulta Provedor', 'consultaEtq.php', {'tt':'Consulta de Compras por Proveedor de Etiqueta'}],
			['Consultar', 'listacompraetq.php', {'tt':'Listado de Compras de Etiquetas'}]
		],
		['Distribuci�n', null, null,
			['Ingresar', 'compradist.php', {'tt':'Ingresar compra de Producto de Distribuci�n'}],
			['Modificar', 'buscarcompradist.php', {'tt':'Modificar compra de Producto de Distribuci�n'}],
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribuci�n'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribuci�n'}]
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
			['Por Producto Distribuci�n', 'buscarDist.php', {'tt':'Consulta de Compra por Producto de Distribuci�n'}]
		],
		['Tesorer�a', null, null,
			['Facturas por Pagar General', 'factXpagar.php', {'tt':'Lista de Facturas por Pagar General'}],
			['Facturas por Pagar Proveedor', 'buscarProv2.php', {'tt':'Lista de Facturas por Pagar por Proveedor'}]
		]
	],
	['Producci�n', null, null,
		['Kits', null, null,
			['Crear Kits', 'crear_kits.php', {'tt':'Crear Kits'}],
			['Organizaci�n de Kits', 'org_kits.php', {'tt':'Organizaci�n de Kits'}],
			['Armado de Kits', 'arm_kits.php', {'tt':'Armado de Kits'}],
			['Desarmado de Kits', 'desarm_kits.php', {'tt':'Desarmado de Kits'}],
			['Listado de Kits', 'listarkits.php', {'tt':'Listar Armado de Kits'}]
		],
		['Envasado Distribuci�n', null, null,
		 	['Rel Distribuci�n MP', 'rel_env_dist.php', {'tt':'Relaci�n Materia Prima con producto de Distribuci�n'}],
			['Envasar Prod Distribuci�n', 'env_dist.php', {'tt':'Envasado de Productos de Distribuci�n'}],
			['Lista Envasado Distrib', 'list_env_dist.php', {'tt':'Listado de Productos de Distribuci�n Envasado'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribuci�n', 'inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Salida Productos', null, null,
			['Remisi�n', 'remision.php', {'tt':'Generar Orden de Producci�n'}],
			['Baja de Producto', 'baja.php', {'tt':'Modificar informaci�n de uso de materia prima por lote'}]
		],
		['Desempaque Productos', null, null,
			['Desempacar', 'desempacar.php', {'tt':'Desempacar Productos de Distribuci�n'}],
			['Empacar', 'empacar.php', {'tt':'Empacar Producto de Distribuci�n'}]
		],
		['Envase a Distribuci�n', null, null,
			['Cargar Envase', 'cargarEnvase.php', {'tt':'Cargar envase como producto de Distribuci�n'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Creaci�n', 'makeClienForm.php', {'tt':'Crear Cliente'}],
			['Actualizaci�n', 'buscarClien.php', {'tt':'Actualizar Cliente'}],
			['Eliminaci�n', 'deleteClienForm.php', {'tt':'Eliminar Cliente'}],
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes Activos'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotizaci�n', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Crear Clientes de Cotizaci�n'}],
			['Listar Clientes', 'listarClientCot.php', {'tt':'Listar Clientes de Cotizaci�n'}],
			['Crear Cotizaci�n', 'cotizacion.php', {'tt':'Crear Cotizaci�n'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotizaci�n'}],
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
		['Nota Cr�dito', null, null,
			['Crear Nota Cr�dito', 'crearNotaC.php', {'tt':'Crear Nota Credito'}],
			['Modificar Nota Cr�dito', 'buscarNotaC.php', {'tt':'Modificar Nota Cr�dito'}],
			['Listar Notas Cr�dito', 'listarNotasC.php', {'tt':'Lista de Notas Cr�dito'}]
		],
		['Consulta', null, null,
			['Consulta Cliente', 'consultaCliente.php', {'tt':'Consultar Cliente'}],
			['Consulta Facturas', 'consultaFacturas.php', {'tt':'Consulta de Facturas'}],
			['Ventas por Familia', 'consultaFamilia.php', {'tt':'Ventas por Familia de Productos'}],
			['Ventas por Producto', 'consultaProducto.php', {'tt':'Ventas por Referencia de Producto'}],
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisi�n'}]
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
	['Administraci�n', null, null,
	 	['Usuarios', null, null,
			['Cambio Contrase�a', 'cambio.php', {'tt':'Cambio Contrase�a'}]
		]
	],
	['Producci�n', null, null,
		['Orden de Producci�n', null, null,
			['Crear O. Producci�n', 'o_produccion.php', {'tt':'Generar Orden de Producci�n'}],
			['Anular O. Producci�n', 'anular_O_produccion.php', {'tt':'Anular Orden de Producci�n'}],
			['O. Producci�n anuladas', 'listarOrProdA.php', {'tt':'Listado de �rdenes de Producci�n Anuladas'}],
			['Listar O. Producci�n', 'listarOrProd.php', {'tt':'Listado de �rdenes de Producci�n'}]
		],
		['Soluciones de Color', null, null,
			['Crear Soluci�n de Color', 'o_produccion_color.php', {'tt':'Generar Orden de Producci�n de Soluci�n de Color'}],
			['Listar O. Producci�n Color', 'listarOrProd_color.php', {'tt':'Listado de �rdenes de Producci�n de Color'}]
		],
		['Envasado', null, null,
			['Listar productos por Lote', 'listarEnvasado.php', {'tt':'Listado de Productos por �rdenes de Producci�n'}]
		],
		['Kits', null, null,
			['Armado de Kits', 'arm_kits.php', {'tt':'Armado de Kits'}],
			['Listado de Kits', 'listarkits.php', {'tt':'Listar Armado de Kits'}]
		],
		['Envasado Distribuci�n', null, null,
			['Envasar Prod Distribuci�n', 'env_dist.php', {'tt':'Envasado de Productos de Distribuci�n'}],
			['Lista Envasado Distrib', 'list_env_dist.php', {'tt':'Listado de Productos de Distribuci�n Envasado'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribuci�n', 'inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS4 = [
	['Administraci�n', null, null,
		['Usuarios', null, null,
			['Cambio Contrase�a', 'cambio.php', {'tt':'Cambio Contrase�a'}]
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
	['Administraci�n', null, null,
		['Usuarios', null, null,
			['Cambio Contrase�a', 'cambio.php', {'tt':'Cambio Contrase�a'}]
		]
	],
	['Listados Base', null, null,
		['Categor�as Producto', null, null,
			['Listar', 'listarcateg.php', {'tt':'Listar Categor�as de Producto'}]
		],
		['Categor�as M. Prima', null, null,
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categor�as de Materia Prima'}]
		],
		['Categor�as Distribuci�n', null, null,
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categor�as de Producto de Distribuci�n'}]
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
		['V�lvulas y Tapas', null, null,
			['Listar', 'listarVal.php', {'tt':'Listar V�lvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['C�digo gen�rico', null, null,
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentaci�n Producto', null, null,
			['Listar', 'listarmed.php', {'tt':'Listar Medidas'}]
		],
		['Distribuci�n', null, null,
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribuci�n'}]
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
			['Distribuci�n', 'inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Creaci�n', 'makeClienForm.php', {'tt':'Crear Cliente'}],
			['Actualizaci�n', 'buscarClien.php', {'tt':'Actualizar Cliente'}],
			['Eliminaci�n', 'deleteClienForm.php', {'tt':'Eliminar Cliente'}],
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes Activos'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotizaci�n', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Crear Clientes de Cotizaci�n'}],
			['Listar Clientes', 'listarClientCot.php', {'tt':'Listar Clientes de Cotizaci�n'}],
			['Crear Cotizaci�n', 'cotizacion.php', {'tt':'Crear Cotizaci�n'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotizaci�n'}],
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
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisi�n'}]
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
	['Administraci�n', null, null,
	 	['Usuarios', null, null,
			['Cambio Contrase�a', 'cambio.php', {'tt':'Cambio Contrase�a'}]
		]
	],
	['Listados Base', null, null,
		['Categor�as Producto', null, null,
			['Listar', 'listarcateg.php', {'tt':'Listar Categor�as de Producto'}]
		],
		['Categor�as M. Prima', null, null,
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categor�as de Materia Prima'}]
		],
		['Categor�as Distribuci�n', null, null,
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categor�as de Producto de Distribuci�n'}]
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
		['V�lvulas y Tapas', null, null,
			['Listar', 'listarVal.php', {'tt':'Listar V�lvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['C�digo gen�rico', null, null,
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentaci�n Producto', null, null,
			['Listar', 'listarmed.php', {'tt':'Listar Medidas'}]
		],
		['Distribuci�n', null, null,
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribuci�n'}]
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
		['Envase V�lvulas / Tapas', null, null,
			['Consulta Provedor', 'consultaEnv.php', {'tt':'Consulta de Compras por Proveedor de Envase y Tapas'}],
			['Consultar', 'listacompraenv.php', {'tt':'Listado de Compras de Envase y tapas'}]
		],
		['Etiquetas', null, null,
			['Consulta Provedor', 'consultaEtq.php', {'tt':'Consulta de Compras por Proveedor de Etiqueta'}],
			['Consultar', 'listacompraetq.php', {'tt':'Listado de Compras de Etiquetas'}]
		],
		['Distribuci�n', null, null,
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribuci�n'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribuci�n'}]
		],
		['Gastos', null, null,
			['Consulta Provedor', 'consultaGas.php', {'tt':'Consulta de Compras por Proveedor de Gastos'}],
			['Consultar', 'listagastos.php', {'tt':'Listado de Gastos de Oficina'}]
		],
		['Consultas', null, null,
			['Compras', 'consultaCompras.php', {'tt':'Consulta de Compras por Fecha'}],
			['Gastos', 'consultaGastos.php', {'tt':'Consulta de Gastos por Fecha'}],
			['Por Producto Distribuci�n', 'buscarDist.php', {'tt':'Consulta de Compra por Producto de Distribuci�n'}],
			['Por Materia Prima', 'buscarMateriaP.php', {'tt':'Consulta de Compra por Materia Prima'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribuci�n', 'inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes Activos'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotizaci�n', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Crear Clientes de Cotizaci�n'}],
			['Listar Clientes', 'listarClientCot.php', {'tt':'Listar Clientes de Cotizaci�n'}],
			['Crear Cotizaci�n', 'cotizacion.php', {'tt':'Crear Cotizaci�n'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotizaci�n'}],
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
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisi�n'}]
		]
	],
	['Salir', 'exit.php', {'tt':'Salir'}]
];
var MENU_ITEMS7 = [
	['Administraci�n', null, null,
	 	['Usuarios', null, null,
			['Cambio Contrase�a', 'cambio.php', {'tt':'Cambio Contrase�a'}],
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribuci�n', 'inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
		],
		['Consulta de Stock', null, null,
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}]
		]
	],
	['Ventas', null, null,
		['Cliente', null, null,
			['Creaci�n', 'makeClienForm.php', {'tt':'Crear Cliente'}],
			['Actualizaci�n', 'buscarClien.php', {'tt':'Actualizar Cliente'}],
			['Eliminaci�n', 'deleteClienForm.php', {'tt':'Eliminar Cliente'}],
			['Clientes Activos', 'listarClien2.php', {'tt':'Listar Clientes'}],
			['Clientes Inactivos', 'listarClien3.php', {'tt':'Listar Clientes no Activos'}]
		],
		['Cotizaci�n', null, null,
			['Crear Cliente', 'makeClienCotForm.php', {'tt':'Ingresar Cotizaci�n'}],
			['Crear Cotizaci�n', 'cotizacion.php', {'tt':'Ingresar Cotizaci�n'}],
			['Modificar', 'buscarCotiza.php', {'tt':'Modificar Cotizaci�n'}],
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
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisi�n'}]
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
	['Administraci�n', null, null,
	 	['Usuarios', null, null,
			['Cambio Contrase�a', 'cambio.php', {'tt':'Cambio Contrase�a'}]
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
		['Envase V�lvulas / Tapas', null, null,
			['Consulta Provedor', 'consultaEnv.php', {'tt':'Consulta de Compras por Proveedor de Envase y Tapas'}],
			['Consultar', 'listacompraenv.php', {'tt':'Listado de Compras de Envase y tapas'}]
		],
		['Etiquetas', null, null,
			['Consulta Provedor', 'consultaEtq.php', {'tt':'Consulta de Compras por Proveedor de Etiqueta'}],
			['Consultar', 'listacompraetq.php', {'tt':'Listado de Compras de Etiquetas'}]
		],
		['Distribuci�n', null, null,
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribuci�n'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribuci�n'}]
		],
		['Gastos', null, null,
			['Consulta Provedor', 'consultaGas.php', {'tt':'Consulta de Compras por Proveedor de Gastos'}],
			['Consultar', 'listagastos.php', {'tt':'Listado de Gastos de Oficina'}]
		],
		['Consultas', null, null,
			['Compras', 'consultaCompras.php', {'tt':'Consulta de Compras por Fecha'}],
			['Gastos', 'consultaGastos.php', {'tt':'Consulta de Gastos por Fecha'}],
			['Por Producto Distribuci�n', 'buscarDist.php', {'tt':'Consulta de Compra por Producto de Distribuci�n'}],
			['Por Materia Prima', 'buscarMateriaP.php', {'tt':'Consulta de Compra por Materia Prima'}]
		],
		['Tesorer�a', null, null,
			['Facturas por Pagar General', 'factXpagar.php', {'tt':'Lista de Facturas por Pagar General'}],
			['Facturas por Pagar Proveedor', 'buscarProv2.php', {'tt':'Lista de Facturas por Pagar por Proveedor'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribuci�n', 'inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
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
			['Consulta por Remision', 'consultaRemision.php', {'tt':'Consulta por Remisi�n'}]
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
		['Categor�as Producto', null, null,
			['Listar', 'listarcateg.php', {'tt':'Listar Categor�as de Producto'}]
		],
		['Categor�as M. Prima', null, null,
			['Listar', 'listarcateg_MP.php', {'tt':'Listar Categor�as de Materia Prima'}]
		],
		['Categor�as Distribuci�n', null, null,
			['Listar', 'listarcateg_DIS.php', {'tt':'Listar Categor�as de Producto de Distribuci�n'}]
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
		['V�lvulas y Tapas', null, null,
			['Crear', 'crearVal.php', {'tt':'Crear V�lvula o Tapa'}],
			['Modificar', 'buscarVal.php', {'tt':'Modificar V�lvula o Tapa'}],
			['Eliminar', 'deleteValForm.php', {'tt':'Eliminar V�lvula o Tapa'}],
			['Listar', 'listarVal.php', {'tt':'Listar V�lvulas y Tapas'}]
		],
		['Etiquetas', null, null,
			['Crear', 'crearEtq.php', {'tt':'Crear Etiquetas'}],
			['Modificar', 'buscarEtq.php', {'tt':'Modificar Etiquetas'}],
			['Eliminar', 'deleteEtqForm.php', {'tt':'Eliminar Etiquetas'}],
			['Listar', 'listarEtq.php', {'tt':'Listar Etiquetas'}]
		],
		['C�digo gen�rico', null, null,
			['Crear', 'crearCod.php', {'tt':'Crear Medida'}],
			['Modificar', 'buscarCod.php', {'tt':'Modificar Medida'}],
			['Eliminar', 'deleteCodForm.php', {'tt':'Eliminar Medida'}],
			['Listar', 'listarCod.php', {'tt':'Listar Medidas'}]
		],
		['Presentaci�n Producto', null, null,
			['Crear', 'crearMedida.php', {'tt':'Crear Medida'}],
			['Modificar', 'buscarMed.php', {'tt':'Modificar Medida'}],
			['Eliminar', 'deleteMedForm.php', {'tt':'Eliminar Medida'}],
			['Listar', 'listarmed.php', {'tt':'Listar Medidas'}]
		],
		['Distribuci�n', null, null,
			['Crear', 'crearDis.php', {'tt':'Crear Producto de Distribuci�n'}],
			['Modificar', 'buscarDis.php', {'tt':'Modificar Producto de Distribuci�n'}],
			['Eliminar', 'deleteDisForm.php', {'tt':'Eliminar Producto de Distribuci�n'}],
			['Listar', 'listarDis.php', {'tt':'Listar Productos de Distribuci�n'}]
		],
		['Rel Envase Distribuci�n', null, null,
			['Crear Relaci�n', 'envaseDis.php', {'tt':'Crear Relaci�n de Envase a Producto de Distribuci�n'}],
			['Listar Relaciones', 'listarenvaseDis.php', {'tt':'Listar Envases en de Distribuci�n'}]
		],
		['Relaci�n Paca Producto', null, null,
			['Crear Relaci�n', 'crearDes.php', {'tt':'Crear Relaci�n de Paca a Producto de Distribuci�n'}],
			['Listar Relaciones', 'listarDes.php', {'tt':'Listar Productos de Distribuci�n'}]
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
		['Envase V�lvulas / Tapas', null, null,
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
		['Distribuci�n', null, null,
			['Ingresar', 'compradist.php', {'tt':'Ingresar compra de Producto de Distribuci�n'}],
			['Modificar', 'buscarcompradist.php', {'tt':'Modificar compra de Producto de Distribuci�n'}],
			['Consulta Provedor', 'consultaDis.php', {'tt':'Consulta de Compras por Proveedor de productos de Distribuci�n'}],
			['Consultar', 'listacompradist.php', {'tt':'Listado de Compras de Productos de Distribuci�n'}]
		]
	],
	['Producci�n', null, null,
		['Formulaciones', null, null,
			['Crear F�rmula Producto', 'formula.php', {'tt':'Ingresar F�rmula de Producto'}],
			['Modificar F�rmula Producto', 'buscarform.php', {'tt':'Modificar la F�rmula de Producto'}],
			['Eliminar F�rmula Producto', 'deleteFormula.php', {'tt':'Eliminar F�rmula de Producto'}],
			['Crear F�rmula de Color', 'formula_col.php', {'tt':'Ingresar F�rmula de Producto'}],
			['Modificar F�rmula de Color', 'buscarform_col.php', {'tt':'Modificar la F�rmula de Producto'}],
			['Eliminar F�rmula de Color', 'deleteFormula_col.php', {'tt':'Eliminar F�rmula de Producto'}]
		],
		['�rdenes de Producci�n', null, null,
			['Crear O. Producci�n', 'o_produccion.php', {'tt':'Generar Orden de Producci�n'}],
			['Modificar uso de MP', 'buscarOprod.php', {'tt':'Modificar informaci�n de uso de materia prima por lote'}],
			['Anular O. Producci�n', 'anular_O_produccion.php', {'tt':'Anular Orden de Producci�n'}],
			['O. Producci�n anuladas', 'listarOrProdA.php', {'tt':'Listado de �rdenes de Producci�n Anuladas'}],
			['Listar O. Producci�n', 'listarOrProd.php', {'tt':'Listado de �rdenes de Producci�n'}]
		],
		['Soluciones de Color', null, null,
			['Crear Soluci�n de Color', 'o_produccion_color.php', {'tt':'Generar Orden de Producci�n de Soluci�n de Color'}],
			['Modificar uso de MP', 'buscarOprod_color.php', {'tt':'Modificar informaci�n de uso de materia prima por lote de soluci�n'}],
			['Listar O. Producci�n Color', 'listarOrProd_color.php', {'tt':'Listado de �rdenes de Producci�n de Color'}]
		],
		['Envasado', null, null,
			['Envasado', 'Envasado.php', {'tt':'Envasado por Orden de Producci�n'}],
			['Listar productos por Lote', 'listarEnvasado.php', {'tt':'Listado de Productos por �rdenes de Producci�n'}],
			['O. Producci�n por envasar', 'listarOrProdsinE.php', {'tt':'Listado de �rdenes de Producci�n sin Envasar'}]
		],
		['Reenvase', null, null,
			['Crear', 'cambio_pres.php', {'tt':'Ingresar Cambios de Producto'}],
			['Listar', 'listarCambios.php', {'tt':'Listar cambios de Producto'}]
		],
		['Kits', null, null,
			['Crear Kits', 'crear_kits.php', {'tt':'Crear Kits'}],
			['Organizaci�n de Kits', 'org_kits.php', {'tt':'Organizaci�n de Kits'}],
			['Armado de Kits', 'arm_kits.php', {'tt':'Armado de Kits'}],
			['Desarmado de Kits', 'desarm_kits.php', {'tt':'Desarmado de Kits'}],
			['Listado de Kits', 'listarkits.php', {'tt':'Listar Armado de Kits'}]
		],
		['Envasado Distribuci�n', null, null,
		 	['Rel Distribuci�n MP', 'rel_env_dist.php', {'tt':'Relaci�n Materia Prima con producto de Distribuci�n'}],
			['Envasar Prod Distribuci�n', 'env_dist.php', {'tt':'Envasado de Productos de Distribuci�n'}],
			['Lista Envasado Distrib', 'list_env_dist.php', {'tt':'Listado de Productos de Distribuci�n Envasado'}]
		],
		['Consulta', null, null,
		 	['Producci�n por Producto', 'buscarProducto.php', {'tt':'Selecci�n de Producto a revisar Producciones'}]
		]
	],
	['Inventarios', null, null,
		['Generales', null, null,
			['Materia Prima', 'inv_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'inv_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Distribuci�n', 'inv_dist.php', {'tt':'Inventario Productos de Distribuci�n'}],
			['Envase', 'inv_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Consulta de Stock', null, null,
			['Materia Prima', 'stock_mp.php', {'tt':'Inventario Materia Prima'}],
			['Producto Terminado', 'stock_prod.php', {'tt':'Inventario Producto Terminado'}],
			['Envase', 'stock_env.php', {'tt':'Inventario Envase'}],
			['Tapas y v�lvulas', 'stock_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'stock_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Ajuste de Inventario', null, null,
			['Materia Prima', 'a_inv_mp.php', {'tt':'Ajuste Inventario de Materia Prima'}],
			['Producto Terminado', 'a_inv_prod.php', {'tt':'Ajuste Inventario de Producto Terminado'}],
			['Distribuci�n', 'a_inv_dist.php', {'tt':'Ajuste Inventario de Producto de Distribuci�n'}],
			['Envase', 'a_inv_env.php', {'tt':'Ajuste Inventario de Envase'}],
			['Tapas y v�lvulas', 'a_inv_tap.php', {'tt':'Inventario de Tapas y/o V�lvulas'}],
			['Etiquetas', 'a_inv_etq.php', {'tt':'Inventario de Etiquetas'}]
		],
		['Salida Productos', null, null,
			['Remisi�n', 'remision.php', {'tt':'Generar Orden de Producci�n'}],
			['Baja de Producto', 'baja.php', {'tt':'Modificar informaci�n de uso de materia prima por lote'}]
		],
		['Desempaque Productos', null, null,
			['Desempacar', 'desempacar.php', {'tt':'Desempacar Productos de Distribuci�n'}],
			['Empacar', 'empacar.php', {'tt':'Empacar Producto de Distribuci�n'}]
		],
		['Envase a Distribuci�n', null, null,
			['Cargar Envase', 'cargarEnvase.php', {'tt':'Cargar envase como producto de Distribuci�n'}]
		]
	],

	['Salir', 'exit.php', {'tt':'Salir'}]
];