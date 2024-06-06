import React from "react";
import { AppBar, Box, Button, Toolbar as MuiToolbar, Typography } from '@mui/material';


function Toolbar() {
    return (
        <Box sx={{ flexGrow: 1 }}>
        <AppBar position="static" sx={{background: 'linear-gradient(90deg, rgba(21,80,59,1) 0%, rgba(21,80,59,1) 50%)',}}>
          <MuiToolbar>
            <Typography variant="h6" component="div" sx={{ flexGrow: 1, textAlign:'left' }}>
              ServiSapito
            </Typography>
            <Typography variant="h6" component="div" sx={{ marginRight: '10px' }}>
            </Typography>
            <Button color="inherit">
              Inicio
            </Button>
            <Button color="inherit">
              Mi movil
            </Button>
            <Button color="inherit">
              Cotizacion
            </Button>
          </MuiToolbar>
        </AppBar>
      </Box>
    );
}
export default Toolbar;