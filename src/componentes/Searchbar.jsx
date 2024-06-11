import React, { useState } from 'react';
import { Box, Typography, Button, TextField, Container, Modal } from '@mui/material';
import SearchIcon from '@mui/icons-material/Search';
import ConsumeApi from '../request/request';

function SearchBar() {
    const [value, setValue] = useState('');
    const [openModal, setOpenModal] = useState(false);
    const [showError, setShowError] = useState(false);

    // Handler para abrir el modal
    const handleOpenModal = () => {
        setOpenModal(true);
    };

    // Handler para cerrar el modal
    const handleCloseModal = () => {
        setOpenModal(false);
    };

    // Handler para manejar el cambio en el input y convertirlo a entero
    const handleChange = (event) => {
        const IdFactura = event.target.value;
        if (/^\d*$/.test(IdFactura)) {
            setValue(IdFactura);
            setShowError(false); 
        } else {
            setValue('');
        }
    };

    // Handler para manejar la búsqueda
    const handleSearch = () => {
        if (value.trim() !== '') {
            handleOpenModal();
        } else {
            setShowError(true); 
        }
    };

    return (
        <Container maxWidth="md">
            <Box display="flex" flexDirection="column" alignItems="center" mt={4}>
                <Typography variant="h4" color="black" mb={1}>
                    ¿Buscas tu dispositivo?
                </Typography>
                <Typography variant="body1" color="textSecondary" mb={1}>
                    Ingresa el número de tu factura en el siguiente espacio y haz clic en buscar.
                </Typography>
                <Box display="flex" alignItems="center" mt={2} mb={2}>
                    <TextField
                        id="buscar"
                        label="Número de factura"
                        variant="outlined"
                        value={isNaN(value) ? '' : value}
                        onChange={handleChange}
                        inputProps={{
                            inputMode: 'numeric',
                            pattern: '[0-9]*',
                            'aria-label': 'Buscar'
                        }}
                        sx={{ mr: 2, width: '300px' }}
                    />
                    <Button
                        variant="contained"
                        color="secondary"
                        size="large"
                        startIcon={<SearchIcon />}
                        sx={{ width: '140px' }}
                        onClick={handleSearch}
                    >
                        Buscar
                    </Button>
                </Box>
                {showError && (
                    <Typography variant="body1" color="error">
                        Llene el campo antes de buscar
                    </Typography>
                )}
                {/* Modal para mostrar los resultados */}
                <Modal
                    open={openModal}
                    onClose={handleCloseModal}
                    aria-labelledby="modal-title"
                    aria-describedby="modal-description"
                >
                    <Box
                        sx={{
                            position: 'absolute',
                            top: '50%',
                            left: '50%',
                            transform: 'translate(-50%, -50%)',
                            bgcolor: 'background.paper',
                            border: '2px solid #000',
                            boxShadow: 24,
                            p: 4,
                        }}
                    >
                        <Typography variant="h6" id="modal-title" gutterBottom>
                            Resultados de búsqueda
                        </Typography>
                        <ConsumeApi facturaNumero={value} />
                        <Button onClick={handleCloseModal} variant="contained" color="primary">
                            Cerrar
                        </Button>
                    </Box>
                </Modal>
            </Box>
        </Container>
    );
}

export default SearchBar;
