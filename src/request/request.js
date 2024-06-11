import React, { useEffect, useState } from 'react';
import { Box, Typography, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, CircularProgress, Alert } from '@mui/material';

function ConsumeApi({ facturaNumero }) {
    const [data, setData] = useState(null);
    const [error, setError] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchData = async () => {
            setLoading(true);
            setError(null);
            try {
                const response = await fetch(`http://100.113.27.1:3200/reparaciones/${facturaNumero}`);
                if (!response.ok) {
                    throw new Error(`No se ha encontrado registro de esta factura`);
                }
                const jsonData = await response.json();
                if (jsonData.data && typeof jsonData.data === 'object' && !Array.isArray(jsonData.data)) {
                    setData([jsonData.data]); // Convertir a array
                } else {
                    setData(jsonData.data); // Dejar como está si ya es un array
                }
            } catch (error) {
                setError(error);
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, [facturaNumero]);

    if (loading) {
        return <CircularProgress />;
    }

    if (error) {
        return (
            <Alert severity="error">
                Error al cargar los datos: {error.message}
            </Alert>
        );
    }

    return (
        <Box className='app' color={'black'}>
            <Typography variant="h4" gutterBottom>Datos</Typography>
            <TableContainer component={Paper}>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell>Técnico</TableCell>
                            <TableCell>Producto</TableCell>
                            <TableCell>Estado</TableCell>
                            <TableCell>Cliente</TableCell>
                            <TableCell>Fecha Ingreso</TableCell>
                            <TableCell>Fecha Salida</TableCell>
                            <TableCell>Teléfono Contacto</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {data && data.map((reparacion, index) => (
                            <TableRow key={index}>
                                <TableCell>{reparacion.Tecnico}</TableCell>
                                <TableCell>{reparacion.Producto}</TableCell>
                                <TableCell>{reparacion.Estado}</TableCell>
                                <TableCell>{reparacion.Cliente}</TableCell>
                                <TableCell>{new Date(reparacion.FechaIngreso).toISOString().split('T')[0]}</TableCell>
                                <TableCell>{reparacion.FechaSalida ? new Date(reparacion.FechaSalida).toISOString().split('T')[0] : ''}</TableCell>
                                <TableCell>{reparacion.TelefonoCliente}</TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </Box>
    );
}

export default ConsumeApi;
