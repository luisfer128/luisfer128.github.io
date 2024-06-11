import React, { useState, useEffect } from 'react';
import { Typography, TextField, Container, Button, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Modal, Select, MenuItem, InputLabel, FormControl } from '@mui/material';

function Factura({ facturaNumero }) {
    const [filter, setFilter] = useState('');
    const [data, setData] = useState([]);
    const [technicians, setTechnicians] = useState([]);
    const [products, setProducts] = useState([]);
    const [states, setStates] = useState([]);
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(true);
    const [editingId, setEditingId] = useState(null);
    const [editFormData, setEditFormData] = useState({});
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [isInsertModalOpen, setIsInsertModalOpen] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');

    useEffect(() => {
        const fetchData = async () => {
            setLoading(true);
            setError(null);
            try {
                const responseReparaciones = await fetch(`http://100.113.27.1:3200/reparaciones`);
                if (!responseReparaciones.ok) {
                    throw new Error(`No se ha encontrado registro de facturas`);
                }
                const jsonDataReparaciones = await responseReparaciones.json();
                setData(jsonDataReparaciones.data);
                
                const technicianData = [
                    { id: 1, name: 'Luis Baldeon' },
                    { id: 2, name: 'Alexis Yagual' },
                    { id: 3, name: 'Steven Bazan' },
                    { id: 4, name: 'José revelo' }
                ];
                setTechnicians(technicianData);
                
                const productData = [
                    { id: 1, name: 'Pantalla' },
                    { id: 2, name: 'Batería' },
                    { id: 3, name: 'Cámara' },
                    { id: 4, name: 'Altavoz' }
                ];
                setProducts(productData);
                
                const stateData = [
                    { id: 1, name: 'Recibido' },
                    { id: 2, name: 'Reparando' },
                    { id: 3, name: 'Reparado' },
                    { id: 4, name: 'Entregado' }
                ];
                setStates(stateData);
            } catch (error) {
                setError(error);
            } finally {
                setLoading(false);
            }
        };
    
        fetchData();
    }, [facturaNumero]);
    
    //filtrar 
    const handleFilterChange = (event) => {
        setFilter(event.target.value);
    };

    const filtroFacturas = data.filter((item) =>
        Object.values(item).some((val) =>
            String(val).toLowerCase().includes(filter.toLowerCase())
        )
    );
    //eliminar
    const handleEliminarData = async (index) => {
        const idReparacion = data[index].idReparacion;

        // Mostrar un mensaje de confirmación antes de eliminar la reparación
        const confirmarEliminar = window.confirm('¿Estás seguro que quieres eliminar esta reparación?');

        // Verificar si el usuario confirmó la eliminación
        if (confirmarEliminar) {
            try {
                const response = await fetch(`http://100.113.27.1:3200/eliminarReparaciones/${idReparacion}`, {
                    method: 'DELETE'
                });

                if (!response.ok) {
                    throw new Error(`Error al eliminar la reparación con ID ${idReparacion}`);
                }

                // Actualizar los datos en el estado excluyendo la reparación eliminada
                const newData = data.filter((_, i) => i !== index);
                setData(newData);
            } catch (error) {
                console.error('Error:', error);
                setError(error);
            }
        }
    };

    //insertar
    
    const handleOpenInsertModal = () => {
        setIsInsertModalOpen(true);
    };
    const handleCloseInsertModal = () => {
        setIsInsertModalOpen(false);
    };
    const handleInsertarData = () => {
        handleOpenInsertModal(); 
    };

    const handleGuardarNuevaReparacion = async () => {
        // Verificar que los campos obligatorios no estén en blanco
        if (!editFormData.idTecnico || !editFormData.idProducto || !editFormData.idEstado || !editFormData.cedula || !editFormData.cliente || !editFormData.fechaIngreso || !editFormData.telefonoCliente) {
            setErrorMessage('¡Todos los campos son obligatorios!');
            return;
        }
    
        // Obtener los datos del formulario de inserción
        const requestData = {
            idTecnico: parseInt(editFormData.idTecnico),
            idProducto: parseInt(editFormData.idProducto),
            idEstado: parseInt(editFormData.idEstado),
            cedula: editFormData.cedula,
            cliente: editFormData.cliente,
            fechaIngreso: editFormData.fechaIngreso,
            fechaSalida: editFormData.fechaSalida,
            telefonoCliente: editFormData.telefonoCliente
        };
    
        try {
            // Realizar la solicitud POST para insertar una nueva reparación
            const response = await fetch('http://100.113.27.1:3200/crearReparaciones', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            });
            console.log(requestData);
    
            if (!response.ok) {
                throw new Error('Error al insertar la reparación');
            }
    
            // Actualizar los datos en el estado local
            const newReparacion = await response.json();
            setData([...data, newReparacion]);
    
            // Cerrar el modal de inserción
            setIsInsertModalOpen(false);
            window.location.reload();
        } catch (error) {
            console.error('Error al insertar la reparación:', error);
            setError(error);
        }
    };
    

    //editar
    const handleEditarData = (id) => {
        const editingReparacion = data.find(reparacion => reparacion.idReparacion === id);
        setEditingId(id);
        setEditFormData({ ...editingReparacion });
        setIsModalOpen(true); // Abrir el modal de edición
    };    
    
    const handleEditFormChange = (event) => {
        const { name, value } = event.target;
        setEditFormData({
            ...editFormData,
            [name]: value
        });
    };
     

    const handleCancelEdit = () => {
        setEditingId(null);
        setEditFormData({});
        setIsModalOpen(false); // Cerrar el modal de edición
    };

    const handleGuardarCambios = async () => {
        const idReparacion = editFormData.idReparacion;
    
        if (!idReparacion) {
            console.error('ID de reparación no encontrado en los datos de edición');
            return;
        }
    
        // Verificar que los campos obligatorios no estén en blanco
        if (!editFormData.idTecnico || !editFormData.idProducto || !editFormData.idEstado || !editFormData.cedula || !editFormData.cliente || !editFormData.fechaIngreso || !editFormData.telefonoCliente) {
            setErrorMessage('¡Todos los campos son obligatorios!');
            return;
        }
    
        // Crear el objeto de datos con el formato esperado
        const requestData = {
            idReparacion,
            idTecnico: parseInt(editFormData.idTecnico),
            idProducto: parseInt(editFormData.idProducto),
            idEstado: parseInt(editFormData.idEstado),
            cedula: editFormData.cedula,
            cliente: editFormData.cliente,
            fechaIngreso: editFormData.fechaIngreso,
            fechaSalida: editFormData.fechaSalida,
            telefonoCliente: editFormData.telefonoCliente
        };
    
        console.log(requestData);
    
        try {
            const response = await fetch(`http://100.113.27.1:3200/actualizarReparaciones/${idReparacion}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData) // Enviar los datos formateados
            });
    
            if (!response.ok) {
                throw new Error(`Error al actualizar la reparación con ID ${idReparacion}`);
            }
    
            // Actualizar los datos en el estado reemplazando la reparación editada
            const newData = data.map(reparacion => {
                if (reparacion.idReparacion === idReparacion) {
                    return { ...reparacion, ...editFormData }; // Actualizar la reparación específica
                }
                return reparacion;
            });

            setData(newData);
            setEditingId(null);
            setEditFormData({});
            setIsModalOpen(false); // Cerrar el modal de edición
            window.location.reload();
        } catch (error) {
            console.error('Error al actualizar la reparación:', error);
            setError(error);
        }
    };
       

    return (
        <Container>
            <TableContainer component={Paper}>
                <Typography variant="h4" gutterBottom sx={{ mt: 2 }}>Listado de Facturas</Typography>
                <TextField
                    label="Buscar"
                    variant="outlined"
                    margin="normal"
                    fullWidth
                    value={filter}
                    onChange={handleFilterChange}
                />
                <Button variant="contained" color="primary" onClick={handleInsertarData} sx={{ mb: 2 }}>
                    Insertar Datos
                </Button>
                {loading ? (
                    <Typography>Loading...</Typography>
                ) : error ? (
                    <Typography>Error: {error.message}</Typography>
                ) : (
                    <Table>
                        <TableHead>
                            <TableRow>
                                <TableCell>Técnico</TableCell>
                                <TableCell>Producto</TableCell>
                                <TableCell>Estado</TableCell>
                                <TableCell>Cliente</TableCell>
                                <TableCell>Fecha Ingreso</TableCell>
                                <TableCell>Fecha Salida</TableCell>
                                <TableCell>Teléfono Cliente</TableCell>
                                <TableCell>Acciones</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {filtroFacturas.map((reparacion, index) => (
                                <TableRow key={index}>
                                    <TableCell>{reparacion.Tecnico}</TableCell>
                                    <TableCell>{reparacion.Producto}</TableCell>
                                    <TableCell>{reparacion.Estado}</TableCell>
                                    <TableCell>{reparacion.Cliente}</TableCell>
                                    <TableCell>{reparacion.FechaIngreso ? new Date(reparacion.FechaIngreso).toISOString().split('T')[0] : ''}</TableCell>
                                    <TableCell>{reparacion.FechaSalida ? new Date(reparacion.FechaSalida).toISOString().split('T')[0] : ''}</TableCell>
                                    <TableCell>{reparacion.TelefonoCliente}</TableCell>
                                    <TableCell>
                                        <Button variant="contained" color="primary" onClick={() => handleEditarData(reparacion.idReparacion)}>Editar</Button>
                                        <Button variant="contained" color="secondary" onClick={() => handleEliminarData(index)}>Eliminar</Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                )}
            </TableContainer>
            
            {/* Modal de Edición */}
            <Modal
                open={isModalOpen}
                onClose={handleCancelEdit}
                style={{
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center'
                }}
            >
                <Container style={{
                    backgroundColor: 'white',
                    padding: '20px',
                    borderRadius: '8px',
                    maxWidth: '500px',
                    width: '100%'
                }}>
                    
                    <Typography variant="h4" gutterBottom>Editando Reparación</Typography>
                    <FormControl fullWidth margin="normal">
                        <InputLabel>Técnico</InputLabel>
                        <Select
                            value={editFormData.idTecnico || ''}
                            name="idTecnico"
                            onChange={handleEditFormChange}
                        >
                            {technicians.map(technician => (
                                <MenuItem key={technician.id} value={technician.id}>
                                    {technician.name}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                    <FormControl fullWidth margin="normal">
                        <InputLabel>Producto</InputLabel>
                        <Select
                            value={editFormData.idProducto || ''}
                            name="idProducto"
                            onChange={handleEditFormChange}
                        >
                            {products.map(product => (
                                <MenuItem key={product.id} value={product.id}>
                                    {product.name}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                    <FormControl fullWidth margin="normal">
                        <InputLabel>Estado</InputLabel>
                        <Select
                            value={editFormData.idEstado || ''}
                            name="idEstado"
                            onChange={handleEditFormChange}
                        >
                            {states.map(state => (
                                <MenuItem key={state.id} value={state.id}>
                                    {state.name}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                    <TextField
                        label="Cédula"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        name="cedula"
                        value={editFormData.cedula || ''}
                        onChange={handleEditFormChange}
                    />
                    <TextField
                        label="Cliente"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        name="cliente"
                        value={editFormData.cliente || ''}
                        onChange={handleEditFormChange}
                    />
                    <TextField
                        label="Fecha Ingreso"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        type="date"
                        name="fechaIngreso"
                        value={editFormData.fechaIngreso || ''}
                        onChange={handleEditFormChange}
                        InputLabelProps={{ shrink: true }}
                    />
                    <TextField
                        label="Fecha Salida *"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        type="date"
                        name="fechaSalida"
                        value={editFormData.fechaSalida || ''}
                        onChange={handleEditFormChange}
                        InputLabelProps={{ shrink: true }}
                    />
                    <TextField
                        label="Teléfono Cliente"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        name="telefonoCliente"
                        value={editFormData.telefonoCliente || ''}
                        onChange={handleEditFormChange}
                    />
                    {errorMessage && (
                        <Typography variant="body1" color="error" gutterBottom>
                            {errorMessage}
                        </Typography>
                    )}
                    <Button variant="contained" color="primary" onClick={handleGuardarCambios}>
                        Guardar Cambios
                    </Button>
                    <Button variant="contained" onClick={handleCancelEdit}>
                        Cancelar
                    </Button>
                    <Typography variant="body2" color="textSecondary" style={{ opacity: 0.7 }}>
                        *  Campo no obligatorio
                    </Typography>
                </Container>
            </Modal>

            {/* Modal de Inserción */}
            <Modal
                open={isInsertModalOpen}
                onClose={handleCloseInsertModal}
                style={{
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center'
                }}
                >
                <Container style={{
                    backgroundColor: 'white',
                    padding: '20px',
                    borderRadius: '8px',
                    maxWidth: '500px',
                    width: '100%'
                }}>
                    <FormControl fullWidth margin="normal">
                    <InputLabel>Técnico</InputLabel>
                    <Select
                        value={editFormData.idTecnico || ''}
                        name="idTecnico"
                        onChange={handleEditFormChange}
                    >
                        {technicians.map(technician => (
                            <MenuItem key={technician.id} value={technician.id}>
                                {technician.name}
                            </MenuItem>
                        ))}
                    </Select>
                </FormControl>
                <FormControl fullWidth margin="normal">
                    <InputLabel>Producto</InputLabel>
                    <Select
                        value={editFormData.idProducto || ''}
                        name="idProducto"
                        onChange={handleEditFormChange}
                    >
                        {products.map(product => (
                            <MenuItem key={product.id} value={product.id}>
                                {product.name}
                            </MenuItem>
                        ))}
                    </Select>
                </FormControl>
                    <FormControl fullWidth margin="normal">
                        <InputLabel>Estado</InputLabel>
                        <Select
                            value={editFormData.idEstado || ''}
                            name="idEstado"
                            onChange={handleEditFormChange}
                        >
                            {states.map(state => (
                                <MenuItem key={state.id} value={state.id}>
                                    {state.name}
                                </MenuItem>
                            ))}
                        </Select>
                    </FormControl>
                    <TextField
                        label="Cédula"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        name="cedula"
                        value={editFormData.cedula || ''}
                        onChange={handleEditFormChange}
                    />
                    <TextField
                        label="Cliente"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        name="cliente"
                        value={editFormData.cliente || ''}
                        onChange={handleEditFormChange}
                    />
                    <TextField
                        label="Fecha Ingreso"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        type="date"
                        name="fechaIngreso"
                        value={editFormData.fechaIngreso ? new Date(editFormData.fechaIngreso).toISOString().split('T')[0] : ''}
                        onChange={handleEditFormChange}
                        InputLabelProps={{ shrink: true }}
                    />
                    <TextField
                        label="Fecha Salida *"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        type="date"
                        name="fechaSalida"
                        value={editFormData.fechaSalida ? new Date(editFormData.fechaSalida).toISOString().split('T')[0] : ''}
                        onChange={handleEditFormChange}
                        InputLabelProps={{ shrink: true }}
                    />
                    <TextField
                        label="Teléfono Cliente"
                        variant="outlined"
                        margin="normal"
                        fullWidth
                        name="telefonoCliente"
                        value={editFormData.telefonoCliente || ''}
                        onChange={handleEditFormChange}
                    />
                    {errorMessage && (
                        <Typography variant="body1" color="error" gutterBottom>
                            {errorMessage}
                        </Typography>
                    )}
                    <Button variant="contained" color="primary" onClick={handleGuardarNuevaReparacion}>
                        Aceptar
                    </Button>
                    <Button variant="contained" onClick={handleCloseInsertModal}>
                        Cancelar
                    </Button>
                    <Typography variant="body2" color="textSecondary" style={{ opacity: 0.7 }}>
                        * Campo no obligatorio
                    </Typography>
                </Container>
            </Modal>


            
        </Container>
    );
}

export default Factura;
