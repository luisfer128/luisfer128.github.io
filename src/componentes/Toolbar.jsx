import React from "react";
import { AppBar, Box, Button, Toolbar as MuiToolbar, Typography } from '@mui/material';


function Toolbar() {
    return (
        <Box sx={{ flexGrow: 1 }}>
        <AppBar position="static" sx={{bgcolor:'green'}}>
          <MuiToolbar>
            <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
              Sapito Store
            </Typography>
            <Typography variant="h6" component="div" sx={{ marginRight: '10px' }}>
            </Typography>
            <Button color="inherit">
                Inicio
            </Button>
            <Button color="inherit">
               Mi movil
            </Button>
          </MuiToolbar>
        </AppBar>
      </Box>
    );
}
export default Toolbar;