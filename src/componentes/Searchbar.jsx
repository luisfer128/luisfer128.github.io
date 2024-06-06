import React, { useState } from 'react';
import { Box, Typography, Button, TextField, Container } from '@mui/material';
import SearchIcon from '@mui/icons-material/Search';


function SearchBar() {
    const [value, setValue] = useState('');
        //valida si el valor ingresado contiene solo números enteros antes de actualizar el estado
    const handleChange = (event) => {
        const newValue = event.target.value;
            if (/^\d*$/.test(newValue)) {
            setValue(newValue);
        }
  };

  return (
    <Box ml={2}>
        <Container>
            <Typography variant="h4" color="black" mb={1}>
                ¿Buscas tu dispositivo?
            </Typography>
            <Typography variant="body1" color="textSecondary" mb={1}>
                Ingresa el número de tu factura en el siguiente espacio y haz clic en buscar.
            </Typography>
        </Container>
        <Box display="flex" alignItems="center" mt={4} mb={4}>
            <TextField
                id="buscar"
                label="Número de factura"
                variant="outlined"
                value={value}
                onChange={handleChange}
                inputProps={{
                  inputMode: 'numeric',
                  pattern: '[0-9]*',
                  'aria-label': 'Buscar'
                }}
                sx={{ mr: 2,  width: '300px' }}
            />
            <Button
                variant="contained"
                color="secondary"
                size="large"
                startIcon={<SearchIcon />}
                sx={{ width: '140px' }}
            >
                Buscar
            </Button>
        </Box>
    </Box>
  );
}

export default SearchBar;
